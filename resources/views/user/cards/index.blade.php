@extends('layouts.user-dashboard')
@section('title', 'Card Details')

@section('content')


    @if ($userCards->count())

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-wallet"></i> Your Cards
                </h5>
            </div>

            <div class="card-body">
                <div class="row">

                    @foreach ($userCards as $card)
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 h-100">

                                <h6 class="fw-bold mb-1">
                                    {{ $card->card_name }}
                                </h6>

                                <p class="text-muted mb-2">
                                    {{ $card->bank_name }}
                                </p>

                                <span class="badge bg-success">{{ $card->network_type }}</span>
                                <span class="badge bg-secondary">{{ $card->card_category }}</span>

                                <hr>

                                <small>
                                    <strong>Annual Fee:</strong>
                                    {{ $card->annual_fee ? '₹' . $card->annual_fee : 'Free' }}
                                </small>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    @endif


    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle"></i>
                {{ $userCards->count() ? 'Update Your Cards' : 'Select Your Cards' }}
            </h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-12 border-1 rounded mb-3 p-3 bg-light">
                    <form method="GET" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Card Name</label>
                                <select name="cardname" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($cardNames as $name)
                                        <option value="{{ $name }}"
                                            {{ request('cardname') == $name ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Bank Name</label>
                                <select name="bankname" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($bankNames as $bank)
                                        <option value="{{ $bank }}"
                                            {{ request('bankname') == $bank ? 'selected' : '' }}>
                                            {{ $bank }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Card Type</label>
                                <select name="cardtype" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($cardTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ request('cardtype') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Network</label>
                                <select name="network" class="form-select">
                                    <option value="">All</option>
                                    @foreach ($networks as $network)
                                        <option value="{{ $network }}"
                                            {{ request('network') == $network ? 'selected' : '' }}>
                                            {{ strtoupper($network) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('user.cards.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                            <button class="btn btn-primary btn-sm">Filter</button>
                        </div>
                    </form>

                    <strong>Note:</strong> Select the cards you own or are interested in. You can update this list
                    anytime.
                </div>
            </div>

            {{-- @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif --}}
            @if (session('success'))
                <div id="success-alert" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.cards.store') }}" method="POST">
                @csrf
                @foreach ($userCardIds as $id)
                    <input type="hidden" name="cards[]" value="{{ $id }}">
                @endforeach
                {{-- @if ($cards->isEmpty())
                    <div class="alert alert-warning">
                        No cards available at the moment.
                    </div>
                @endif --}}

                <div class="row">

                    @foreach ($cards as $card)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">

                                <div class="card-body">

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="cards[]"
                                            value="{{ $card->id }}" id="card{{ $card->id }}"
                                            {{ in_array($card->id, $userCardIds) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="card{{ $card->id }}">
                                            {{ $card->card_name }}
                                        </label>
                                    </div>

                                    <p class="mb-1 text-muted">
                                        {{ $card->bank_name }}
                                    </p>

                                    <span class="badge bg-info">{{ $card->network_type }}</span>
                                    <span class="badge bg-secondary">{{ $card->card_category }}</span>

                                    <hr>

                                    <small>
                                        <strong>Annual Fee:</strong>
                                        {{ $card->annual_fee ? '₹' . $card->annual_fee : 'Free' }}
                                    </small>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="mt-3">
                    <button class="btn btn-dark px-4">
                        <i class="fas fa-save"></i>
                        {{ $userCards->count() ? 'Update Cards' : 'Save My Cards' }}
                    </button>
                </div>

            </form>

        </div>
    </div>


@endsection

<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.classList.add('fade');
            alert.classList.remove('show');
            alert.remove();
        }
    }, 5000);
</script>
