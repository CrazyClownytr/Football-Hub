<?php

namespace App\Http\Controllers;

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
        $photos = Photo::all();
        return view('photos.index', compact('photos')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photos): View
    {
        return view('photos.show', [
            'photos' => $photos
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
    public function destroy(Photo $photos)
    {
        //
    }
}
