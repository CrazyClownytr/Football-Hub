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
    public function index(Request $request): View
    {
// Haal de categorie_id op uit de request, als die bestaat
        $categoryId = $request->get('category');

        // Haal alle categorieën op voor de filteropties
        $categories = Category::all();

        if ($categoryId) {
            // Haal foto's op die bij de geselecteerde categorie horen
            $photos = Photo::where('category_id', $categoryId)->get();
        } else {
            // Haal alle foto's op als er geen categorie is geselecteerd
            $photos = Photo::all();
        }

        // Retourneer de view met de foto's en categorieën
        return view('photos.index', compact('photos', 'categories'));

    }

//    public function restore($id)
//    {
//        $photo = Photo::withTrashed()->find($id);
//        $photo->restore();
//
//        return redirect()->route('photos.index')->with('success', 'Photo restored successfully!');
//    }


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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|file|image|max:2048'
        ], [
            'title.required' => 'You must fill in the title',
            'description.required' => 'You must fill in the description',
            'category_id.required' => 'You must choose a league',
        ]); //valideren, komende les wel


        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->category_id = $request->input('category_id');
        $photo->user_id = auth()->id();

        // $photo->image ='default url';
        //  $photo->user_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $nameOfFile = $request->file('image')->storePublicly('images', 'public');
            $photo->image = $nameOfFile; // Opslaan van het pad naar de afbeelding in de database
        }

        // Opslaan van het Photo-model in de database
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
    public function edit(Photo $photo)
    {
        $categories = Category::all(); // Haal de categorieën op voor de dropdown

        return view('photos.edit', [
            'photo' => $photo,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|file|image|max:2048' // Optioneel veld voor afbeelding
        ]);

        // Update de attributen van de foto
        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->category_id = $request->input('category_id');

        // Als er een nieuwe afbeelding is geüpload, werk dan het pad bij
        if ($request->hasFile('image')) {
            $nameOfFile = $request->file('image')->storePublicly('folder-name', 'public');
            $photo->image = $nameOfFile;
        }

        // Sla de wijzigingen op
        $photo->save();

        // Redirect naar de indexpagina met een succesbericht
        return redirect()->route('photos.index')->with('success', 'Photo updated successfully!');
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
