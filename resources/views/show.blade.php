@extends('layouts.app')

@section('title', 'Tracking')

@section('content')
    <div class="container">
        <div class="row pb-2">
            @if(!empty(env('LOGO_PATH')))
                <div class="col-sm-1">
                    <a href="{{ env('LOGO_LINK') ? env('LOGO_LINK') : '#' }}">
                        <img src="{{ env('LOGO_PATH') }}" alt="logo" style="max-width: 100px;">
                    </a>
                </div>
            @endif
            <div class="col-lg-11">
                <form class="mx-2 my-auto d-inline w-100" method="post" action="{{ route('track') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control border border-right-0" placeholder="Enter tracking #"
                               required
                               name="code" value="{{ $track->code }}">
                        <span class="input-group-append">
                        <button class="btn btn-success border border-left-0" type="submit">
                            CHECK
                        </button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="list-group w-100">
                    <h4>Load information</h4>

                    <div class="list-group-item">
                        Tracking: <b>{{ $track->code }}</b>
                    </div>
                    <div class="list-group-item">
                        From:<br><b>{{ $track->from }}</b>
                    </div>
                    <div class="list-group-item">
                        To:<br><b>{{ $track->to }}</b>
                    </div>
                    @if(!empty($track->load_pc) || !empty($track->load_lbs))
                        <li class="list-group-item">
                            Load:
                            <br><b>{{ $track->load_pc ? $track->load_pc .' pc' : '' }} {{ $track->load_lbs ? $track->load_lbs .' lbs' : '' }}</b>
                        </li>
                    @endif
                    @if(!empty($track->dims))
                        <li class="list-group-item">
                            Dims: <br><b>{{ $track->dims }}</b>
                        </li>
                    @endif


                </div>
            </div>
            <div class="col-lg-4">
                <h4>Load status</h4>
                @if(!empty($track->at_origin))
                    <li class="list-group-item">
                        At origin:
                        <br><b>{{ $track->at_origin }}</b>
                        <br><b>{{ $track->at_origin_date ? $track->at_origin_date->format('m-d-Y H:i') : '' }}</b>
                    </li>
                @endif
                @if($track->locations->where('type', 'freight_loaded')->isNotEmpty())
                    <li class="list-group-item">
                        Freight loaded:
                        @foreach($track->locations->where('type', 'freight_loaded') as $location)
                            <br>
                            <b class="text-info">{{ $location->value }}</b>
                            <br>
                            <b class="text-success">{{ $location->date ? $location->date->format('m-d-Y H:i') : '' }}</b>
                        @endforeach
                    </li>
                @endif
                @if(!empty($track->current_location))
                    <li class="list-group-item">
                        Current location:
                        <br><b>{{ $track->current_location }}</b>
                        <br><b>{{ $track->current_location_date ? $track->current_location_date->format('m-d-Y H:i') : '' }}</b>
                    </li>
                @endif
                @if($track->locations->where('type', 'destination')->isNotEmpty())
                    <li class="list-group-item">
                        At destination:
                        @foreach($track->locations->where('type', 'destination') as $location)
                            <br>
                            <b class="text-info">{{ $location->value }}</b>
                            <br>
                            <b class="text-success">{{ $location->date ? $location->date->format('m-d-Y H:i') : '' }}</b>
                        @endforeach
                    </li>
                @endif

                <li class="list-group-item">
                    Time to arrival:<br>
                    <b>{{ $time_to_arrival['days'].' days '.$time_to_arrival['hours'].' hours '.$time_to_arrival['minutes'].' minutes' }}</b>
                </li>
                <li class="list-group-item">
                    Estimated time to delivery:<br> <b>{{ $estimated_time_to_delivery }}</b>
                </li>

                @if(!empty($track->delivered))
                    <li class="list-group-item">
                        Delivered:
                        <br><b>{{ $track->delivered->format('m-d-Y H:i') }}</b>
                    </li>
                @endif
            </div>
            <div class="col-lg-4">
                <h4>Load summary</h4>

                <li class="list-group-item">
                    Status: <br>
                    <b>
                        @switch($track->status)
                            @case(0)
                            On away a pick up
                            @break
                            @case(1)
                            At pick up
                            @break
                            @case(2)
                            At transit
                            @break
                            @case(3)
                            At delivery
                            @break
                            @case(4)
                            Delivered
                            @break
                        @endswitch
                    </b>
                </li>

                @if(!empty($track->pod))
                    <li class="list-group-item">
                        Pod: <br><b>{{ $track->pod }}</b>
                    </li>
                @endif
            </div>
        </div>
        <div class="row">
            <div id="map" class="col-lg-12" style="width:100%; height:600px;"></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3>Photos</h3>
            </div>
            @foreach($track->photos()->get() as $photo)
                <div class="col-md-4">
                    <div class="card">
                        <a href="{{ Storage::url($photo->filename) }}">
                            <img src="{{ Storage::url($photo->filename) }}" width="100%" class="card-img-top">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&language=en-AU&key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>

    <script>
        var marker = false;
        var fullTime = {{ $duration['value'] }};
        var pathTime = 0;

        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            //center: new google.maps.LatLng(39.31252574424125, -100.65206356448482),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var directionsService = new google.maps.DirectionsService();
        directionsDisplay.setOptions({suppressMarkers: true, suppressInfoWindows: true});
        directionsDisplay.setMap(map);
        var request = {
            origin: new google.maps.LatLng({{ $start['lat'] }}, {{ $start['lng'] }}),
            destination: new google.maps.LatLng({{ $end['lat'] }}, {{ $end['lng'] }}),
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                updateMarker(response.routes[0].legs[0], 0);
                /*setInterval(function () {
                    updateMarker(response.routes[0].legs[0], 5);
                }, 5000);*/
                console.log(response);
            }
        });

        function updateMarker(legs, delta) {
            if (marker) marker.setMap(null);
            var markerIcon = '{{ asset('img/auto.png') }}';
            if (pathTime + delta > 0) pathTime = pathTime + delta;
            else {
                marker = new google.maps.Marker({position: legs.steps[0].lat_lngs[0], map: map});
                marker.setIcon(markerIcon);
                return;
            }
            if (pathTime > fullTime) pathTime = fullTime;
            var points = getDirectionPoints(legs);
            var countPoints = 0;
            for (i = 0; i < points.length; i++) countPoints = countPoints + points[i];
            var curentPoint = parseInt(pathTime * countPoints / fullTime);
            var step = getStep(points, curentPoint);
            marker = new google.maps.Marker({position: legs.steps[step[0]].lat_lngs[step[1] - 1], map: map});
            marker.setIcon(markerIcon);
        }

        function getStep(points, curentPoint) {
            for (var i = 0; i < points.length; i++) {
                curentPoint = curentPoint - points[i];
                if (curentPoint <= 0) return [i, curentPoint + points[i]];
            }
        }

        function getDirectionPoints(data) {
            var points = [];
            for (var i = 0; i < data.steps.length; i++) {
                if (data.steps[i].lat_lngs) {
                    points.push(data.steps[i].lat_lngs.length);
                }
            }
            return points;
        }
    </script>
@endsection