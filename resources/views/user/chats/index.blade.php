@extends('layouts.user-dashboard')
@section('title', 'AI Advisor')

@section('content')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            --secondary-bg: #f8fafc;
            --chat-bg: #ffffff;
            --user-msg-bg: #4f46e5;
            --bot-msg-bg: #f1f5f9;
            --border-color: #e2e8f0;
        }

        /* Fix top spacing from dashboard layout */
        main.content {
            padding: 0 !important;
            margin-top: 70px !important;
            /* Align exactly with fixed topbar */
        }

        .chat-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            /* Full height minus header */
            height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            background: var(--chat-bg);
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
        }

        /* Make it look like a panel on larger screens */
        @media (min-width: 992px) {
            .chat-wrapper {
                margin: 1rem auto;
                height: calc(100vh - 120px);
                border-radius: 24px;
                border: 1px solid var(--border-color);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            }
        }

        /* HEADER */
        .chat-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 10;
            /* Ensure header stays above messages */
        }

        .chat-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .ai-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        /* REST OF CSS ... */
        /* MESSAGES AREA */
        .chat-messages {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            scroll-behavior: smooth;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
            /* Lower than header */
        }

        /* ... scrollbar ... */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        /* EMPTY STATE */
        .center-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: #64748b;
        }

        .suggestion-chips {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .chip {
            background: white;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .chip:hover {
            border-color: #4f46e5;
            color: #4f46e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* MESSAGE BUBBLES */
        .message-row {
            display: flex;
            align-items: flex-start;
            width: 100%;
            margin-bottom: 1.5rem;
            position: relative;
            padding: 0 40px;
            /* Space for buttons on sides */
        }

        .message-row.user {
            justify-content: flex-end;
        }

        .message-row.bot {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 80%;
            padding: 1rem 1.25rem;
            border-radius: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* HOVER ACTIONS - Outside the bubble */
        .message-actions {
            position: absolute;
            top: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
            opacity: 0;
            transition: all 0.2s ease;
            padding: 4px;
            z-index: 5;
        }

        .message-row.user .message-actions {
            right: 0;
            /* Align to the right side of the row (outside bubble which is also right) */
        }

        .message-row.bot .message-actions {
            left: 0;
            /* Align to the left side of the row */
        }

        .message-row:hover .message-actions {
            opacity: 1;
        }

        .action-btn {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 0;
            border-radius: 8px;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            transition: all 0.2s ease;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .action-btn:hover {
            background: #f8fafc;
            color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .message-row.user .message-bubble {
            background: var(--primary-gradient);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .message-row.user .action-btn {
            background: rgba(255, 255, 255, 0.9);
            border: none;
        }

        .message-row.user .action-btn:hover {
            background: white;
            color: var(--primary-color);
        }

        .message-row.bot .message-bubble {
            background: white;
            color: #1e293b;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #f1f5f9;
        }

        /* Markdown Styles within Bot Bubbles */
        .message-bubble p {
            margin-bottom: 0.75rem;
        }

        .message-bubble p:last-child {
            margin-bottom: 0;
        }

        .message-bubble strong {
            font-weight: 700;
            color: inherit;
        }

        .message-bubble ul,
        .message-bubble ol {
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .message-bubble li {
            margin-bottom: 0.25rem;
        }

        .message-bubble h1,
        .message-bubble h2,
        .message-bubble h3 {
            font-weight: 700;
            color: inherit;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        /* INPUT AREA */
        .chat-input-wrapper {
            padding: 1rem 1.5rem;
            background: white;
            border-top: 1px solid var(--border-color);
        }

        .input-container {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 0.5rem 0.75rem;
            /* Better padding */
            transition: all 0.2s;
        }

        .input-container:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: white;
        }

        .chat-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.5rem;
            font-size: 0.95rem;
            outline: none;
            color: #1e293b;
        }

        .send-btn {
            background: var(--primary-gradient);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
            margin-left: 0.5rem;
        }

        .send-btn:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="row justify-content-center h-100 g-0">
        <div class="col-12 h-100">
            <div class="chat-wrapper">
                {{-- Header --}}
                <div class="chat-header">
                    <div class="chat-title">
                        <div class="ai-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">Advisor</h6>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1"
                                style="font-size: 0.6rem;">Online</span>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle" style="width: 36px; height: 36px;" type="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-globe text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 overflow-hidden"
                            style="min-width: 200px;">
                            <li class="px-3 py-2 bg-light border-bottom">
                                <small class="text-muted fw-bold">Language</small>
                            </li>
                            <li class="px-3 py-2">
                                <select id="chatLanguage" class="form-select form-select-sm">
                                    <option value="en" selected>English</option>
                                    <option value="auto">Auto-Detect</option>
                                    <option value="zh">Chinese</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                </select>
                            </li>

                            {{-- Hidden controls for JS compatibility --}}
                            <li class="d-none">
                                <select id="chatSessionsSelect">
                                    <option value="">Current</option>
                                </select>
                                <button id="btnNewSession">New</button>
                                <button id="btnClearSession">Clear</button>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Chat Area --}}
                <div id="chatContainer" class="chat-messages">
                    {{-- Welcome --}}
                    <div id="centerBox" class="center-box">
                        <div class="mb-4">
                            <div class="d-inline-flex p-4 rounded-circle bg-white shadow-sm mb-3">
                                <i class="bi bi-chat-dots-fill fa-3x text-primary"
                                    style="font-size: 3rem; background: -webkit-linear-gradient(135deg, #4f46e5, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">How can I help you today?</h3>
                            <p class="text-muted">Ask about your card benefits, fees, or get purchase recommendations.</p>
                        </div>

                        <div class="suggestion-chips">
                            <div class="chip" onclick="fillInput('Which card is best for Amazon?')">🛍️ Amazon Purchase
                            </div>
                            <div class="chip" onclick="fillInput('Show my card benefits')">💳 My Benefits</div>
                            <div class="chip" onclick="fillInput('Do I have lounge access?')">✈️ Lounge Access</div>
                            <div class="chip" onclick="fillInput('Compare my cards annual fees')">💰 Annual Fees</div>
                        </div>
                    </div>
                </div>

                {{-- Input Area --}}
                <div class="chat-input-wrapper" id="chat-input-section">
                    <div class="input-container">
                        <input type="text" id="msgInput" class="chat-input" placeholder="Ask your advisor anything..."
                            autocomplete="off">

                        {{-- Send Button --}}
                        <button id="sendBtn" class="send-btn">
                            <i class="bi bi-send-fill"></i>
                        </button>

                        {{-- Stop Button (Hidden by default) --}}
                        <button id="stopBtn" class="send-btn bg-danger d-none">
                            <i class="bi bi-stop-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Inline script helper for chips --}}
    <script>
        function fillInput(text) {
            const input = document.getElementById('msgInput');
            input.value = text;
            input.focus();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('assets/js/dashboard-chat.js') }}"></script>
@endpush