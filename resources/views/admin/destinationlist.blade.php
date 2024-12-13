@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Destination List</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('destinations.index') }}">Destination List</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">All Destinations</div>

                    <!-- Search Form -->
                    <form action="{{ route('destinations.index') }}" method="GET" class="navbar-search">
                        <div class="d-flex mb-1">
                            <input class="form-control" type="text" name="search" placeholder="Search destinations..." 
                                value="{{ request('search') }}" style="width: 300px;">
                            <button type="submit" class="btn btn-primary ml-2">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </form>

                    <div class="ibox-tools">
                        <a href="{{ route('destinations.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Destination
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

                    <!-- Destination Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Destination Name</th>
                                <th>Destination Type</th>
                                <th>Destination Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($destinations as $destination)
                                <tr>
                                    <td>{{ $destination->name }}</td>
                                    <td>{{ $destination->country->name }}</td>
                                    <td>
                                        @if($destination->image)
                                            <img src="{{ asset($destination->image) }}" alt="{{ $destination->name }}" width="100" height="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($destination->status) }}</td>
                                    <td>
                                        <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this destination?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No destinations found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between">
                        <div id="pagination-info">
                            Showing {{ $destinations->firstItem() }} to {{ $destinations->lastItem() }} of {{ $destinations->total() }} entries
                        </div>
                        {{ $destinations->links() }} <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-hide Success Message -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 8000); // 8000 milliseconds = 8 seconds
        }
    });
</script>

@endsection
