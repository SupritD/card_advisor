@extends('layouts.admin-dashboard')
@section('title', 'Edit Card')

@section('content')

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4>Edit Card</h4>
            <a href="{{ route('admin.cards.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.cards.update', $card->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Bank Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control"
                            value="{{ old('bank_name', $card->bank_name) }}">
                    </div>

                    <!-- Card Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Card Name</label>
                        <input type="text" name="card_name" class="form-control"
                            value="{{ old('card_name', $card->card_name) }}">
                    </div>

                    <!-- Network Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Network Type</label>
                        <select class="form-select" name="network_type">
                            <option value="Visa" {{ $card->network_type == 'Visa' ? 'selected' : '' }}>Visa</option>
                            <option value="MasterCard" {{ $card->network_type == 'MasterCard' ? 'selected' : '' }}>
                                MasterCard</option>
                            <option value="RuPay" {{ $card->network_type == 'RuPay' ? 'selected' : '' }}>RuPay</option>
                            <option value="Amex" {{ $card->network_type == 'Amex' ? 'selected' : '' }}>Amex</option>
                        </select>
                    </div>

                    <!-- Card Category (Credit / Debit) -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Card Category</label>
                        <select name="card_category" class="form-select">
                            <option value="Credit" {{ $card->card_category == 'Credit' ? 'selected' : '' }}>Credit</option>
                            <option value="Debit" {{ $card->card_category == 'Debit' ? 'selected' : '' }}>Debit</option>
                        </select>
                    </div>

                    <!-- Card Tier -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Card Tier</label>
                        <input type="text" name="card_tier" class="form-control"
                            value="{{ old('card_tier', $card->card_tier) }}">
                    </div>

                    <!-- Joining Fee -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Joining Fee</label>
                        <input type="number" name="joining_fee" class="form-control"
                            value="{{ old('joining_fee', $card->joining_fee) }}">
                    </div>

                    <!-- Annual Fee -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Annual Fee</label>
                        <input type="number" name="annual_fee" class="form-control"
                            value="{{ old('annual_fee', $card->annual_fee) }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $card->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $card->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Pros -->
                    <div class="col-12 mb-3">
                        <label class="form-label">Pros</label>
                        <textarea name="pros" rows="5" class="form-control">{{ old('pros', $card->pros) }}</textarea>
                    </div>

                </div>

                <div class="">
                    <button class="btn btn-dark"><i class="fas fa-save"></i> Update Card</button>
                </div>

            </form>

        </div>
    </div>
@endsection
