<?php

namespace App\Http\Controllers;

use App\Track;
use Carbon\Carbon;
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
     * @param \Illuminate\Http\Request $request
     *
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
                    'type'  => 'freight_loaded',
                    'date'  => $request->freight_loaded_dates[$key],
                ]);
            }
        }

        foreach ($request->destinations as $key => $destination) {
            if (!empty($destination)) {
                $locations->push([
                    'value' => $destination,
                    'type'  => 'destination',
                    'date'  => $request->destination_dates[$key],
                ]);
            }
        }

        if ($locations->isNotEmpty()) {
            $track->locations()->createMany($locations->toArray());
        }

        $track->insertPhotos($request);

        return redirect()->route('tracks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $track = Track::where('code', $request->code)->firstOrFail();

        $api = Track::calcDirections($track->from_value, $track->to);

        $start['lat'] = $api->routes[0]->legs[0]->start_location->lat;
        $start['lng'] = $api->routes[0]->legs[0]->start_location->lng;

        $end['lat'] = $api->routes[0]->legs[0]->end_location->lat;
        $end['lng'] = $api->routes[0]->legs[0]->end_location->lng;

        $distance['text'] = (float) str_replace(',', '', $api->routes[0]->legs[0]->distance->text);
        $duration['text'] = $api->routes[0]->legs[0]->duration->text;
        $duration['value'] = $api->routes[0]->legs[0]->duration->value;

        $minutes = $distance['text'] / 45 * 60;
        $time_to_arrival = Track::convertToHoursMins($minutes);
        $estimated_time_to_delivery = Carbon::now()
            ->addDay($time_to_arrival['days'])
            ->addHour($time_to_arrival['hours'])
            ->addMinute($time_to_arrival['minutes'])
            ->format('m-d-Y H:i');

        return view('show', ['track' => $track, 'start' => $start, 'end' => $end, 'time_to_arrival' => $time_to_arrival, 'estimated_time_to_delivery' => $estimated_time_to_delivery, 'distance' => $distance, 'duration' => $duration]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Track $track
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
        $api = Track::calcDirections($track->from_value, $track->to);

        $start['lat'] = $api->routes[0]->legs[0]->start_location->lat;
        $start['lng'] = $api->routes[0]->legs[0]->start_location->lng;

        $end['lat'] = $api->routes[0]->legs[0]->end_location->lat;
        $end['lng'] = $api->routes[0]->legs[0]->end_location->lng;

        $duration['value'] = $api->routes[0]->legs[0]->duration->value;

        return view('track.edit', ['track' => $track, 'start' => $start, 'end' => $end, 'duration' => $duration]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Track               $track
     *
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
                    'type'  => 'freight_loaded',
                    'date'  => $request->freight_loaded_dates[$key],
                ]);
            }
        }
        if (!empty($request->destinations)) {
            foreach ($request->destinations as $key => $destination) {
                $locations->push([
                    'value' => $destination,
                    'type'  => 'destination',
                    'date'  => $request->destination_dates[$key],
                ]);
            }
        }

        $track->locations()->delete();
        if (!empty($request->freight_loads) || !empty($request->destinations)) {
            $track->locations()->createMany($locations->toArray());
        }

        //deleting photos
        $photos = $track->photos()->pluck('id')->toArray();
        $exits_photos = $request->exits_photos_ids;

        if (!empty($request->exits_photos_ids)) {
            if (count($exits_photos) != count($photos)) {//if some photos deleted
                $track->photos()->whereNotIn('id', $exits_photos)->delete();
            }
        } else {//if all photos deleted
            $track->photos()->delete();
        }
        //adding photos
        $track->insertPhotos($request);

        return redirect()->route('tracks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Track $track
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        $track->locations()->delete();
        $track->photos()->delete();
        $track->delete();

        return redirect()->route('tracks.index');
    }
}
