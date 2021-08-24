@if ($templates->count() > 0)
    <table class="table table-box pml-table"
        current-page="{{ empty(request()->page) ? 1 : empty(request()->page) }}">
        @foreach ($templates as $key => $template)
            <tr>
                <td width="1%">
                    <div class="text-nowrap">
                        <div class="checkbox inline">
                            <label>
                                <input type="checkbox" class="node styled"
                                    name="ids[]"
                                    value="{{ $template->uid }}"
                                />
                            </label>
                        </div>
                    </div>
                </td>
                <td width="1%">
                    <a href="#"  onclick="popupwindow('{{ action('TemplateController@preview', $template->uid) }}', '{{ $template->name }}', 800, 800)">
                        <img class="template-thumb" width="100" height="120" src="{{ $template->getThumbUrl() }}?v={{ rand(0,10) }}" />
                    </a>
                </td>
                <td>
                    <h5 class="no-margin text-bold">
                        <a class="kq_search" href="#" onclick="popupwindow('{{ action('TemplateController@preview', $template->uid) }}', '{{ $template->name }}', 800, 800)">
                            {{ $template->name }}
                        </a>
                    </h5>
                    <div class="text-muted">
                        {!! is_object($template->admin) ? '<i class="icon-user-tie" data="admin"></i>' . $template->admin->uid : '' !!}
                        {!! is_object($template->customer) ? '<i class="icon-user" data="customer"></i>' . $template->customer->uid : '' !!}
                    </div>
                    <span class="text-muted">{{ trans('messages.updated_at') }}: {{ Tool::formatDateTime($template->created_at) }}</span>
                </td>

                <td>
                    <div class="single-stat-box pull-left">
                        @if (Auth::user()->customer->can('update', $template))
                            <a href="{{ action('TemplateController@categories', [
                                'uid' => $template->uid,
                            ]) }}" class="no-margin stat-num template-categories">{{ $template->categories()->count() ? $template->categories->map(function ($cat) {
                                return $cat->name;
                            })->join(', ') : 'N/A' }}</a>
                        @else
                            <span class="no-margin stat-num template-categories">{{ $template->categories()->count() ? $template->categories->map(function ($cat) {
                                return $cat->name;
                            })->join(', ') : 'N/A' }}</span>
                        @endif
                        <br>
                        <span class="text-muted text-nowrap">{{ trans('messages.template.category') }}</span>
                    </div>
                </td>

                <td class="text-right">
                    @if (Auth::user()->customer->can('update', $template))
                        @if (in_array(Acelle\Model\Setting::get('builder'), ['both','pro']) && $template->builder)
                            <a href="{{ action('TemplateController@builderEdit', $template->uid) }}" type="button" class="btn btn-default btn-icon template-compose">
                                {{ trans('messages.template.pro_builder') }}
                            </a>
                        @endif
                        @if (in_array(Acelle\Model\Setting::get('builder'), ['both','classic']))
                            <a href="{{ action('TemplateController@edit', $template->uid) }}" type="button" class="btn bg-grey btn-icon template-compose-classic">
                                {{ trans('messages.template.classic_builder') }}
                            </a>
                        @endif
                    @endif
                    @if (Auth::user()->customer->can('preview', $template) ||
                        Auth::user()->customer->can('copy', $template) ||
                        Auth::user()->customer->can('delete', $template) ||
                        Auth::user()->customer->can('update', $template))
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret ml-0"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @if (Auth::user()->customer->can('preview', $template))
                                    <li><a href="#preview" onclick="popupwindow('{{ action('TemplateController@preview', $template->uid) }}', '{{ $template->name }}', 800, 800)"><i class="icon-zoomin3"></i> {{ trans("messages.preview") }}</a></li>
                                @endif
                                @if (Auth::user()->customer->can('update', $template))
                                    <li>
                                        <a class="upload-thumb-button" href="{{ action('TemplateController@updateThumb', $template->uid) }}">
                                            <i class="icon-file-picture"></i> {{ trans("messages.template.upload_thumbnail") }}
                                        </a>
                                    </li>
                                @endif
                                @if (Auth::user()->customer->can('update', $template))
                                    <li>
                                        <a class="template-categories" href="{{ action('TemplateController@categories', [
											'uid' => $template->uid,
										]) }}">
                                            <i class="icon-files-empty"></i> {{ trans("messages.template.categories") }}
                                        </a>
                                    </li>
                                @endif
                                @if (Auth::user()->customer->can('copy', $template))
                                    <li>
                                        <a
                                            href="{{ action('TemplateController@copy', $template->uid) }}"
                                            type="button"
                                            class="modal_link"
                                            data-method="GET"
                                        >
                                            <i class="icon-copy4"></i> {{ trans("messages.template.copy") }}
                                        </a>
                                    </li>
                                @endif
                                @if (Auth::user()->customer->can('delete', $template))
                                    <li><a delete-confirm="{{ trans('messages.delete_templates_confirm') }}" href="{{ action('TemplateController@delete', ["uids" => $template->uid]) }}"><i class="icon-trash"></i> {{ trans("messages.delete") }}</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    @include('elements/_per_page_select', ["items" => $templates])
    
    
    <script>
		var thumbPopup = new Popup();    
        var categoriesPopup = new Popup();           
    
        $('.upload-thumb-button').click(function(e) {
            e.preventDefault();
            
            var url = $(this).attr('href');
            
            thumbPopup.load(url);
        });

        $('.template-categories').click(function(e) {
            e.preventDefault();
            
            var url = $(this).attr('href');
            
            categoriesPopup.load(url);
        });
    </script>

@elseif (!empty(request()->keyword))
    <div class="empty-list">
        <i class="icon-magazine"></i>
        <span class="line-1">
            {{ trans('messages.no_search_result') }}
        </span>
    </div>
@else
    <div class="empty-list">
        <i class="icon-magazine"></i>
        <span class="line-1">
            {{ trans('messages.template_empty_line_1') }}
        </span>
    </div>
@endif
