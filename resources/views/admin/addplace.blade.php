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
                        @method('PUT') <!-- Used for PUT method in form submission -->

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
                                <ul class="mt-2">
                                    @foreach (json_decode($places->images, true) as $image)
                                        <li><img src="{{ asset($image) }}" width="100px"></li>
                                    @endforeach
                                </ul>
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

                            <!-- Place Status -->
                            <div class="col-sm-6">
                                <label class="col-form-label font-weight-bold">Status</label>
                                <select class="form-control @error('country_status') is-invalid @enderror"
                                    name="country_status">
                                    <option value="active" {{ old('country_status', $places->status) == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ old('country_status', $places->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error('country_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Itinerary Section -->
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label class="col-form-label font-weight-bold">Itinerary</label>
                                <div id="itinerary-container">
                                    @foreach (json_decode($place->itinerary, true) as $index => $item)
                                        <div class="itinerary-item row" id="itinerary-{{ $index }}">
                                            <div class="col-sm-4">
                                                <input class="form-control" name="itinerary[{{ $index }}][day]" type="text"
                                                    placeholder="Day" required
                                                    value="{{ old('itinerary.' . $index . '.day', $item['day']) }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="itinerary[{{ $index }}][title]"
                                                    type="text" placeholder="Title" required
                                                    value="{{ old('itinerary.' . $index . '.title', $item['title']) }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" name="itinerary[{{ $index }}][details]"
                                                    placeholder="Details"
                                                    required>{{ old('itinerary.' . $index . '.details', $item['details']) }}</textarea>
                                            </div>
                                            <div class="col-sm-12 mt-2">
                                                <button type="button"
                                                    class="btn btn-danger remove-itinerary-btn mb-3">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-itinerary-btn" class="btn btn-info">Add Itinerary
                                    Day</button>
                            </div>
                        </div>
                        <!-- Submit and Cancel Buttons -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle dynamic itinerary fields and remove buttons -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addItineraryButton = document.getElementById('add-itinerary-btn');
        const itineraryContainer = document.getElementById('itinerary-container');
        let itineraryIndex = {{ count(json_decode($places->itinerary, true)) }};

        // Add a new itinerary day when the button is clicked
        addItineraryButton.addEventListener('click', function () {
            const newItinerary = document.createElement('div');
            newItinerary.classList.add('itinerary-item', 'row');
            newItinerary.id = 'itinerary-' + itineraryIndex;
            newItinerary.innerHTML = `
                <div class="col-sm-4">
                    <input class="form-control" name="itinerary[${itineraryIndex}][day]" type="text" placeholder="Day" required>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" name="itinerary[${itineraryIndex}][title]" type="text" placeholder="Title" required>
                </div>
                <div class="col-sm-4">
                    <textarea class="form-control" name="itinerary[${itineraryIndex}][details]" placeholder="Details" required></textarea>
                </div>
                <div class="col-sm-12 mt-2">
                    <button type="button" class="btn btn-danger remove-itinerary-btn mb-3">Remove</button>
                </div>
            `;
            itineraryContainer.appendChild(newItinerary);
            itineraryIndex++;

            // Add event listener to the newly created "Remove" button
            const removeButtons = document.querySelectorAll('.remove-itinerary-btn');
            removeButtons[removeButtons.length - 1].addEventListener('click', function () {
                newItinerary.remove(); // Remove this itinerary day
            });
        });

        // Delegate remove buttons functionality
        itineraryContainer.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-itinerary-btn')) {
                e.target.closest('.itinerary-item').remove(); // Remove the specific itinerary day
            }
        });
    });
</script>

@endsection