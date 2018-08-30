<?php

namespace App\Http\Controllers;

use App\Location;
use App\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::latest()->paginate(40);

        return view('track.index', ['tracks' => $tracks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('track.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $track = Track::create($request->all());


        $locations = collect();

        foreach ($request->freight_loads as $key => $freight_load) {
            if (!empty($freight_load)) {
                $locations->push([
                    'value' => $freight_load,
                    'type' => 'freight_loaded',
                    'date' => $request->freight_loaded_dates[$key]
                ]);
            }
        }

        foreach ($request->destinations as $key => $destination) {
            if (!empty($destination)) {
                $locations->push([
                    'value' => $destination,
                    'type' => 'destination',
                    'date' => $request->destination_dates[$key]
                ]);
            }
        }


        if ($locations->isNotEmpty()) {
            $track->locations()->createMany($locations->toArray());
        }

        return redirect()->route('tracks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $track = Track::where('code', $request->code)->firstOrFail();

        $destinations = $track->locations()->where('type', 'destination')->get();
        $freight_loads = $track->locations()->where('type', 'destination')->get();
        if (!empty($destinations)) {
            $from = $destinations->last()->value;
        } elseif (!empty($track->current_location)) {
            $from = $track->current_location;
        } elseif (!empty($freight_loads)) {
            $from = $freight_loads->last()->value;
        } elseif (!empty($track->at_origin)) {
            $from = $track->at_origin;
        } elseif (!empty($track->from)) {
            $from = $track->from;
        }

        $link = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $from . "&destination=" . $track->to . "&key=" . env('GOOGLE_MAPS_API_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, str_replace(' ', '%20', $link));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $api = json_decode($output);

        $start['lat'] = $api->routes[0]->legs[0]->start_location->lat;
        $start['lng'] = $api->routes[0]->legs[0]->start_location->lng;

        $end['lat'] = $api->routes[0]->legs[0]->end_location->lat;
        $end['lng'] = $api->routes[0]->legs[0]->end_location->lng;

        $distance = $api->routes[0]->legs[0]->distance->text;
        $duration['text'] = $api->routes[0]->legs[0]->duration->text;
        $duration['value'] = $api->routes[0]->legs[0]->duration->value;

        return view('show', ['track' => $track, 'start' => $start, 'end' => $end, 'distance' => $distance, 'duration' => $duration]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Track $track
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
        return view('track.edit', ['track' => $track]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Track $track
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Track $track)
    {
        $track->update($request->all());

        $locations = collect();

        if (!empty($request->freight_loads)) {
            foreach ($request->freight_loads as $key => $freight_load) {
                $locations->push([
                    'value' => $freight_load,
                    'type' => 'freight_loaded',
                    'date' => $request->freight_loaded_dates[$key]
                ]);
            }
        }
        if (!empty($request->destinations)) {
            foreach ($request->destinations as $key => $destination) {
                $locations->push([
                    'value' => $destination,
                    'type' => 'destination',
                    'date' => $request->destination_dates[$key]
                ]);
            }
        }

        if (!empty($request->destinations) || !empty($request->destinations)) {
            $track->locations()->delete();
            $track->locations()->createMany($locations->toArray());
        }

        return redirect()->route('tracks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Track $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        $track->locations()->delete();
        $track->delete();
        return redirect()->route('tracks.index');
    }
}
