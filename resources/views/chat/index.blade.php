@extends('chat.base')


@section('scripts')
@endsection

@section('content')
    <div class="row">
        @foreach ($users as $user)
            <div class="border user-div col-12 mb-3">
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <p class="m-0">{{ $user->name }}</p>
                    <button class="btn btn-primary chat" chatUserId="{{ $user->id }}">Chat</button>
                </div>
            </div>
        @endforeach
    </div>



@endsection
