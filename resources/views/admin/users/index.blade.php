@extends('layouts.admin-dashboard')
@section('title', 'Users')

@section('content')

    <div class="bg-dark text-white mb-3 px-4 py-3 rounded-2 d-flex justify-content-between">
        <h4 class="mb-0">User List</h4>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Manage Users</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Email Verified</th>
                            <th>Cards</th>
                            <th>Avatar</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>{{ $user->mobile ?? '---' }}</td>

                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-danger">Not Verified</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->cards_count }}
                                    {{-- <span class="badge bg-dark">
                                    </span> --}}
                                </td>

                                <td>
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" width="40" height="40" class="rounded-circle">
                                    @else
                                        <span class="text-muted">No Avatar</span>
                                    @endif
                                </td>

                                <td>{{ $user->created_at->format('d-M-Y') }}</td>

                                <!-- Action Menu -->
                                <td>

                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Action
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                                    <i class="fas fa-eye text-primary"></i> View
                                                </a>
                                            </li>

                                            {{-- <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-edit text-warning"></i> Edit
                                                </a>
                                            </li> --}}

                                            <li>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                autoWidth: false,
                ordering: true,

                columnDefs: [{
                        orderable: false,
                        targets: [7]
                    } // Action column
                ],

                order: [
                    [6, 'desc']
                ] // Created At DESC
            });
        });
    </script>
@endpush
