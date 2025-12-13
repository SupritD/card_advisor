@extends('layouts.admin-dashboard')
@section('title', 'Card Details')

@section('content')

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4>Card Details</h4>
            <a href="{{ route('admin.cards.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">

            <ul class="list-group">

                <li class="list-group-item"><strong>Bank:</strong> {{ $card->bank_name }}</li>
                <li class="list-group-item"><strong>Card Name:</strong> {{ $card->card_name }}</li>
                <li class="list-group-item"><strong>Network:</strong> {{ $card->network_type }}</li>
                <li class="list-group-item"><strong>Category:</strong> {{ $card->card_category }}</li>
                <li class="list-group-item"><strong>Tier:</strong> {{ $card->card_tier }}</li>
                <li class="list-group-item"><strong>Joining Fee:</strong> ₹{{ $card->joining_fee }}</li>
                <li class="list-group-item"><strong>Annual Fee:</strong> ₹{{ $card->annual_fee }}</li>
                <li class="list-group-item"><strong>Pros:</strong> {!! nl2br(e($card->pros)) !!}</li>
                <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($card->status) }}</li>

            </ul>

             <!-- BUTTONS -->
        <div class="mt-3 d-flex gap-2">

            <a href="{{ route('admin.cards.edit', $card->id) }}" class="btn btn-dark">
                <i class="fas fa-edit"></i> Edit Card
            </a>

        </div>

        </div>
    </div>

@endsection
