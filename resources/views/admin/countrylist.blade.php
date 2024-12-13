@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Destination List</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="">Destination List</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">All Destination</div>
                    <div class="ibox-tools">
                        <a href="{{ route('countries.create') }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i> Add Destination</a>
                    </div>
                </div>
                <div class="ibox-body">
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div id="success-alert" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Country Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Destination Type</th>
                                <th>Destination Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($countries as $country)
                                <tr>
                                    <!-- <td>{{ $loop->iteration }}</td> -->
                                    <td>{{ $country->name }}</td>
                                    <td>
                                        @if($country->image)
                                            <img src="{{ asset( $country->image) }}" alt="{{ $country->name }}"
                                                width="100" height="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($country->status) }}</td>
                                    <td>
                                        <a href="{{ route('countries.edit', $country->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this country?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No countries found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between">
                        <div id="pagination-info">
                            Showing {{ $countries->firstItem() }} to {{ $countries->lastItem() }} of
                            {{ $countries->total() }} entries
                        </div>
                        {{ $countries->links() }} <!-- Pagination links -->
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