@extends('layouts.app')

@section('content')

    <h2 id="tweet-title-h2">{{ $tweet->title }}</h2>
    <p id="tweet-description-p">{{ $tweet->description }}</p>

    @if(Auth::user()->id == $tweet->user->id)
        <div class="group-btn">
            <div id="edit-tweet-div">
                <!-- Edit Button -->
                <button class="btn btn-warning btn-detail" id="open-modal-btn" value="{{$tweet->id}}">Edit</button>
            </div>
            <div id="delete-tweet-div">
                <form action="/tweets/{{ $tweet->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-flat btn-danger" id="delete-tweet-btn">Delete Tweet</button>
                </form>
            </div>
        </div>

        <input hidden id="domain-url" value="{{ url('/') }}" />

        @include('tweets.edit-modal')

    @endif

@endsection

@if(Auth::user()->id == $tweet->user->id)
    @section('scripts')
        <script src="{{asset('js/tweets/edit-tweets.js')}}"></script>
    @endsection
@endif