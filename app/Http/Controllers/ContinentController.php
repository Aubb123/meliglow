<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ContinentController extends Controller
{
    public function backend_continents_index(): View|RedirectResponse
    {
        $continents = Continent::all();
        return view('backend/pages/continents/index', compact('continents'));
    }

    public function backend_continents_create(): View|RedirectResponse
    {
        return redirect()->back()->with('error', 'La gestion des continents n\'est pas encore disponible.');
    }

    public function backend_continents_store(Request $request): RedirectResponse
    {
        return redirect()->back()->with('error', 'La gestion des continents n\'est pas encore disponible.');
    }

    public function backend_continents_show($token): View|RedirectResponse
    {
        $continent = Continent::where('token', $token)->first();
        if (!$continent) {
            return redirect()->back()->with('error', 'Continent non trouvé.');
        }
        return view('backend/pages/continents/show', compact('continent'));
    }

    public function backend_continents_countries($token): View|RedirectResponse
    {
        $continent = Continent::where('token', $token)->first();
        if (!$continent) {
            return redirect()->back()->with('error', 'Continent non trouvé.');
        }

        $countries = $continent->countries;
        return view('backend/pages/continents/others/countries', compact('continent', 'countries'));
    }

}
