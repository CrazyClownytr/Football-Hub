<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function manageUsers(Request $request)
    {
        // Autorisatiecontrole: alleen admin mag deze actie uitvoeren
        $this->authorize('manage', User::class);

        // Haal gebruikers op met paginering
        $users = User::paginate(10); //  10 gebruikers per pagina

        return view('admin.admin-index', compact('users'));
    }

    public function adminPhotosIndex(): View
    {
        // Haal alle foto's op, inclusief soft deleted
        $photos = Photo::withTrashed()->get();

        return view('admin.photos-index', compact('photos'));
    }

    public function restorePhoto($id)
    {
        // Vind de foto, inclusief soft deleted
        $photo = Photo::withTrashed()->find($id);

        // Controleer of de foto bestaat
        if ($photo) {
            $photo->restore();
            return redirect()->route('admin.photos-index')->with('status', 'Photo restored successfully!');
        }

        return redirect()->route('admin.photos-index')->with('error', 'Photo not found.');
    }

}
