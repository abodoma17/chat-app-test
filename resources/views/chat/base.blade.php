@extends('base')

@section('base_scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('/js/chat/pusher-manager.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            pusherManager.init();
            pusherManager.loggedInUserId = {{ auth()->user()->id }}
        });
    </script>
    @yield('scripts')
@endsection

@section('title')
    Chat App Test
@endsection

@section('base_content')
    @yield('content')
@endsection
