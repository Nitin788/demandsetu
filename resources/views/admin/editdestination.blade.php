@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Edit Destination Form</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('destinations.index') }}">Destination List</a>
        </li>
        <li class="breadcrumb-item" style="margin-left: 30px;">
            <a href="{{ route('destinations.edit', $destinations->id) }}">Edit Destination</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Edit Destination</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('destinations.update', $destinations->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- To indicate we are updating the resource -->

                        <!-- Display all errors at the top of the form -->
                        @if ($errors->any())
                            <div id="error-alert" class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Country Selection -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Select Country</label>
                                <select class="form-control @error('country_id') is-invalid @enderror" name="country_id"
                                    required>
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $destinations->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Destination Name -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Destination Name</label>
                                <input class="form-control @error('destination_name') is-invalid @enderror"
                                    name="destination_name" type="text" placeholder="Enter destination name" required
                                    value="{{ old('destination_name', $destinations->name) }}">
                                @error('destination_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Destination Image -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Destination Image</label>
                                <input class="form-control @error('destination_image') is-invalid @enderror"
                                    name="destination_image" type="file">
                                @error('destination_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Display the current image if exists -->
                            <div class="col-sm-6">
                                @if ($destinations->image)
                                    <label class="col-form-label font-weight-bold">Current Image</label><br>
                                    <img src="{{ asset('' . $destinations->image) }}" width="100px" height="50ox"
                                        alt="{{ $destinations->name }}">
                                @else
                                    <label class="col-form-label font-weight-bold">Current Image</label><br>
                                    <p>No image available</p>
                                @endif
                            </div>
                            <!-- Destination Status -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Status</label>
                                <select class="form-control @error('destination_status') is-invalid @enderror"
                                    name="destination_status" required>
                                    <option value="active" {{ old('destination_status', $destinations->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('destination_status', $destinations->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('destination_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="form-group ml-3">
                                <button class="btn btn-info" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to hide error messages after 8 seconds -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if there's an error alert displayed
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            // Set a timeout to remove the error alert after 8 seconds (8000 ms)
            setTimeout(function () {
                errorAlert.style.display = 'none'; // Hide the error alert
            }, 8000);
        }
    });
</script>

@endsection