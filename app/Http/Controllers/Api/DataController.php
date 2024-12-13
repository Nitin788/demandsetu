<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Homepage;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::with(['destinations.places'])
            ->orderBy('name', 'desc')  //
            ->get();
        foreach ($countries as $country) {
            if ($country->destinations) {
                $country->destinations = $country->destinations->sortByDesc('name');

                foreach ($country->destinations as $destination) {
                    if ($destination->places) {
                        $destination->places = $destination->places->sortByDesc('name');
                    } else {
                        $destination->places = collect();  // Initialize as empty collection if no places exist
                    }
                }
            } else {
                $country->destinations = collect();  // Initialize as empty collection if no destinations exist
            }
        }
        // Return the countries with sorted destinations and places
        return response()->json($countries);
    }
    public function homePage()
    {
        $data = Homepage::all();
        // Return data as a JSON response
        return response()->json($data);
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
