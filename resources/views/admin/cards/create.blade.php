@extends('layouts.admin-dashboard')
@section('title', 'Add Card Details')

@section('content')

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-credit-card"></i> Add Card Details</h4>
            <a href="{{ route('admin.cards.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Opps!</strong> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.cards.store') }}">
                @csrf

                <div class="row">

                    {{-- Bank Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-university"></i> Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" placeholder="Example: ICICI Bank"
                            value="{{ old('bank_name', $card->bank_name ?? '') }}">
                    </div>

                    {{-- Card Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-id-card"></i> Card Name</label>
                        <input type="text" name="card_name" class="form-control"
                            placeholder="Example: Amazon Pay Credit Card"
                            value="{{ old('card_name', $card->card_name ?? '') }}">
                    </div>

                    {{-- Network Type --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-cc-visa"></i> Network Type
                        </label>
                        <select class="form-select" name="network_type">
                            <option value="Visa">Visa</option>
                            <option value="MasterCard">MasterCard</option>
                            <option value="RuPay">RuPay</option>
                            <option value="Amex">Amex</option>
                        </select>
                    </div>

                    {{-- Card Category (Credit / Debit) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-credit-card"></i> Card Category</label>
                        <select name="card_category" class="form-select">
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                    </div>

                    {{-- Card Tier --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-layer-group"></i> Card Tier</label>
                        <input type="text" name="card_tier" class="form-control"
                            placeholder="Example: Platinum, Gold, Signature"
                            value="{{ old('card_tier', $card->card_tier ?? '') }}">
                    </div>

                    {{-- Joining Fee --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-money-bill"></i> Joining Fee</label>
                        <input type="number" class="form-control" name="joining_fee" min="0"
                            placeholder="Example: 499" value="{{ old('joining_fee', $card->joining_fee ?? '') }}">
                    </div>

                    {{-- Annual Fee --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-rupee-sign"></i> Annual Fee</label>
                        <input type="number" class="form-control" name="annual_fee" min="0"
                            placeholder="Example: 599" value="{{ old('annual_fee', $card->annual_fee ?? '') }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-power-off"></i> Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    {{-- PROS --}}
                    <div class="col-12 mb-3">
                        <label class="form-label"><i class="fas fa-check-circle"></i> Pros</label>
                        <textarea name="pros" rows="5" class="form-control"
                            placeholder="• 3% Cashback
                            • Free lounge access
                            • Valid if bill > 5000">
                            {{ old('pros', $card->pros ?? '') }}</textarea>
                    </div>

                </div>

                <div class="">
                    <button class="btn btn-dark"><i class="fas fa-save"></i> Save Card</button>
                </div>

            </form>


        </div>
    </div>

@endsection
