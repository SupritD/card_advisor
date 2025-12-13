@extends('layouts.admin-dashboard')
@section('title', 'Card List')
@section('content')


    <div class="bg-dark text-white mb-3 px-4 py-3 rounded-2 d-flex justify-content-between align-items-center">
        <ul class="breadcrumb text-white-all mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="breadcrumb-item active">Cards</li>
        </ul>

        <ul class="breadcrumb text-white-all mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.cards.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Add Card
                </a>
            </li>
        </ul>
    </div>


    <div class="card">
        <div class="card-header bg-dark text-white-all">
            <h4>Manage Cards</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>Card Name</th>

                            <th>Users</th>

                            <th>Network</th>
                            <th>Category</th>
                            <th>Tier</th>
                            <th>Joining Fee</th>
                            <th>Annual Fee</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @php $i = 1; @endphp

                        @forelse($cards as $card)
                            <tr>
                                <td>{{ $i++ }}</td>

                                <td>
                                    <strong>{{ $card->bank_name }}</strong>
                                </td>

                                <td>
                                    {{ $card->card_name }}
                                </td>

                                <td>
                                    {{ $card->users_count }}
                                    {{-- <span class="badge bg-dark">
                                    </span> --}}
                                </td>

                                <td>
                                    {{ $card->network_type }}
                                    {{-- <span class="badge bg-info">
                                    </span> --}}
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $card->card_category }}
                                    </span>
                                </td>

                                <td>
                                    {{ $card->card_tier ?? '—' }}
                                </td>

                                <td>
                                    {{ $card->joining_fee ? '₹' . $card->joining_fee : 'Free' }}
                                </td>

                                <td>
                                    {{ $card->annual_fee ? '₹' . $card->annual_fee : 'Free' }}
                                </td>

                                <td>
                                    @if ($card->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $card->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Action
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.cards.show', $card->id) }}">
                                                    <i class="fas fa-eye text-primary"></i> View
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.cards.edit', $card->id) }}">
                                                    <i class="fas fa-edit text-warning"></i> Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form action="{{ route('admin.cards.destroy', $card->id) }}" method="POST"
                                                    onsubmit="return confirm('Delete this card permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr class="text-center">
                                <td colspan="6" class="text-danger">
                                    <h5>No Cards Found.</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.datatable').DataTable({
        pageLength: 50,
        lengthMenu: [10, 50, 100, 500],
        responsive: true,
        autoWidth: false,
        ordering: true,

        columnDefs: [
            { orderable: false, targets: [11] } // Action column index
        ],

        order: [[10, 'desc']] // Created date DESC
    });
});
</script>
@endpush

