<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CountryController extends Controller
{
    public function backend_countries_index(): View|RedirectResponse
    {
        $countries = Country::all();
        return view('backend/pages/countries/index', compact('countries'));
    }

    public function backend_countries_create(): View|RedirectResponse
    {
        return redirect()->back()->with('error', 'La gestion des pays n\'est pas encore disponible.');
    }

    public function backend_countries_store(Request $request): RedirectResponse
    {
        return redirect()->back()->with('error', 'La gestion des pays n\'est pas encore disponible.');
    }

    public function backend_countries_show($token): View|RedirectResponse
    {
        $country = Country::where('token', $token)->first();
        
        if (!$country) {
            return redirect()->back()->with('error', 'Pays non trouvé.');
        }
        return view('backend/pages/countries/show', compact('country'));
    }
}
