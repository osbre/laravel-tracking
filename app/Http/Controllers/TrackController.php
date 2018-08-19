<?php

namespace App\Http\Controllers;

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
        Track::create($request->all());


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
        $track = Track::where('code', $request->code)->first();

        if (empty($track)) {
            abort(404);
        }

        if (!empty($track->at_distination)) {
            $from = $track->at_distination;
        } elseif (!empty($track->current_location)) {
            $from = $track->current_location;
        } elseif (!empty($track->freight_loaded)) {
            $from = $track->freight_loaded;
        } elseif (!empty($track->at_origin)) {
            $from = $track->at_origin;
        } elseif (!empty($track->from)) {
            $from = $track->from;
        }

        $url = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=" . $from . "&destination=" . $track->to."&key=".env('GOOGLE_MAPS_API_KEY'));

        $api = json_decode($url);

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
        $track->delete();
        return redirect()->route('tracks.index');
    }
}
