<?php

namespace App\Http\Controllers;

use App\Models\Homepage;
use Illuminate\Http\Request;
class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch homepages and decode the JSON fields
        $homepages = Homepage::orderBy('id', 'desc')->paginate(10);

        // Decode the JSON fields to arrays
        foreach ($homepages as $homepage) {
            $homepage->slider_images = json_decode($homepage->banner_image_title, true);
            $homepage->offer_image = json_decode($homepage->offer_image, true);
            $homepage->offer_card = json_decode($homepage->offer_card, true);
        }
        return view('admin.homepagelist', compact('homepages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.addhomepagedata');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'slider_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'titles.*' => 'required|string|max:255',
            'session_banners.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'card_title.*' => 'required|string|max:255', // Card section title
            'card_images.*.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg', // Multiple images for each section
            'card_destinations.*.*' => 'required|string|max:255', // Multiple destinations for each section
        ]);
        // Process Slider Images and Titles
        $sliderData = [];
        if ($request->hasFile('slider_images') && $request->has('titles')) {
            foreach ($request->file('slider_images') as $key => $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('slider_images/'), $filename);
                $sliderData[] = [
                    'image' => 'slider_images/' . $filename,
                    'title' => $request->titles[$key],
                ];
            }
        }
        // Process Session Banners
        $sessionBanners = [];
        if ($request->hasFile('session_banners')) {
            foreach ($request->file('session_banners') as $banner) {
                $filename = uniqid() . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('session_banners/'), $filename);
                $sessionBanners[] = 'session_banners/' . $filename;
            }
        }
        // Process Card Sections (offer_card)
        $offerCardData = [];
        if ($request->has('card_title') && $request->has('card_images') && $request->has('card_destinations')) {
            foreach ($request->card_title as $sectionIndex => $sectionTitle) {
                // For each card section, gather the corresponding images and destinations
                $cards = [];
                foreach ($request->card_images[$sectionIndex] as $key => $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('card_images/'), $filename);
                    $cards[] = [
                        'image' => 'card_images/' . $filename,
                        'destination' => $request->card_destinations[$sectionIndex][$key],
                    ];
                }
                // Add the section title and its associated cards to the offerCardData array
                $offerCardData[] = [
                    'title' => $sectionTitle,
                    'cards' => $cards,
                ];
            }
        }
        // Save the data to the database (assuming you have a `Homepage` model)
        Homepage::create([
            'banner_image_title' => json_encode($sliderData),  // Store slider images and titles as JSON
            'offer_image' => json_encode($sessionBanners),      // Store session banners as JSON
            'offer_card' => json_encode($offerCardData),        // Store card sections with titles and cards as JSON
        ]);

        // Redirect with success message
        return redirect()->route('homepages.index')->with('success', 'Home Page Data added successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Homepage $homepages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the homepage by ID
        $homepages = HomePage::find($id);

        // Check if the 'slider_images' field is a string (maybe stored as JSON)
        if (is_string($homepages->slider_images)) {
            $homepages->slider_images = json_decode($homepages->slider_images, true); // Decode the JSON to an array
        }
        // Check if 'titles' is stored as a string, decode it if necessary
        if (is_string($homepages->titles)) {
            $homepages->titles = json_decode($homepages->titles, true);
        }
        // Check if 'offer_image' is stored as a string, decode it if necessary
        if (is_string($homepages->offer_image)) {
            $homepages->offer_image = json_decode($homepages->offer_image, true);
        }
        // Check if 'offer_card' is a string and decode it if it is
        if (is_string($homepages->offer_card)) {
            $homepages->offer_card = json_decode($homepages->offer_card, true); // Decoding JSON to an array
        }
        // Pass the homepage data to the edit view
        return view('admin.edithomepage', compact('homepages'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'titles.*' => 'nullable|string|max:255',
            'session_banners.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',  // Handle multiple session banners
            'card_title.*' => 'nullable|string|max:255',  // Card section title
            'card_images.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',  // Multiple images for each section
            'card_destinations.*.*' => 'nullable|string|max:255',  // Multiple destinations for each section
        ]);

        // Find the existing homepage record by ID
        $homepage = Homepage::findOrFail($id);

        // Process Slider Images and Titles
        $sliderData = json_decode($homepage->banner_image_title, true); // Get existing data
        if ($request->hasFile('slider_images') && $request->has('titles')) {
            $sliderData = []; // Reset slider data if new images are uploaded
            foreach ($request->file('slider_images') as $key => $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('slider_images/'), $filename);
                $sliderData[] = [
                    'image' => 'slider_images/' . $filename,
                    'title' => $request->titles[$key],
                ];
            }
        }

        // Process Session Banners
        $sessionBanners = json_decode($homepage->offer_image, true); // Get existing data
        if ($request->hasFile('session_banners')) {
            $sessionBanners = []; // Reset session banners if new images are uploaded
            foreach ($request->file('session_banners') as $banner) {
                $filename = uniqid() . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('session_banners/'), $filename);
                $sessionBanners[] = 'session_banners/' . $filename;
            }
        }

        // Process Card Sections (offer_card)
        $offerCardData = json_decode($homepage->offer_card, true); // Get existing data
        if ($request->has('card_title') && $request->has('card_images') && $request->has('card_destinations')) {
            $offerCardData = []; // Reset card data if new sections are uploaded
            foreach ($request->card_title as $sectionIndex => $sectionTitle) {
                // For each card section, gather the corresponding images and destinations
                $cards = [];
                foreach ($request->card_images[$sectionIndex] as $key => $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('card_images/'), $filename);
                    $cards[] = [
                        'image' => 'card_images/' . $filename,
                        'destination' => $request->card_destinations[$sectionIndex][$key],
                    ];
                }
                // Add the section title and its associated cards to the offerCardData array
                $offerCardData[] = [
                    'title' => $sectionTitle,
                    'cards' => $cards,
                ];
            }
        }

        // Update the homepage record with the new data
        $homepage->update([
            'banner_image_title' => json_encode($sliderData),  // Store slider images and titles as JSON
            'offer_image' => json_encode($sessionBanners),      // Store session banners as JSON
            'offer_card' => json_encode($offerCardData),        // Store card sections with titles and cards as JSON
        ]);

        // Redirect with success message
        return redirect()->route('homepages.index')->with('success', 'Home Page Data updated successfully!');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homepage $homepages, $id)
    {
        $homepages = Homepage::findOrFail($id);
        $homepages->delete();
        return redirect()->route('homepages.index')->with('success', 'Home Page Data has been deleted successfully!');
    }
}
