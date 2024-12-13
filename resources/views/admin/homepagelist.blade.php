@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Homepage List</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="">Homepage List</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">All Homepages</div>
                    <div class="ibox-tools">
                        <a href="{{ route('homepages.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Homepage
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

                    <!-- Homepage Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Slider Image</th>
                                <th>Session Banner</th>
                                <th>Offer Card</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($homepages as $homepage)
                                <tr>
                                    <td>
                                        <!-- Slider Image Section -->
                                        @if($homepage->slider_images && count($homepage->slider_images) > 0)
                                            <div class="row">
                                                @foreach ($homepage->slider_images as $slider)
                                                    <div class="col-12 mb-3">
                                                        <img src="{{ asset($slider['image']) }}" width="150px" height="80px" alt="{{ $slider['title'] }}"
                                                            class="img-fluid">
                                                        <p class="text-center">{{ $slider['title'] }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center">No Slider Image</p>
                                        @endif
                                    </td>

                                    <td>
                                        <!-- Session Banner Section -->
                                        @if(is_array($homepage->offer_image) && count($homepage->offer_image) > 0)
                                            <div class="row">
                                                @foreach ($homepage->offer_image as $banner)
                                                    <div class="col-12 mb-3">
                                                        <img src="{{ asset($banner) }}" width="150px" height="80px" alt="Session Banner" class="img-fluid">
                                                        <p class="text-center ">Session Banner</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center">No Banner</p>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Offer Card Section -->
                                        @if($homepage->offer_card && count($homepage->offer_card) > 0)
                                            <div class="row">
                                                @foreach ($homepage->offer_card as $section)
                                                    <!-- Section Title -->
                                                    <div class="col-12">
                                                        <h5 class="text-center mb-3">{{ $section['title'] }}</h5>
                                                    </div>

                                                    @foreach ($section['cards'] as $card)
                                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                                            <img src="{{ asset($card['image']) }}" alt="{{ $card['destination'] }}"
                                                                class="img-fluid" style="height: 80px; object-fit: cover;">
                                                            <p class="text-center">{{ $card['destination'] }}</p>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center">No Offer Card</p>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a href="{{ route('homepages.edit', $homepage->id) }}"
                                            class="btn btn-warning btn-sm mb-2">Edit</a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('homepages.destroy', $homepage->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this homepage?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No homepages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between">
                        <div id="pagination-info">
                            Showing {{ $homepages->firstItem() }} to {{ $homepages->lastItem() }} of
                            {{ $homepages->total() }} entries
                        </div>
                        {{ $homepages->links() }} <!-- Pagination links -->
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