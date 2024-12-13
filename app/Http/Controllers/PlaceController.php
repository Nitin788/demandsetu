<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Place;
use Illuminate\Support\Str;
class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::where('status', 'active') // Filter by active status
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.placelist', compact('places'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::all(); // Get all destinations from the database
        return view('admin.addplace', compact('destinations'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'destination_id' => 'required|exists:destinations,id', // Validate the destination_id
            'title' => 'required|string|max:255|unique:places,title',
            'about' => 'required|string|max:500',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'offers' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'description' => 'required|string',
            'country_status' => 'required|in:active,inactive', // Validate the status
            'itinerary.*.day' => 'required|string', // Validate itinerary day
            'itinerary.*.title' => 'required|string|max:255', // Validate itinerary title
            'itinerary.*.details' => 'required|string', // Validate itinerary details
        ]);
        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('place_images'), $filename); // Store images in the 'place_images' directory
                $imagePaths[] = 'place_images/' . $filename;
            }
        }
        // Retrieve the selected destination name
        $destination = Destination::find($request->destination_id);
        $destinationName = $destination ? $destination->name : 'default';  // Default fallback if destination is not found
        // Generate the slug based on the destination name and the title
        $slugBase = Str::slug($destinationName . ' ' . $request->title); // Combining destination name with title
        $slug = $slugBase;
        // Ensure the slug is unique
        $count = 1;
        while (Place::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $count;
            $count++;
        }
        // Prepare the itinerary data (if provided)
        $itineraryData = $request->has('itinerary') ? $request->itinerary : null;

        // Store the place data in the database
        $place = Place::create([
            'destination_id' => $request->destination_id,
            'title' => $request->title,
            'about' => $request->about,
            'images' => json_encode($imagePaths), // Save the array of image paths as a JSON string
            'offers' => $request->offers,
            'duration' => $request->duration,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'description' => $request->description,
            'itinerary' => $itineraryData ? json_encode($itineraryData) : null, // Save the itinerary as JSON
            'status' => $request->country_status,
            'slug' => $slug, // Save the generated slug
        ]);

        // Redirect to the places list page with a success message
        return redirect()->route('places.index')->with('success', 'Place added successfully!');
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
    public function edit($id)
    {
        $places = Place::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.editplace', compact('places', 'destinations'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'destination_id' => 'required|exists:destinations,id', // Validate the destination_id
            'title' => 'required|string|max:255|unique:places,title,' . $id, // Make sure the title is unique excluding the current place
            'about' => 'required|string|max:500',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'offers' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'description' => 'required|string',
            'country_status' => 'required|in:active,inactive', // Validate the status
            'itinerary.*.day' => 'required|string', // Validate itinerary day
            'itinerary.*.title' => 'required|string|max:255', // Validate itinerary title
            'itinerary.*.details' => 'required|string', // Validate itinerary details
        ]);

        // Find the place to update
        $place = Place::findOrFail($id);

        // Handle image upload (if new images are provided)
        $imagePaths = json_decode($place->images, true); // Existing images in case no new ones are uploaded
        if ($request->hasFile('images')) {
            // Remove old images if necessary (this is optional, depending on your use case)
            foreach ($imagePaths as $imagePath) {
                $oldImagePath = public_path($imagePath);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image file
                }
            }

            // Upload new images
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('place_images'), $filename); // Store images in the 'place_images' directory
                $imagePaths[] = 'place_images/' . $filename;
            }
        }

        // Retrieve the selected destination name
        $destination = Destination::find($request->destination_id);
        $destinationName = $destination ? $destination->name : 'default';  // Default fallback if destination is not found

        // Generate the slug based on the destination name and the title
        $slugBase = Str::slug($destinationName . ' ' . $request->title); // Combining destination name with title
        $slug = $slugBase;

        // Ensure the slug is unique (excluding the current place's slug)
        $count = 1;
        while (Place::where('slug', $slug)->where('id', '<>', $id)->exists()) {
            $slug = $slugBase . '-' . $count;
            $count++;
        }

        // Prepare the itinerary data (if provided)
        $itineraryData = $request->has('itinerary') ? $request->itinerary : null;

        // Update the place data in the database
        $place->update([
            'destination_id' => $request->destination_id,
            'title' => $request->title,
            'about' => $request->about,
            'images' => json_encode($imagePaths), // Save the array of image paths as a JSON string
            'offers' => $request->offers,
            'duration' => $request->duration,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'description' => $request->description,
            'itinerary' => $itineraryData ? json_encode($itineraryData) : null, // Save the itinerary as JSON
            'status' => $request->country_status,
            'slug' => $slug, // Save the generated slug
        ]);

        // Redirect to the places list page with a success message
        return redirect()->route('places.index')->with('success', 'Place updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $places = Place::findOrFail($id);
        $places->delete();
        return redirect()->route('places.index')->with('success', 'Place deleted successfully!');
    }
    public function search(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Query the places and apply the search filter if a search term is provided
        $places = Place::when($search, function ($query, $search) {
            // Apply search on title, offers, price, and sale price
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('offers', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('sale_price', 'like', '%' . $search . '%');
            // If you want to search by the destination name (not destination_id), we use a join here
            $query->orWhereHas('destination', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })
            ->with('destination')  // Eager load the destination relation
            ->paginate(10)  // Adjust the pagination if needed
            ->appends(['search' => $search]);  // Ensure the search term is appended to pagination links
        // Return the view with the places data
        return view('admin.placelist', compact('places'));
    }
}
