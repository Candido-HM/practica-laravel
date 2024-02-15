<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);
        //$request y lo mismo ->user....
        // Insertar dato en la base de datos
        // auth()->user()->chirps()->create([
        //     'message' => $request->get('message')
        // ]);
        auth()->user()->chirps()->create($validate);

        // session()->flash('status', 'Chirp created successfully!');

        return to_route('chirps.index')
            ->with('status', __('Chirp created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {   
        $this->authorize('update', $chirp);
        // if (auth()->user()->isNot($chirp->user)){
        //     abort(403);
        // }
        return view('chirps.edit', [
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        // if (auth()->user()->isNot($chirp->user)){
        //     abort(403);
        // }
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255']
        ]);
        $chirp->update($validated);

        return to_route('chirps.index')
            ->with('status', __('Chirp updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return to_route('chirps.index')
            ->with('status', __('Chirp deleted successfully!'));
    }
}
