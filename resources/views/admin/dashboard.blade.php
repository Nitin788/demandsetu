@extends('admin.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <!-- Total Destinations -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ $destinationCount }}</h2>
                    <div class="m-b-5">TOTAL DESTINATIONS</div>
                    <a href="{{ route('destinations.index') }}">
                        <i class="ti-location-pin widget-stat-icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Total Places -->
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{ $totalPlaces }}</h2>
                    <div class="m-b-5">TOTAL PLACES</div>
                    <a href="{{ route('places.index') }}">
                        <i class="ti-location-pin widget-stat-icon"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Filter by Destination -->
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Filter by Destination and Country</div>
                </div>
                <div class="ibox-body">
                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-success btn-sm m-1 {{ request()->destination ? '' : 'active' }}">Dashboard</a>
                    <!-- All Destinations Link -->
                    <a href="{{ route('admin.dashboard', ['destination' => 'all']) }}" class="btn btn-outline-primary btn-sm m-1 {{ request()->destination == 'all' ? 'active' : '' }}">All Destinations</a>
                    <!-- Filter Buttons -->
                    <div class="btn-group" role="group" aria-label="Destination Filter">
                        @foreach ($destinations as $destination)
                            <a href="{{ route('admin.dashboard', ['destination' => $destination->name, 'country_id' => request()->country_id]) }}" 
                               class="btn btn-outline-primary btn-sm m-1 {{ request()->destination == $destination->name ? 'active' : '' }}">
                                {{ $destination->name }} ({{ $destination->places()->count() }})
                            </a>
                        @endforeach
                    </div>
                    <!-- Filter by Country -->
                    <div class="btn-group" role="group" aria-label="Country Filter">
                        <a href="{{ route('admin.dashboard', ['destination' => request()->destination]) }}" class="btn btn-outline-secondary btn-sm m-1">Destination Type</a>
                        @foreach ($countries as $country)
                            <a href="{{ route('admin.dashboard', ['destination' => request()->destination, 'country_id' => $country->id]) }}" 
                               class="btn btn-outline-secondary btn-sm m-1 {{ request()->country_id == $country->id ? 'active' : '' }}">
                                {{ $country->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Places Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Recent Places</div>
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
                                <th>Destination Type</th>
                                <!-- <th>Offers</th>
                                <th>Price</th>
                                <th>Sale Price</th> -->
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($places as $place)
                                <tr>
                                    <td>{{ $place->title }}</td>
                                    <td>{{ $place->destination->name ?? 'N/A' }}</td>
                                    <td>{{ $place->destination->country->name ?? 'N/A' }}</td>
                                    <!-- <td>{{ $place->offers }}</td>
                                    <td>{{ $place->price }}</td>
                                    <td>{{ $place->sale_price }}</td> -->
                                    <td>{{ ucfirst($place->status) }}</td>
                                    <td>
                                        <a href="{{ route('places.edit', $place->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('places.destroy', $place->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this place?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No places found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
