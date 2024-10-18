<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // $photos = Photo::all();
        $photos = Photo::withTrashed()->get();

        return view('photos.index', compact('photos')
        );


    }

    public function restore($id)
    {
        $photo = Photo::withTrashed()->find($id);
        $photo->restore(); // Herstelt het record

        return redirect()->route('photos.index')->with('success', 'Photo restored successfully!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View // IS GET
    {

        $categories = Category::all();

        //dd(vars: "Get Request van create");
        return view('photos.create', [
            'categories' => $categories
        ]); //nieuwe view maken
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // IS POST, DUS PAS NA SUBMIT
    {
        $photo = new Photo();
        //  $request->validate(); valideren, komende les wel

        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->category_id = $request->input('category_id');
        $photo->user_id = auth()->id();

        // $photo->image ='default url';
        //  $photo->user_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $filePath = 'images/' . $fileName; // Zet het bestandspad in de 'images' map onder public

            // Verplaats het bestand naar de public/images map
            $request->file('image')->move(public_path('images'), $fileName);

            $photo->image = $filePath; // Opslaan van het bestandspad in de database
        }
        $photo->save();

        //terug gaan van waar je vandaan komt
        return redirect()->route('photos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo): View //enkelvoud, check chatgpt om te connecten met view
    {
        return view('photos.show', [
            'photo' => $photo
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        // dd(request()->all()); // Controleer de inkomende request data
        $photo->delete();
        return redirect()->route('photos.index')->with('status', 'Photo deleted successfully');
    }
}
