<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Destination;
use App\Models\Country;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the total count of places and destinations
        $totalPlaces = Place::count();
        $destinationCount = Destination::count();

        // Retrieve all destinations
        $destinations = Destination::all();

        // Retrieve all countries for the filter (if necessary)
        $countries = Country::all();

        // Get filter parameters from the request
        $destinationName = $request->get('destination');
        $countryId = $request->get('country_id');
        

        // Initialize the query for places
        $placesQuery = Place::query();

        // Filter by destination if a name is provided
        if ($destinationName && $destinationName !== 'all') {
            $destination = Destination::where('name', $destinationName)->first();
            if ($destination) {
                $placesQuery->where('destination_id', $destination->id);
            }
        }

        // Filter by country if country_id is provided
        if ($countryId) {
            $placesQuery->whereHas('destination', function ($query) use ($countryId) {
                $query->where('country_id', $countryId);
            });
        }

        // Default: Show latest 8 places if no filters are applied
        $places = (!$destinationName && !$countryId)
            ? $placesQuery->latest()->take(8)->get()  // Latest 8 places
            : $placesQuery->get();  // All matching places

        // Return view with data
        return view('admin.dashboard', compact(
            'places',
            'destinations',
            'destinationCount',
            'totalPlaces',
            'countries',
            'destinationName',
            'countryId'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
