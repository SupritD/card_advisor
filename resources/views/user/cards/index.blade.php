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

                                <!-- REMOVE BUTTON -->
                                {{-- <button type="submit" name="cards[]" value="{{ $card->id }}"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" title="Remove card">
                                    ✕
                                </button> --}}

                                {{-- <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-card"
                                    data-id="{{ $card->id }}">
                                    ✕
                                </button> --}}
                                {{-- <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-card"
                                    data-id="{{ $card->id }}">
                                    ✕
                                </button> --}}

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

                @if ($cards->isEmpty())
                    <div class="alert alert-warning">
                        No cards available at the moment.
                    </div>
                @endif

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
