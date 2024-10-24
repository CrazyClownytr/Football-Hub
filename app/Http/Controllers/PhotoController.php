<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Laravel\Prompts\error;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
// Haal de categorie_id op uit de request, als die bestaat
        $categoryId = $request->get('category');
        $searchTerm = $request->get('search');

        $query = Photo::query();

        // Haal alle categorieën op voor de filteropties
        $categories = Category::all();

        if ($categoryId) {
            // Haal foto's op die bij de geselecteerde categorie horen
            $photos = Photo::where('category_id', $categoryId)->get();
        } else {
            // Haal alle foto's op als er geen categorie is geselecteerd
            $photos = Photo::all();
        }


        // Als er een zoekterm is, filter dan op titel en beschrijving
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        $photos = $query->get();

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
    public function create() //: View // IS GET
    {

        $categories = Category::all();

        $user = auth()->user();

        // Controleer of de gebruiker minstens 5 likes heeft geplaatst
        if ($user->likes()->count() < 5) {
            return redirect()->back()->with('message', 'You need to like at least 5 photos before creating a new post.');
        }


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
        return view('photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {

        if (auth()->id() !== $photo->user_id) {
            abort(403, 'you do not have permission to edit this post');
        }

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

        if (auth()->id() !== $photo->user_id) {
            abort(403, 'you do not have permission to update this post');
        }

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
        if (auth()->id() !== $photo->user_id) {
            abort(403, 'you do not have permission to delete this post');
        }
        $photo->delete();
        return redirect()->route('photos.index')->with('status', 'Photo deleted successfully');
    }

    public function like($photoId)
    {
        if (!auth()->check()) {
            // Als de gebruiker niet ingelogd is, doorsturen naar de login-pagina
            return redirect()->route('login')->with('message', 'You need to log in to like a photo.');
        }
        
        $photo = Photo::findOrFail($photoId);
        $user = auth()->user();

        // Check of de gebruiker de foto al heeft geliked
        if ($photo->likes()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('message', 'You already liked this photo.');
        }

        // Voeg een like toe
        $photo->likes()->create([
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('message', 'Photo liked successfully.');
    }

    public function unlike($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $user = auth()->user();

        // Verwijder de like
        $photo->likes()->where('user_id', $user->id)->delete();

        return redirect()->back()->with('message', 'Photo unliked successfully.');
    }

}
