@extends('layouts.user-dashboard')
@section('title', 'Chat')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="row w-100">
            <div class="col-12">
                <div id="chatContainer" class="chat-container col-9 mx-auto"></div>
            </div>
        </div>
        <div id="chat-input-section" class="w-100">
            <div class="row">
                <div class="col-9 mx-auto">
                    {{-- <h1>hello</h1> --}}
                    <div id="centerBox" class="center-box">
                        <h1 class="text-dark" style="font-weight:400;">What’s on your mind today?</h1>
                    </div>
                    <div id="inputArea" class="input-area">
                        <input type="text" id="msgInput" class="input-bar" placeholder="Ask anything..." />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
