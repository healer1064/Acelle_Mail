@extends('layouts.frontend')

@section('title', $campaign->name)

@section('page_script')
    <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/visualization/echarts/echarts.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/chart.js') }}"></script>
@endsection

@section('page_header')

			@include("campaigns._header")

@endsection

@section('content')

    @include("campaigns._menu")

    @if (!$campaign->template_id)
        <div class="row">
            <div class="col-md-6">
                @include('elements._notification', [
                    'level' => 'warning',
                    'message' => trans('messages.campaign.template.old_ver_error')
                ])
            </div>
        </div>
            
    @else
        <iframe class="preview_page_frame" src="{{ action('CampaignController@templateReviewIframe', $campaign->uid) }}" />
    @endif

@endsection
