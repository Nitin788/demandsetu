<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Display all countries
    public function index()
    {
        $countries = Country::where('status', 'active')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.countrylist', compact('countries'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.addcountry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'country_name' => 'required|string|max:255|unique:countries,name',
            'country_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'country_status' => 'required|string'
        ]);

        // Get the uploaded file
        $file = $request->file('country_image');
        $path = 'country_images/'; 
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($path), $filename);

        // Create a new country record with the image path
        Country::create([
            'name' => $request->country_name,
            'image' => $path . $filename, // Store the relative path to the image
            'status' => $request->country_status
        ]);

        return redirect()->route('countries.index')->with('success', 'Country added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $countries = Country::findOrFail($id);
        return view('admin.editcountry', compact('countries'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'country_name' => 'required|string|max:255', // Exclude the current country name
            'country_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Image is optional during update
            'country_status' => 'required|string'
        ]);

        // Find the country by its ID
        $countries = Country::findOrFail($id);

        // Handle image upload if a new image is provided
        if ($request->hasFile('country_image')) {
            // Delete the old image if it exists
            if ($countries->image && file_exists(public_path($countries->image))) {
                unlink(public_path($countries->image));
            }
            // Get the uploaded file
            $file = $request->file('country_image');

            // Define the upload path relative to the public folder
            $path = 'country_images/'; // Folder where images are stored in the public directory

            // Generate a unique filename for the new image
            $filename = time() . '_' . $file->getClientOriginalName();

            // Move the file to the public directory
            $file->move(public_path($path), $filename);

            // Update the country image path in the database
            $countries->image = $path . $filename;
        }

        // Update country details without changing the image unless a new one is uploaded
        $countries->name = $request->country_name;
        $countries->status = $request->country_status;

        // Save the updated country record
        $countries->save();

        // Redirect back with a success message
        return redirect()->route('countries.index')->with('success', 'Country updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Delete the specified country
    public function destroy($id)
    {
        $countries = Country::findOrFail($id);
        // Delete the country record
        $countries->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted successfully!');
    }
}
