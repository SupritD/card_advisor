@extends('layouts.user-dashboard')
@section('title', 'dashboard')
@section('content')

<style>
    /* 
    ========================================
    EXACT CSS from user/cards/index.blade.php
    ========================================
    */
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

    /* PREMIUM CREDIT CARD COMPONENT */
    .credit-card {
        position: relative;
        border-radius: 16px;
        padding: 18px;
        min-height: 180px;
        color: #fff;
        cursor: pointer;
        overflow: hidden;
    }

    .cc-top {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }

    .cc-category,
    .cc-bank {
        font-weight: 600;
        opacity: 0.85;
        text-transform: uppercase;
    }

    .cc-center {
        margin-top: 14px;
    }

    .cc-logo {
        height: 46px;
        max-width: 100%;
    }

    .cc-name {
        margin-top: 6px;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cc-bottom {
        position: absolute;
        bottom: 16px;
        left: 18px;
        right: 18px;
    }

    .cc-label {
        display: block;
        font-size: 0.6rem;
        letter-spacing: 0.6px;
        opacity: 0.7;
    }

    .cc-value {
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* GRADIENTS */
    .credit-card.gradient-1 {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
    }

    .credit-card.gradient-2 {
        background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
    }

    .credit-card.gradient-3 {
        background: linear-gradient(135deg, #111827 0%, #374151 100%);
    }

    /* RESPONSIVE */
    @media (max-width: 575px) {
        .credit-card {
            min-height: 165px;
            padding: 14px;
        }

        .cc-logo {
            height: 40px;
        }

        .cc-name {
            font-size: 0.95rem;
        }

        .cc-value {
            font-size: 0.8rem;
        }
    }

    @media (min-width: 576px) and (max-width: 991px) {
        .credit-card {
            min-height: 185px;
            padding: 18px;
        }

        .cc-logo {
            height: 48px;
        }

        .cc-name {
            font-size: 1.05rem;
        }

        .cc-value {
            font-size: 0.9rem;
        }
    }

    @media (min-width: 992px) {
        .credit-card {
            min-height: 200px;
            padding: 20px;
        }

        .cc-logo {
            height: 52px;
        }

        .cc-name {
            font-size: 1.1rem;
        }

        .cc-value {
            font-size: 0.95rem;
        }
    }
    
    .pro-dashboard {
        max-width: 1300px;
        margin: auto;
        padding-bottom: 3rem;
    }

    .category-heading {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    

</style>

<div class="pro-dashboard">
    <div class="mb-5 px-3">
        <h3 class="fw-bold text-dark">Welcome back!</h3>
        <p class="text-muted">Here are the top recommended cards based on your lifestyle.</p>
    </div>

    @foreach($bestCards as $category => $cards)
        <div class="mb-5 px-3">
            <h3 class="category-heading">{{ $category }}</h3>
            
            @if($cards->isEmpty())
                <div class="p-4 bg-white rounded-3 text-center border text-muted">
                    No active cards available in this category.
                </div>
            @else
                <div class="row g-4">
                    {{-- Only showing the top 1 card as requested, but loop is safe if more --}}
                    @foreach($cards as $index => $card)
                    
                        @php 
                            // Determine gradient based on category index or random logic
                            // Since we have minimal cards, let's just cycle 1-3
                            $gradClass = 'gradient-' . (($loop->parent->iteration % 3) + 1); 
                        @endphp
                        
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="credit-card {{ $gradClass }}" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#modalCardDetails{{ $card->id }}">
                                


                                <div class="credit-card-bg"></div>

                                {{-- TOP --}}
                                <div class="cc-top d-flex justify-content-between align-items-center">
                                    <span class="cc-category">
                                        {{ $card->card_category }}
                                    </span>
                                    <span class="cc-bank">
                                        {{ $card->bank_name }}
                                    </span>
                                </div>

                                {{-- CENTER --}}
                                <div class="cc-center">
                                    <img src="{{ asset('assets/image/logo/chat-ai-gradient.svg') }}" class="cc-logo" alt="logo" />
                                    
                                    <h6 class="cc-name">
                                        {{ $card->card_name }}
                                    </h6>
                                </div>

                                {{-- BOTTOM --}}
                                <div class="cc-bottom d-flex justify-content-between align-items-end">
                                    <div>
                                        <span class="cc-label">CARD TIER</span>
                                        <div class="cc-value">
                                            {{ $card->card_tier }}
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="cc-label">NETWORK</span>
                                        <div class="cc-value">
                                            {{ $card->network_type }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    {{-- MODALS SECTION --}}
    @foreach($bestCards as $cards)
        @foreach($cards as $card)
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
    @endforeach

</div>

@endsection
