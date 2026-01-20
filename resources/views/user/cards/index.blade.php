@extends('layouts.user-dashboard')
@section('title', 'Card Portfolio')
@section('content')

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-slate: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --card-border: #e2e8f0;
        }

        body {
            background-color: var(--bg-slate);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        /*
                            ========================================
                            1. HERO WALLET SECTION
                            ========================================
                            */
        .wallet-section {
            background: #fff;
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .wallet-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .wallet-icon-wrapper {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        /*
                            ========================================
                            2. PREMIUM CREDIT CARD COMPONENT
                            ========================================
                            */
        .credit-card {
            aspect-ratio: 1.586 / 1;
            /* Standard ID-1 Credit Card Ratio */
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .credit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        /* Gradient Variants */
        .credit-card.gradient-1 {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        }

        .credit-card.gradient-2 {
            background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
        }

        .credit-card.gradient-3 {
            background: linear-gradient(135deg, #111827 0%, #374151 100%);
        }

        /* Default fallback */
        .credit-card-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .card-chip {
            width: 40px;
            height: 28px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            border-radius: 4px;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.3);
        }

        .card-details-blur {
            /* Subtle noise/texture could go here */
        }

        .card-number-dots {
            font-family: monospace;
            font-size: 1.25rem;
            letter-spacing: 4px;
            opacity: 0.8;
            margin-top: auto;
            margin-bottom: 0.5rem;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            opacity: 0.9;
        }

        /*
                            ========================================
                            3. DISCOVERY LIST COMPONENT
                            ========================================
                            */
        .market-card {
            background: white;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .market-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .market-icon {
            width: 56px;
            height: 56px;
            background: #f1f5f9;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.25rem;
            flex-shrink: 0;
        }

        .market-content {
            flex: 1;
            min-width: 0;
            /* Text truncation fix */
        }

        .market-actions {
            margin-left: 1rem;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }

        .custom-checkbox {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-checkbox:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /*
                            ========================================
                            4. FILTERS
                            ========================================
                            */
        .filter-bar {
            background: white;
            border-bottom: 1px solid var(--card-border);
            position: sticky;
            top: 70px;
            /* Below topbar */
            z-index: 900;
            padding: 1rem 0;
            margin-bottom: 2rem;
            /* width: calc(100% + 3rem); */
            /* handled by container */
        }

        /* Mobile Responsiveness */
        @media (max-width: 700px) {

            /* Aggressive Sidebar Fix - Targeting 'left' directly as per dashboard.css */
            aside#sidebar {
                left: -260px !important;
                position: fixed;
                top: 0;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
            }

            /* Show sidebar when active/show class is present */
            aside#sidebar.active,
            aside#sidebar.show,
            aside#sidebar.expand {
                left: 0 !important;
            }

            /* Content expansion */
            .content {
                width: 100% !important;
                margin-left: 0 !important;
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }

            /* Stack cards */
            .market-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .market-icon {
                margin-bottom: 1rem;
            }

            .market-actions {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                margin-left: 0;
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #f1f5f9;
            }

            .wallet-section {
                padding: 1.5rem;
                border-radius: 0 0 24px 24px;
                /* margin: -1.5rem -1.5rem 2rem -1.5rem; */
                box-shadow: none;
                border-bottom: 1px solid #e2e8f0;
            }
        }
    </style>

    <div class="container-fluid px-0">

        {{--
        ========================================
        MY WALLET (HERO)
        ========================================
        --}}
        <div class="row">
            <div class="col-12">
                <div class="wallet-section">
                    <div class="wallet-header">
                        <div class="wallet-icon-wrapper">
                            {{-- <i class="fas fa-wallet text-white fa-lg"></i> --}}
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">My Wallet</h4>
                            <p class="text-muted small mb-0">Manage your active card portfolio</p>
                        </div>
                    </div>

                    <!-- Renamed class to wallet-grid-custom to avoid dashboard.css conflict -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 wallet-grid-custom">
                        @forelse ($userCards as $index => $card)
                            @php
                                // Cycle through gradients based on index
                                $gradClass = 'gradient-' . (($index % 3) + 1);
                            @endphp
                            <div class="col" id="wallet-card-{{ $card->id }}">
                                <div class="credit-card {{ $gradClass }}" data-bs-toggle="modal"
                                    data-bs-target="#modalCardDetails{{ $card->id }}">
                                    <div class="credit-card-bg"></div>

                                    {{-- Top --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-uppercase small opacity-75">{{ $card->bank_name }}</span>
                                        <i class="fas fa-wifi opacity-75"></i>
                                    </div>

                                    {{-- Middle --}}
                                    <div>
                                        {{-- <div class="card-chip"></div> --}}
                                        <div class="mb-3">
                                            <img src="{{ asset('assets/image/logo/chat-ai-gradient.svg') }}"
                                                height="50" />
                                        </div>
                                        <h5 class="fw-bold mb-0 text-truncate">{{ $card->card_name }}</h5>
                                    </div>

                                    {{-- Bottom --}}
                                    <div class="card-meta">
                                        <div>
                                            <span class="d-block" style="font-size: 0.6rem; opacity: 0.7;">NETWORK</span>
                                            {{ $card->network_type }}
                                        </div>
                                        <div class="card-number-dots">•••• {{ rand(1000, 9999) }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center">
                                <div class="bg-slate-100 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="fas fa-wallet fa-2x text-muted"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Your wallet is empty</h6>
                                <p class="text-muted small">Select cards from the list below to get started.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{--
        ========================================
        DISCOVERY SECTION
        ========================================
        --}}
        <div class="container-fluid px-4 pb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0">Discover Cards</h5>
                <span class="badge bg-white border text-dark shadow-sm px-3 py-2 rounded-pill">{{ $cards->total() }}
                    Available</span>
            </div>

            {{-- Filters --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('user.cards.index') }}" class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <select name="bankname" class="form-select border-0 bg-light fw-bold"
                                style="font-size: 0.9rem;">
                                <option value="">All Banks</option>
                                @foreach ($bankNames as $bank)
                                    <option value="{{ $bank }}"
                                        {{ request('bankname') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="cardtype" class="form-select border-0 bg-light fw-bold"
                                style="font-size: 0.9rem;">
                                <option value="">All Types</option>
                                @foreach ($cardTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('cardtype') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="network" class="form-select border-0 bg-light fw-bold" style="font-size: 0.9rem;">
                                <option value="">All Networks</option>
                                @foreach ($networks as $net)
                                    <option value="{{ $net }}"
                                        {{ request('network') == $net ? 'selected' : '' }}>{{ $net }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-dark fw-bold px-4 rounded-3 w-100">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card List --}}
            <div class="row g-3">
                @forelse ($cards as $card)
                    <div class="col-12">
                        <div class="market-card">
                            <div class="market-icon">
                                <i class="fas fa-credit-card text-primary fa-lg"></i>
                            </div>
                            <div class="market-content">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fw-bold mb-0 me-2">{{ $card->card_name }}</h6>
                                    @if ($card->joining_fee == 0)
                                        <span
                                            class="badge bg-green-100 text-success border border-success-subtle rounded-pill"
                                            style="font-size: 0.65rem;">No Fee</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-0 fw-medium text-uppercase">{{ $card->bank_name }} •
                                    {{ $card->network_type }}</p>
                            </div>
                            <div class="market-actions">
                                <input class="form-check-input custom-checkbox card-checkbox" type="checkbox"
                                    value="{{ $card->id }}" {{ in_array($card->id, $userCardIds) ? 'checked' : '' }}>
                                <button type="button" class="btn btn-link py-0 px-0 text-decoration-none small fw-bold"
                                    data-bs-toggle="modal" data-bs-target="#modalCardDetails{{ $card->id }}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No cards found matching your criteria.</p>
                        <a href="{{ route('user.cards.index') }}" class="btn btn-light btn-sm fw-bold">Clear Filters</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $cards->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

        {{-- Modals --}}
        @foreach ($userCards->merge($cards) as $card)
            <div class="modal fade" id="modalCardDetails{{ $card->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">{{ $card->card_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex gap-2 mb-4">
                                <span class="badge bg-light text-dark border">{{ $card->bank_name }}</span>
                                <span class="badge bg-light text-dark border">{{ $card->network_type }}</span>
                                <span class="badge bg-light text-dark border">{{ $card->card_category }}</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-3 text-center">
                                        <small class="text-muted d-block text-uppercase fw-bold"
                                            style="font-size: 0.65rem;">Joining Fee</small>
                                        <span
                                            class="fw-bold text-dark">{{ $card->joining_fee == 0 ? 'Free' : '₹' . number_format($card->joining_fee) }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-3 text-center">
                                        <small class="text-muted d-block text-uppercase fw-bold"
                                            style="font-size: 0.65rem;">Annual Fee</small>
                                        <span
                                            class="fw-bold text-dark">{{ $card->annual_fee == 0 ? 'Free' : '₹' . number_format($card->annual_fee) }}</span>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary">Benefits & Features</h6>
                            <div class="p-3 bg-slate-50 border rounded-3 small text-secondary" style="line-height: 1.6;">
                                {!! nl2br(e($card->pros)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.card-checkbox');

            // Toast Setup
            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1050';
            toastContainer.innerHTML = `
            <div id="liveToast" class="toast align-items-center text-bg-dark border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold" id="toastMessage">Wallet updated.</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
            document.body.appendChild(toastContainer);
            const toast = new bootstrap.Toast(document.getElementById('liveToast'));
            const toastMessage = document.getElementById('toastMessage');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const cardId = this.value;
                    const isChecked = this.checked;
                    const action = isChecked ? 'add' : 'remove';
                    this.disabled = true;

                    fetch('{{ route('cards.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                card_id: cardId,
                                action: action
                            })
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.disabled = false;
                            if (data.success) {
                                toastMessage.textContent = data.message;
                                toast.show();
                                updateWalletGrid(action, data.card, cardId, data.total_count);
                            } else {
                                this.checked = !isChecked; // Revert
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(e => {
                            this.disabled = false;
                            this.checked = !isChecked;
                            console.error(e);
                            alert('Network error.');
                        });
                });
            });

            function updateWalletGrid(action, card, id, total) {
                const grid = document.querySelector('.wallet-grid-custom');
                if (!grid) return;

                // Remove Empty State if adding
                const emptyState = grid.querySelector('.col-12.text-center');
                if (action === 'add' && emptyState) emptyState.remove();

                if (action === 'remove') {
                    const el = document.getElementById('wallet-card-' + id);
                    if (el) {
                        el.style.transform = 'scale(0.9) translateY(20px)';
                        el.style.opacity = '0';
                        setTimeout(() => {
                            el.remove();
                            if (total === 0) renderEmptyState(grid);
                        }, 300);
                    }
                } else {
                    // Determine gradient index
                    const count = grid.children.length;
                    const gradIndex = (count % 3) + 1;

                    const newCardHtml = `
                    <div class="col" id="wallet-card-${card.id}">
                        <div class="credit-card gradient-${gradIndex}" data-bs-toggle="modal" data-bs-target="#modalCardDetails${card.id}" style="animation: fadeIn 0.4s ease;">
                            <div class="credit-card-bg"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-uppercase small opacity-75">${card.bank_name}</span>
                                <i class="fas fa-wifi opacity-75"></i>
                            </div>
                            <div>
                                <div class="card-chip"></div>
                                <h5 class="fw-bold mb-0 text-truncate">${card.card_name}</h5>
                            </div>
                            <div class="card-meta">
                                <div>
                                    <span class="d-block" style="font-size: 0.6rem; opacity: 0.7;">NETWORK</span>
                                    ${card.network_type}
                                </div>
                                <div class="card-number-dots">•••• ${Math.floor(1000 + Math.random() * 9000)}</div>
                            </div>
                        </div>
                    </div>
                `;
                    const temp = document.createElement('div');
                    temp.innerHTML = newCardHtml;
                    grid.appendChild(temp.firstElementChild);
                }
            }

            function renderEmptyState(grid) {
                grid.innerHTML = `
                <div class="col-12 py-5 text-center">
                    <div class="bg-slate-100 rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-wallet fa-2x text-muted"></i>
                    </div>
                    <h6 class="fw-bold text-dark">Your wallet is empty</h6>
                    <p class="text-muted small">Select cards from the list below to get started.</p>
                </div>
            `;
            }
        });
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
