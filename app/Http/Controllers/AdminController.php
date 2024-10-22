<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function manageUsers(Request $request)
    {
        // Autorisatiecontrole: alleen admin mag deze actie uitvoeren
        $this->authorize('manage', User::class);

        // Haal gebruikers op met paginering
        $users = User::paginate(10); //  10 gebruikers per pagina?

        return view('admin.admin-index', compact('users'));
    }
}
