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

        //zoekbalk en category filter req
        $categoryId = $request->get('category');
        $searchTerm = $request->get('search');

        // fotos tonen die niet softdelete zijn en actieve status hebben
        $query = Photo::whereNull('deleted_at')
            ->where('status', 'active');

        // foto's categorize als ze id hebben
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
// zoekbalk voor title en description
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // foto's en categories ophalen
        $photos = $query->get();
        $categories = Category::all();

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

        // min 5 likes om een post te maken, onbeperkt voor admin
        if ($user->isAdmin() || $user->likes()->count() >= 5) {
            return view('photos.create', [
                'categories' => $categories
            ]);
        } else {
            return redirect()->back()->with('message', 'You need to like at least 5 photos before creating a new post.');
        }


        //dd(vars: "Get Request van create");

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
            'image' => 'You must upload a photo',
        ]); //valideren, komende les


        $photo->title = $request->input('title');
        $photo->description = $request->input('description');
        $photo->category_id = $request->input('category_id');
        $photo->user_id = auth()->id();


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
        $photo->status = 'inactive'; // Zet de status naar 'inactive'
        $photo->save(); // Sla de status op, alleen nodig als je het echt wilt bijwerken

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

    // app/Http/Controllers/PhotoController.php

    public function toggleStatus($id)
    {
        // zoek alle foto's op, incl deleted
        $photo = Photo::withTrashed()->findOrFail($id);

        // als foto deleted is
        if ($photo->deleted_at) {
            //die herstellen
            $photo->restore();
            //status naar actief zetten
            $photo->status = 'active';
            $message = 'De foto is succesvol hersteld naar actief.';
        } else {
            //als het bestaat
            // foto deleten
            $photo->delete();
            // status naar inactief zetten
            $photo->status = 'inactive';
            $message = 'De foto is succesvol gemarkeerd als inactief.';
        }

        // status opslaan
        $photo->save();

        // message tonen op admin photo index
        return redirect()->route('admin.photos-index')->with('success', $message);
    }


}
