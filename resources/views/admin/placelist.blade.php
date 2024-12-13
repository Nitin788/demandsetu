@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Places List</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('places.index') }}">Places List</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">All Places</div>
                    <!-- Search Form -->
                    <form class="navbar-search" action="{{ route('search') }}" method="GET">
                        <div class="d-flex mb-1">
                            <input class="form-control" name="search" placeholder="Search here..."
                                value="{{ request('search') }}" style="width: 200px;">
                            <button type="submit" class="btn btn-primary ml-2">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                    <div class="ibox-tools">
                        <a href="{{ route('places.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Place
                        </a>
                    </div>
                </div>
                <div class="ibox-body">
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div id="success-alert" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Places Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Destination</th>
                                <th>Offers</th>
                                <th>Price</th>
                                <th>Sale Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($places as $place)
                                <tr>
                                    <td>{{ $place->title }}</td>
                                    <td>{{ $place->destination->name ?? 'N/A' }}</td>
                                    <!-- Display associated destination name -->
                                    <td>{{ $place->offers }}</td>
                                    <td>{{ $place->price }}</td>
                                    <td>{{ $place->sale_price }}</td>
                                    <td>{{ ucfirst($place->status) }}</td> <!-- Capitalize first letter of status -->
                                    <td>
                                        <a href="{{ route('places.edit', $place->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('places.destroy', $place->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No places found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between">
                        <div id="pagination-info">
                            Showing {{ $places->firstItem() }} to {{ $places->lastItem() }} of {{ $places->total() }}
                            entries
                        </div>
                        {{ $places->links() }} <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-hide Success Message -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if the success alert is present
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            // Set a timeout to remove the alert after 8 seconds
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 8000); // 8000 milliseconds = 8 seconds
        }
    });
</script>

@endsection