@extends('admin.app')

@section('content')
<div class="page-heading">
    <h1 class="page-title">Home Page Form</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('homepages.index') }}">Home Page Form</a>
        </li>
        <li class="breadcrumb-item" style="margin-left: 30px;">
            <a href="{{ route('homepages.index') }}">Home Page List</a>
        </li>
    </ol>
</div>

<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Home Page Form</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('homepages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Display All Errors (if any) -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Slider Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Slider Section</h5>
                            </div>
                            <div class="card-body">
                                <div id="slider-container">
                                    <!-- Slider Image and Title Group -->
                                    <div class="form-group row slider-group">
                                        <label class="col-sm-2 col-form-label font-weight-bold">Slider Image</label>
                                        <div class="col-sm-4">
                                            <input class="form-control @error('slider_images.*') is-invalid @enderror" name="slider_images[]" type="file">
                                            @error('slider_images.*')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <label class="col-sm-2 col-form-label font-weight-bold">Title</label>
                                        <div class="col-sm-3">
                                            <input class="form-control @error('titles.*') is-invalid @enderror" name="titles[]" type="text" placeholder="Enter a title">
                                            @error('titles.*')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Add More Slider Row Button -->
                                <div class="form-group row">
                                    <div class="col-sm-10 ml-sm-auto">
                                        <button type="button" id="add-slider-row" class="btn btn-success">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Session Banner Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="font-weight-bold">Session Banner Section</h5>
                            </div>
                            <div class="card-body">
                                <div id="banner-container">
                                    <!-- Session Banner Row (minimum 2 required) -->
                                    <div class="form-group row banner-group">
                                        <label class="col-sm-2 col-form-label font-weight-bold">Offer Banner</label>
                                        <div class="col-sm-4">
                                            <input class="form-control @error('session_banners.*') is-invalid @enderror" name="session_banners[]" multiple type="file">
                                            @error('session_banners.*')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Sections Container -->
                        <div id="card-sections-container">
                            <!-- Example Initial Section (Dynamic Section Will Be Cloned From Here) -->
                            <div class="card mb-4 card-section" id="card-section-1">
                                <div class="card-header">
                                    <h5 class="font-weight-bold">Card Section</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Card Title Field -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label font-weight-bold">Card Title</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name="card_title[]" type="text" placeholder="Enter card title">
                                        </div>
                                    </div>

                                    <!-- Card Container for Each Section -->
                                    <div id="card-container-1" class="card-container">
                                        <div class="form-group row card-group">
                                            <div class="col-sm-3">
                                                <label class="font-weight-bold">Card Image</label>
                                                <input class="form-control" name="card_images[0][]" type="file">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="font-weight-bold">Card Destination</label>
                                                <input class="form-control" name="card_destinations[0][]" type="text" placeholder="Enter card destination">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add New Row Button -->
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-success btn-add-card-row">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button to Add New Section -->
                        <div class="row mb-3 ml-2">
                            <div class="btn-1 mr-3">
                                <button type="button" id="add-new-card-section" class="btn btn-success">+ Add New Section</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <button class="btn btn-primary" type="submit">Save</button>
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
        const sliderContainer = document.getElementById('slider-container');
        const addButton = document.getElementById('add-slider-row');

        // Add a new row dynamically
        addButton.addEventListener('click', function () {
            const newRow = document.createElement('div');
            newRow.classList.add('form-group', 'row', 'slider-group');

            newRow.innerHTML = `
            <label class="col-sm-2 col-form-label font-weight-bold">Slider Image</label>
            <div class="col-sm-4">
                <input class="form-control" name="slider_images[]" type="file">
            </div>
            <label class="col-sm-2 col-form-label font-weight-bold">Title</label>
            <div class="col-sm-3">
                <input class="form-control" name="titles[]" type="text" placeholder="Enter a title">
            </div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-danger btn-remove-row">X</button>
            </div>
        `;
            sliderContainer.appendChild(newRow);
        });

        // Remove a row dynamically but ensure at least one row is present
        sliderContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove-row')) {
                const sliderGroups = document.querySelectorAll('.slider-group');
                if (sliderGroups.length > 1) {
                    e.target.closest('.slider-group').remove();
                } else {
                    alert('At least one slider image and title are required.');
                }
            }
        });
    });

    // Add a new card row when the Add Card button is clicked
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('btn-add-card-row')) {
            const cardContainer = event.target.closest('.card-body').querySelector('.card-container');
            const sectionIndex = [...document.querySelectorAll('.card-section')].indexOf(event.target.closest('.card-section')); // Get section index
            const rowCount = cardContainer.querySelectorAll('.form-group.row').length; // Get current row count for the section

            const newCardRow = document.createElement('div');
            newCardRow.classList.add('form-group', 'row', 'card-group');
            newCardRow.innerHTML = `
            <div class="col-sm-3">
                <label class="font-weight-bold">Card Image</label>
                <input class="form-control" name="card_images[${sectionIndex}][]" type="file">
            </div>
            <div class="col-sm-3">
                <label class="font-weight-bold">Card Destination</label>
                <input class="form-control" name="card_destinations[${sectionIndex}][]" type="text" placeholder="Enter card destination">
            </div>
            <div class="col-sm-3 mt-4">
                <button type="button" class="btn btn-danger btn-remove-card-row">X</button>
            </div>
        `;
            cardContainer.appendChild(newCardRow);
        }

        // Removing a card row when the X button is clicked
        if (event.target && event.target.classList.contains('btn-remove-card-row')) {
            const cardRow = event.target.closest('.form-group.row');
            cardRow.remove();
        }

        // Adding a new full card section when the "Add New Section" button is clicked
        if (event.target && event.target.id === 'add-new-card-section') {
            const cardSectionsContainer = document.getElementById('card-sections-container');

            // Clone the last card section to create a new one
            const lastCardSection = cardSectionsContainer.querySelector('.card-section');
            const newCardSection = lastCardSection.cloneNode(true); // Create a deep copy of the section

            // Reset the inputs inside the cloned section (e.g., clear out values)
            const inputs = newCardSection.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = ''; // Clear the values of all inputs
            });

            // Update the name attributes to match the new section's index
            const sectionIndex = cardSectionsContainer.querySelectorAll('.card-section').length; // Get current section count
            newCardSection.querySelectorAll('input[name^="card_title"]').forEach(input => {
                input.name = `card_title[${sectionIndex}]`; // Update the card title input name
            });

            newCardSection.querySelectorAll('input[name^="card_images"]').forEach(input => {
                input.name = `card_images[${sectionIndex}][]`; // Update the card image input name
            });

            newCardSection.querySelectorAll('input[name^="card_destinations"]').forEach(input => {
                input.name = `card_destinations[${sectionIndex}][]`; // Update the card destination input name
            });

            // Append the new section to the container
            cardSectionsContainer.appendChild(newCardSection);
        }
    });
</script>

@endsection
