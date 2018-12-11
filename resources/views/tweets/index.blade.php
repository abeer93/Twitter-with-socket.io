@extends('layouts.app')

@section('content')
    <h1>All Tweets</h1>
    <div id="btn-load" hidden>
        <button class="btn btn-primary" id="new-tweet-btn">load new tweets</button>
    </div>
    <div id="new-tweets-div" class="container" hidden></div>
    <div id="old-tweets-div" class="container">
        @foreach ($tweets as $tweet)
            <a href="{{ url('/tweets', $tweet->id) }}"><h2>{{ $tweet->title }}</h2></a>
            <p>{{ $tweet->description }}</p>
            <button class="btn" id="favBtnCount{{$tweet->id}}">{{ $tweet->FavsNum }}</button>
            @if($tweet->liked)
                <button class="btn btn-primary favBtn" value="{{$tweet->id}}" id="favBtnNum{{$tweet->id}}">Un-Favorite</button>
            @else
                <button class="btn btn-default favBtn" value="{{$tweet->id}}" id="favBtnNum{{$tweet->id}}">Favorite</button>
            @endif
        @endforeach
    </div>
    {{ $tweets->links() }}
    <input hidden id="logged-user-id" value="{{ Auth::user()->id }}" />
    <input hidden id="domain-url" value="{{ url('/') }}" />

@endsection

@section('scripts')
    <script src="{{asset('js/socket/socket.io/socket.io.js')}}"></script>
    <script src="{{asset('js/socket/created-tweet-channel.js')}}"></script>
    <script src="{{asset('js/tweets/favorite-tweets.js')}}"></script>
@endsection