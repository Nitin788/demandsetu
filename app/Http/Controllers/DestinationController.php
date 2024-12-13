<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Country;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // Display a listing of destinations
    public function index()
    {
        $destinations = Destination::with('country')->orderBy('created_at', 'desc')->paginate('10'); // Get all destinations with their country ordered by created_at in descending order
        return view('admin.destinationlist', compact('destinations'));
    }

    // Show the form to create a new destination
    public function create()
    {
        $countries = Country::all(); // Get all countries to show in the select dropdown
        return view('admin.adddestination', compact('countries'));
    }

    // Store a newly created destination in storage
    public function store(Request $request)
    {
        // Debug: Dump all request data to ensure `country_id` is coming through
        // dd($request->all());

        // Validate the incoming request
        $request->validate([
            'country_id' => 'required|exists:countries,id',  // Validate the country_id
            'destination_name' => 'required|string|max:255|unique:destinations,name',
            'destination_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'destination_status' => 'required|string'
        ]);

        // Handle the image upload
        if ($request->hasFile('destination_image')) {
            $file = $request->file('destination_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('destination_images/'), $filename);  // Store image in 'destination_images' directory

            // Store the image path in the database
            $imagePath = 'destination_images/' . $filename;
        } else {
            $imagePath = null;  // No image uploaded, set to null
        }

        // Create the destination
        Destination::create([
            'country_id' => $request->country_id,  // Associate the destination with the country using the form data
            'name' => $request->destination_name,
            'image' => $imagePath,
            'status' => $request->destination_status
        ]);

        // Redirect to the country details page with a success message
        return redirect()->route('destinations.index')->with('success', 'Destination added successfully!');
    }
    // Show the form to edit a destination
    public function edit($id)
    {
        $destinations = Destination::findOrFail($id);
        $countries = Country::all();
        return view('admin.editdestination', compact('destinations', 'countries'));
    }

    // Update the specified destination in storage
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'country_id' => 'required|exists:countries,id',  // Validate the country_id
            'destination_name' => 'required|string|max:255||unique:destinations,name',  // Ensure unique name except for current destination
            'destination_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',  // Image is optional on update
            'destination_status' => 'required|string'
        ]);

        // Find the existing destination by ID
        $destination = Destination::findOrFail($id);

        // Handle the image upload (if there's a new image)
        if ($request->hasFile('destination_image')) {
            // Get the old image path
            $oldImagePath = $destination->image;

            // Generate a new filename and store the new image
            $file = $request->file('destination_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('destination_images/'), $filename);  // Store the new image in 'destination_images' directory

            // Set the new image path
            $imagePath = 'destination_images/' . $filename;

            // Delete the old image if it exists and is not the default
            if ($oldImagePath && file_exists(public_path($oldImagePath))) {
                unlink(public_path($oldImagePath));  // Delete the old image
            }
        } else {
            // If no new image is uploaded, retain the old image
            $imagePath = $destination->image;
        }

        // Update the destination with the new data
        $destination->update([
            'country_id' => $request->country_id,
            'name' => $request->destination_name,
            'image' => $imagePath,
            'status' => $request->destination_status
        ]);

        // Redirect to the destination list or the country page with a success message
        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully!');
    }
    // Remove the specified destination from storage
    public function destroy($id)
    {
        $destinations = Destination::findOrFail($id);
        $destinations->delete();
        return redirect()->route('destinations.index')->with('success', 'Destination deleted successfully!');
    }
    public function Search(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Query the destinations and apply the search filter if a search term is provided
        $destinations = Destination::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('country', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        })
            ->with('country') // If you need to eager load the related country
            ->paginate(10) // Adjust the pagination if needed
            ->appends(['search' => $search]);  // Keeps search query in pagination links

        // Return the view with the destinations data
        return view('admin.destinationlist', compact('destinations', 'search'));
    }

}