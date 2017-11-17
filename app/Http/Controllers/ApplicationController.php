<?php

namespace App\Http\Controllers;

use App\Entities\Hotel;
use App\Entities\Rate;
use App\Entities\Sale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        if (env('SITE_OFFLINE')) {
            return view('layouts.countdown');
        }
        $rates = Rate::where('available_online', '=', true)->get()->sortByDesc('price');

        return view('frontend.index', compact('rates'));
    }

    public function dashboard()
    {
        $sales = Sale::all()->take(10);
        $customers = User::where('is_admin', '=', false)->get();
        $hotels = Hotel::all();

        return view('dashboard.index', compact('sales', 'customers', 'hotels'));
    }

    public function getVenue()
    {
        $venue = Storage::read('/public/venue.json');
        return $venue;
    }
}
