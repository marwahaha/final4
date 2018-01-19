<?php

namespace App\Http\Controllers;

use App\Entities\Event;
use App\Entities\SeatMap;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $data = [];

        foreach ($events as $event) {
            $singleEvent = [
                'name' => $event->name,
                'url' => env('APP_URL') . '/event/' . $event->slug,
                'description' => $event->description,
                'cover_photo' => '/img/cover-photos/' . $event->cover_photo,
            ];

            array_push($data, $singleEvent);
        }

        return response()->json($data, 200);
    }

    public function create()
    {
        $seatMaps = SeatMap::all();

        return view('dashboard.entities.event.create', compact('seatMaps'));
    }

    public function store(Request $request)
    {
        $event = Event::createNew($request);

        return redirect()->action('EventController@edit', ['id' => $event->id]);
    }

    public function show($slug)
    {
        // @TODO Add Venue mapping for the Event and detect the mobile users. If the user
        // @is not on mobile device, show seat mapping.
        $event = Event::where('slug', '=', $slug)->first();
        $rates = $event->rates;

        if (Agent::isMobile() || Agent::isTablet()) {
            return 'This is mobile.';
        } else {
            return view('frontend.entities.event.show', compact('event', 'rates'));
        }
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $seatMaps = SeatMap::all();

        return view('dashboard.entities.event.edit', compact('event', 'seatMaps'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::updateEntity($request, $id);

        return redirect()->action('EventController@edit', ['id' => $event->id]);
    }

    public function destroy($id)
    {

    }

    public function getSeatMap($id)
    {
        $event = Event::findOrFail($id);

        return json_encode($event->seatMap->mapping, true);
    }

    public function seatSelection($id)
    {
        $event = Event::findOrFail($id);
        $rates = $event->rates;

        return view('frontend.entities.event.seat-selection', compact('event', 'rates'));
    }
}
