@extends('layouts.app')

@section('title', 'Edit track')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.css"
          integrity="sha256-TV6wP5ef/UY4bNFdA1h2i8ASc9HHcnl8ufwk94/HP4M=" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.js"
            integrity="sha256-xYW0mVKSgKFu1yJ15BrY8JesOJIMcGv9tLU6PZJ1W7Q=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="{{ route('tracks.update', ['track' => $track]) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="btn-group d-flex" role="group">
                        <a href="{{ route('tracks.index') }}" class="btn btn-warning w-100">Back</a>
                        <button type="submit" class="btn btn-info w-100">Save</button>
                    </div>
                    <div class="btn-group btn-group-justified">
                    </div>
                    <h4 class="text-info">Load Information</h4>
                    {{-- code --}}
                    <div class="form-group">
                        <label for="">Tracking</label>
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="Tracking"
                               required value="{{ $track->code }}">
                    </div>
                    {{-- from --}}
                    <div class="form-group">
                        <label for="">From</label>
                        <input type="text" name="from" class="form-control form-control-lg autocomplete"
                               placeholder="From" required
                               id="from" value="{{ $track->from }}">
                    </div>
                    {{-- to --}}
                    <div class="form-group" id="locationField">
                        <label for="">To</label>
                        <input type="text" name="to" class="form-control form-control-lg autocomplete" placeholder="To"
                               required
                               id="to" value="{{ $track->to }}">
                    </div>
                    {{-- dims --}}
                    <div class="form-group">
                        <label for="">Dimensions (LxWxH)</label>
                        <input type="text" name="dims"
                               class="form-control form-control-lg"
                               placeholder="Dimensions (LxWxH)" value="{{ $track->dims }}">
                    </div>
                    {{-- load --}}
                    <div class="form-group">
                        <label for="">Load</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="load_pc" placeholder="pc(s)"
                                       value="{{ $track->load_pc }}">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="load_lbs" placeholder="lbs"
                                       value="{{ $track->load_lbs }}">
                            </div>
                        </div>
                    </div>
                    <h4 class="text-info">Load Status</h4>
                    {{-- at_origin --}}
                    <div class="form-group">
                        <label for="">Origin</label>
                        <input type="text" name="at_origin"
                               class="form-control form-control-lg autocomplete"
                               placeholder="Origin" value="{{ $track->at_origin }}">
                    </div>
                    {{-- at_origin_date --}}
                    <div class="form-group">
                        <label for="">Origin date</label>
                        <input type="text" name="at_origin_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Origin date"
                               value="{{ $track->at_origin_date ? $track->at_origin_date->format('m-d-Y H:i') : '' }}">
                    </div>
                    {{-- freight_loaded list--}}
                    <div id="freight_loaded_container">
                        <h3>Freight loaded </h3>
                        <button type="button" class="btn btn-success btn-block" id="add_freight_loaded_btn">Add freight
                            loaded
                        </button>
                        @foreach($track->locations->where('type', 'freight_loaded') as $location)
                            <div class="card card-body">
                                {{-- freight_loaded--}}
                                <div class="form-group">
                                    <label>Freight loaded</label>
                                    <input type="text" name="freight_loads[]"
                                           class="form-control form-control-lg autocomplete"
                                           placeholder="Freight loaded" value="{{ $location->value }}">
                                </div>
                                {{-- freight_loaded_date --}}
                                <div class="form-group">
                                    <label>Freight loaded date</label>
                                    <input type="text" name="freight_loaded_dates[]"
                                           class="form-control form-control-lg js-date-picker"
                                           placeholder="Freight loaded date"
                                           value="{{ $location->date ? $location->date->format('m-d-Y H:i') : '' }}">
                                </div>
                                <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                            </div>
                        @endforeach
                    </div>
                    {{-- current_location --}}
                    <div class="form-group">
                        <label for="">Current location</label>
                        <input type="text" name="current_location"
                               class="form-control form-control-lg autocomplete"
                               placeholder="Current location" value="{{ $track->current_location }}">
                    </div>
                    {{-- current_location_date --}}
                    <div class="form-group">
                        <label for="">Current location date</label>
                        <input type="text" name="current_location_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Current location date"
                               value="{{ $track->current_location_date ? $track->current_location_date->format('m-d-Y H:i') : '' }}">
                    </div>
                    {{-- destinations list--}}
                    <div id="destination_container">
                        <h3>Destinations</h3>
                        <button type="button" class="btn btn-success btn-block" id="add_destination_btn">
                            Add Destination
                        </button>
                        @foreach($track->locations->where('type', 'destination') as $location)
                            <div class="card card-body">
                                {{-- destination--}}
                                <div class="form-group">
                                    <label>Destination</label>
                                    <input type="text" name="destinations[]"
                                           class="form-control form-control-lg autocomplete"
                                           placeholder="Destination" value="{{ $location->value }}">
                                </div>
                                {{-- destination_date --}}
                                <div class="form-group">
                                    <label>Destination date</label>
                                    <input type="text" name="destination_dates[]"
                                           class="form-control form-control-lg js-date-picker"
                                           placeholder="Destination date"
                                           value="{{ $location->date ? $location->date->format('m-d-Y H:i') : '' }}">
                                </div>
                                <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                            </div>
                        @endforeach
                    </div>
                    {{-- delivered --}}
                    <div class="form-group">
                        <label for="">Delivered</label>
                        <input type="text" name="delivered"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Delivered" value="{{ $track->delivered }}">
                    </div>
                    <h4 class="text-info">Load Summary</h4>
                    {{-- status --}}
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" class="form-control form-control-lg">
                            <option value="0" {{ $track->status == 0 ? 'selected' : '' }}>On away a pick up</option>
                            <option value="1" {{ $track->status == 1 ? 'selected' : '' }}>At pick up</option>
                            <option value="2" {{ $track->status == 2 ? 'selected' : '' }}>At transit</option>
                            <option value="3" {{ $track->status == 3 ? 'selected' : '' }}>At delivery</option>
                            <option value="4" {{ $track->status == 4 ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>
                    {{-- status --}}
                    <div class="form-group">
                        <label for="">Signed by</label>
                        <input type="text" name="pod"
                               class="form-control form-control-lg"
                               placeholder="Signed by" value="{{ $track->pod }}">
                    </div>

                    <h4 class="text-info">Photos</h4>
                    <div class="alert alert-info" role="alert">
                        <b>Note:</b> File size is no more than 1 MB.
                    </div>
                    <div id="photos_container">
                        <button type="button" class="btn btn-success btn-block" id="add_photo_btn">Add photo</button>
                        @foreach($track->photos()->get() as $photo)
                            <div class="card card-body">
                                <img src="{{ Storage::url($photo->filename) }}" width="100%">
                                <input type="hidden" name="exits_photos_ids[]" value="{{ $photo->id }}">
                                <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group pt-3">
                        <input type="submit" class="btn btn-info btn-lg btn-block" value="Edit">
                    </div>
                </form>
            </div>
            <div class="col-md-6" id="map" style="width:100%; height:1500px;">

            </div>
        </div>
    </div>


    <script src="{{ asset('js/zepto.min.js') }}"></script>
    <script>
        initDatePicker(".js-date-picker");

        $('button#add_freight_loaded_btn').on('click', function () {
            $('div#freight_loaded_container').append(
                '                        <div class="card card-body">\n' +
                '                            <div class="form-group">\n' +
                '                                <label>Freight loaded</label>\n' +
                '                                <input type="text" name="freight_loads[]"\n' +
                '                                       class="form-control form-control-lg autocomplete"\n' +
                '                                       placeholder="Freight loaded">\n' +
                '                            </div>\n' +
                '                            <div class="form-group">\n' +
                '                                <label>Freight loaded date</label>\n' +
                '                                <input type="text" name="freight_loaded_dates[]"\n' +
                '                                       class="form-control form-control-lg js-date-picker2"\n' +
                '                                       placeholder="Freight loaded date">\n' +
                '                            </div>\n' +
                '                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>\n' +
                '                        </div>');
            initAutocomplete();
            initDatePicker(".js-date-picker2");
        });

        $('button#add_destination_btn').on('click', function () {
            $('div#destination_container').append(
                '                        <div class="card card-body">\n' +
                '                            <div class="form-group">\n' +
                '                                <label>Destination</label>\n' +
                '                                <input type="text" name="destinations[]"\n' +
                '                                       class="form-control form-control-lg autocomplete"\n' +
                '                                       placeholder="Destination">\n' +
                '                            </div>\n' +
                '                            <div class="form-group">\n' +
                '                                <label>Destination date</label>\n' +
                '                                <input type="text" name="destination_dates[]"\n' +
                '                                       class="form-control form-control-lg js-date-picker2"\n' +
                '                                       placeholder="Destination date">\n' +
                '                            </div>\n' +
                '                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>\n' +
                '                        </div>');
            initAutocomplete();
            initDatePicker(".js-date-picker2");
        });

        $('button#add_photo_btn').on('click', function () {
            $('div#photos_container').append(
                '                        <div class="card card-body">\n' +
                '                            <div class="input-group">\n' +
                '                                <div class="custom-file">\n' +
                '                                    <input type="file" class="custom-file-input" name="photos[]">\n' +
                '                                    <label class="custom-file-label">Choose file</label>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>\n' +
                '                        </div>');
        });

        $(document).on('click', 'button.delete_btn', function () {
            $(this).parent().remove();
        });


        function initAutocomplete() {
            var options = {
                types: ['geocode'],
                componentRestrictions: {country: "us"}
            };

            var input = document.getElementsByClassName('autocomplete');

            for (i = 0; i < input.length; i++) {
                autocomplete = new google.maps.places.Autocomplete(input[i], options);
            }

            initMap();
        }

        function initDatePicker(element) {
            var date = new Date();
            flatpickr(element, {
                enableTime: true,
                dateFormat: "m-d-Y H:i",
                defaultHour: date.getHours(),
                defaultMinute: date.getMinutes(),
            });
        }

        function initMap() {
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
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=en&callback=initAutocomplete"
            async defer></script>
@endsection
