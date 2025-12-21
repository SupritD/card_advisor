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
                    <div class="d-flex align-items-center mb-2">
                        <label for="chatLanguage" class="me-2 mb-0">Language:</label>
                        <select id="chatLanguage" class="form-select form-select-sm me-3" style="width:150px;">
                            <option value="en" selected>English</option>
                            <option value="auto">Auto</option>
                            <option value="zh">Chinese</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                        </select>

                        <!-- Session controls: show token, clear session -->
                        <button id="btnShowSession" class="btn btn-outline-secondary btn-sm me-2" type="button">Show token</button>
                        <button id="btnClearSession" class="btn btn-outline-danger btn-sm" type="button">Clear session</button>
                        <small id="sessionTokenDisplay" class="text-muted ms-3" style="display:none; word-break:break-all;"></small>
                    </div>

                    <div id="inputArea" class="input-area">
                        <input type="text" id="msgInput" class="input-bar" placeholder="Ask anything..." />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dashboard-chat.js') }}"></script>
@endpush
