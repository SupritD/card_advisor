@extends('layouts.admin-dashboard')
@section('title', 'User Details')

@section('content')

    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            <h4>User Details</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 text-center">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" class="img-fluid rounded-circle mb-3" width="120">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}" class="img-fluid rounded-circle mb-3"
                            width="120">
                    @endif

                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">User ID: {{ $user->id }}</p>
                </div>

                <div class="col-md-9">
                    <ul class="list-group">

                        <li class="list-group-item">
                            <strong>Email:</strong> {{ $user->email }}
                        </li>

                        <li class="list-group-item">
                            <strong>Mobile:</strong> {{ $user->mobile ?? 'Not Provided' }}
                        </li>

                        <li class="list-group-item">
                            <strong>Email Verified:</strong>
                            @if ($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Not Verified</span>
                            @endif
                        </li>

                        <li class="list-group-item">
                            <strong>Google Login:</strong>
                            {{ $user->google_id ? 'Yes' : 'No' }}
                        </li>

                        <li class="list-group-item">
                            <strong>Created At:</strong>
                            {{ $user->created_at->format('d-M-Y') }}
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </div>


    <!-- USER CARDS SECTION -->
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h4>User Selected Cards</h4>
        </div>

        <div class="card-body">

            @if ($user->cards->count() == 0)
                <p class="text-danger">No cards selected by this user.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bank</th>
                                <th>Card Name</th>
                                <th>Network</th>
                                <th>Category</th>
                                <th>Tier</th>
                                <th>Joining Fee</th>
                                <th>Annual Fee</th>
                                <th>Selected At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($user->cards as $index => $card)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $card->bank_name }}</td>
                                    <td>{{ $card->card_name }}</td>
                                    <td>{{ $card->network_type }}</td>
                                    <td>{{ $card->card_category }}</td>
                                    <td>{{ $card->card_tier }}</td>
                                    <td>{{ $card->joining_fee }}</td>
                                    <td>{{ $card->annual_fee }}</td>
                                    <td>
                                        {{ $card->pivot->created_at->format('d-M-Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @endif

        </div>
    </div>


    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Back
    </a>

@endsection
