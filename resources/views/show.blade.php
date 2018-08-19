@extends('layouts.app')

@section('title', 'Tracking')

@section('content')
    <div class="container">
        <div class="row pb-2">
            <form class="mx-2 my-auto d-inline w-100" method="post" action="{{ route('track') }}">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control border border-right-0" placeholder="code" required
                           name="code" value="{{ $track->code }}">
                    <span class="input-group-append">
                        <button class="btn btn-success border border-left-0" type="button">
                            CHECK
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <ul class="list-group w-100">
                    <h4>Load information</h4>

                    <li class="list-group-item">
                        Code: <b>{{ $track->code }}</b>
                    </li>
                    <li class="list-group-item">
                        From:<br><b>{{ $track->from }}</b>
                    </li>
                    <li class="list-group-item">
                        To:<br><b>{{ $track->to }}</b>
                    </li>
                    @if(!empty($track->load))
                        <li class="list-group-item">
                            load: <br><b>{{ $track->load }}</b>
                        </li>
                    @endif
                    @if(!empty($track->dims))
                        <li class="list-group-item">
                            dims: <br><b>{{ $track->dims }}</b>
                        </li>
                    @endif
                    <h4>Load status</h4>
                    @if(!empty($track->at_origin))
                        <li class="list-group-item">
                            at_origin:
                            <br><b>{{ $track->at_origin }}</b>
                            <br><b>{{ $track->at_origin_date->format('m-d-Y H:i') }}</b>
                        </li>
                    @endif
                    @if(!empty($track->freight_loaded))
                        <li class="list-group-item">
                            freight_loaded:
                            <br><b>{{ $track->freight_loaded }}</b>
                            <br><b>{{ $track->freight_loaded_date->format('m-d-Y H:i') }}</b>
                        </li>
                    @endif
                    @if(!empty($track->current_location))
                        <li class="list-group-item">
                            current_location:
                            <br><b>{{ $track->current_location }}</b>
                            <br><b>{{ $track->current_location_date->format('m-d-Y H:i') }}</b>
                        </li>
                    @endif
                    @if(!empty($track->at_distination))
                        <li class="list-group-item">
                            at_distination:
                            <br><b>{{ $track->at_distination }}</b>
                            <br><b>{{ $track->at_distination_date->format('m-d-Y H:i') }}</b>
                        </li>
                    @endif

                    <li class="list-group-item">
                        Time to arrival:<br><b>{{ $duration['text'] }}</b>
                    </li>

                    @if(!empty($track->delivered))
                        <li class="list-group-item">
                            Delivered:
                            <br><b>{{ $track->delivered->format('m-d-Y H:i') }}</b>
                        </li>
                    @endif

                    <h4>Load summary</h4>

                    @if(!empty($track->status))
                        <li class="list-group-item">
                            status: <br><b>{{ $track->status }}</b>
                        </li>
                    @endif

                    @if(!empty($track->pod))
                        <li class="list-group-item">
                            Pod: <br><b>{{ $track->pod }}</b>
                        </li>
                    @endif
                </ul>
            </div>
            <div id="map" class="col-lg-8" style="width:100%; height:600px;"></div>
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