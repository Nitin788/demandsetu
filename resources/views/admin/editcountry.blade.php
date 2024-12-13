@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Edit Country Form</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('countries.index') }}">Country List</a>
        </li>
        <li class="breadcrumb-item" style="margin-left: 30px;">
            <a href="{{ route('countries.edit', $countries->id) }}">Edit Country</a>
        </li>
    </ol>
</div>
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Edit Country Form</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <!-- Use PUT method to update the country -->
                    <form class="form-horizontal" action="{{ route('countries.update', $countries->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- To use the PUT HTTP method for updating -->

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

                        <!-- Country Name and Country Image in Same Row (col-md-6) -->
                        <div class="form-group row">
                            <!-- Country Name -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Country Name</label>
                                <input class="form-control @error('country_name') is-invalid @enderror"
                                    name="country_name" type="text" placeholder="Enter country name" required
                                    value="{{ old('country_name', $countries->name) }}">
                                @error('country_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Image -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Country Image</label>
                                <input class="form-control @error('country_image') is-invalid @enderror"
                                    name="country_image" type="file">
                                @error('country_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Display the current image if exists -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                @if ($countries->image)
                                    <label class="col-form-label font-weight-bold">Current Image</label><br>
                                    <img src="{{ asset('' . $countries->image) }}" width="100" alt="{{ $countries->name }}">
                                @else
                                    <label class="col-form-label font-weight-bold">Current Image</label><br>
                                    <p>No image available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Country Status -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Status</label>
                                <select class="form-control @error('country_status') is-invalid @enderror"
                                    name="country_status" required>
                                    <option value="active" {{ old('country_status', $countries->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('country_status', $countries->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('country_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-sm-10 ml-sm-auto">
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