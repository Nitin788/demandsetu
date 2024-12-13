@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Edit Place</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('places.index') }}">Place List</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('places.edit', $places->id) }}">Edit Place</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-body">
                    <form action="{{ route('places.update', $places->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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

                        <!-- Select Destination -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Select Destination</label>
                                <select class="form-control @error('destination_id') is-invalid @enderror"
                                    name="destination_id" required>
                                    <option value="">Select a Destination</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}" {{ old('destination_id', $places->destination_id) == $destination->id ? 'selected' : '' }}>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destination_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" name="title"
                                    type="text" placeholder="Enter place title" required
                                    value="{{ old('title', $places->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- About -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">About</label>
                                <input class="form-control @error('about') is-invalid @enderror" name="about"
                                    type="text" placeholder="Short about text" required
                                    value="{{ old('about', $places->about) }}">
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Images -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Upload multiple Images</label>
                                <input class="form-control @error('images') is-invalid @enderror" name="images[]"
                                    type="file" multiple>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($places->images)
                                    <div class="mt-2">
                                        <label class="font-weight-bold">Existing Images:</label>
                                        <div class="row">
                                            @foreach (json_decode($places->images) as $image)
                                                <div class="col-sm-4">
                                                    <img src="{{ asset($image) }}" alt="Place Image" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Offers -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Offers</label>
                                <input class="form-control @error('offers') is-invalid @enderror" name="offers"
                                    type="text" placeholder="Special offers" required
                                    value="{{ old('offers', $places->offers) }}">
                                @error('offers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Duration</label>
                                <input class="form-control @error('duration') is-invalid @enderror" name="duration"
                                    type="text" placeholder="Duration of the stay" required
                                    value="{{ old('duration', $places->duration) }}">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" name="price"
                                    type="text" placeholder="Price of the place/tour" required
                                    value="{{ old('price', $places->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sale Price -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Sale Price</label>
                                <input class="form-control @error('sale_price') is-invalid @enderror" name="sale_price"
                                    type="text" placeholder="Sale price" required
                                    value="{{ old('sale_price', $places->sale_price) }}">
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    name="description" placeholder="Detailed description of the place"
                                    required>{{ old('description', $places->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Itinerary Section -->
                        <!-- itinerary -->
                        <div class="form-group">
                            <label>Itinerary <span style="color: red;">*</span></label>
                            <div id="itinerary-container">
                                @php  
                                    $itineraryData = json_decode($places->itinerary, true);  
                                  @endphp  
                                @foreach($itineraryData as $itinerary)  
                                    <div class="itinerary-item row mb-3">
                                        <div class="col-sm-3">
                                            <input type="text" name="day[]" class="form-control"
                                                value="{{ $itinerary['day'] }}" placeholder="Day" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="title[]" class="form-control"
                                                value="{{ $itinerary['title'] }}" placeholder="Title" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea name="itinerary[]" class="form-control"
                                                placeholder="Itinerary details"
                                                required>{{ $itinerary['details'] }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add More button -->
                            <button type="button" id="add-more-itinerary" class="btn btn-primary mt-2">+</button>
                            <span style="color: red;">@error('itinerary') {{$message}} @enderror</span>
                        </div>
                        <!-- Place Status -->
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="active" {{ old('status', $places->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive" {{ old('status', $places->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button class="btn btn-primary mt-2" type="submit">Update Place</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(function () {
                errorAlert.style.display = 'none';
            }, 8000);
        }
    });

    document.getElementById('add-more-itinerary').addEventListener('click', function () {
        const container = document.getElementById('itinerary-container');
        const newItem = document.createElement('div');
        newItem.classList.add('itinerary-item');
        newItem.innerHTML = `
        <div class="row mb-3">
            <div class="col-sm-3">
                <input type="text" class="form-control" name="day[]" placeholder="Day X" required>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="title[]" placeholder="Title" required>
            </div>
            <div class="col-sm-6">
                <textarea class="form-control" name="itinerary[]" placeholder="Itinerary details" required></textarea>
            </div>
            <button type="button" class="btn btn-danger remove-itinerary" style="margin-top: 10px;">Remove</button>
        </div>
    `;
        container.appendChild(newItem);

        // Add remove button functionality
        newItem.querySelector('.remove-itinerary').addEventListener('click', function () {
            container.removeChild(newItem);
        });
    });

</script>
@endsection