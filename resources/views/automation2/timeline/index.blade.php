@extends('layouts.popup.medium')

@section('class') 
full-height
@endsection

@section('content')  
    <div class="popup-fullheight">
        @include('automation2._tabs_timeline', ['tab' => 'statistics', 'sub' => trans('messages.automation.timeline')])
            
        <div class="timlines_list ajax-list"></div>
            
        <script>
            var listTimeline = new List( $('.timlines_list'), {
                url: '{{ action('Automation2Controller@timelineList', [
                        'uid' => $automation->uid,
                    ]) }}',
                per_page: 10,
                method: 'GET',
            });		
            listTimeline.load();
        </script>
    </div>
@endsection