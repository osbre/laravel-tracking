@extends('layouts.app')

@section('title', 'Add track')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.css"
          integrity="sha256-TV6wP5ef/UY4bNFdA1h2i8ASc9HHcnl8ufwk94/HP4M=" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.1/flatpickr.min.js"
            integrity="sha256-xYW0mVKSgKFu1yJ15BrY8JesOJIMcGv9tLU6PZJ1W7Q=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="{{ route('tracks.store') }}" method="post">
                    @csrf
                    <h4>Load information</h4>
                    {{-- code --}}
                    <div class="form-group">
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="code" required>
                    </div>
                    {{-- from --}}
                    <div class="form-group">
                        <input type="text" name="from" class="form-control form-control-lg" placeholder="from" required
                               id="from">
                    </div>
                    {{-- to --}}
                    <div class="form-group" id="locationField">
                        <input type="text" name="to" class="form-control form-control-lg" placeholder="to" required
                               id="to">
                    </div>
                    {{-- dims --}}
                    <div class="form-group">
                        <input type="text" name="dims"
                               class="form-control form-control-lg"
                               placeholder="dims">
                    </div>
                    {{-- load --}}
                    <div class="form-group">
                        <input type="text" name="load"
                               class="form-control form-control-lg"
                               placeholder="load">
                    </div>
                    <h4>Load status</h4>
                    {{-- at_origin --}}
                    <div class="form-group">
                        <input type="text" name="at_origin" id="at_origin"
                               class="form-control form-control-lg"
                               placeholder="at_origin" id="at_origin">
                    </div>
                    {{-- at_origin_date --}}
                    <div class="form-group">
                        <input type="text" name="at_origin_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="at_origin_date">
                    </div>
                    {{-- freight_loaded --}}
                    <div class="form-group">
                        <input type="text" name="freight_loaded"
                               class="form-control form-control-lg"
                               placeholder="freight_loaded" id="freight_loaded">
                    </div>
                    {{-- freight_loaded_date --}}
                    <div class="form-group">
                        <input type="text" name="freight_loaded_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="freight_loaded_date">
                    </div>
                    {{-- current_location --}}
                    <div class="form-group">
                        <input type="text" name="current_location" id="current_location"
                               class="form-control form-control-lg"
                               placeholder="current_location" id="current_location">
                    </div>
                    {{-- current_location_date --}}
                    <div class="form-group">
                        <input type="text" name="current_location_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="current_location_date">
                    </div>
                    {{-- at_distination --}}
                    <div class="form-group">
                        <input type="text" name="at_distination"
                               class="form-control form-control-lg"
                               placeholder="at_distination" id="at_distination">
                    </div>
                    {{-- at_distination_date --}}
                    <div class="form-group">
                        <input type="text" name="at_distination_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="at_distination_date">
                    </div>
                    {{-- delivered --}}
                    <div class="form-group">
                        <input type="text" name="delivered"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="delivered">
                    </div>
                    <h4>Load summary</h4>
                    {{-- status --}}
                    <div class="form-group">
                        <input type="text" name="status"
                               class="form-control form-control-lg"
                               placeholder="status">
                    </div>
                    {{-- status --}}
                    <div class="form-group">
                        <input type="text" name="pod"
                               class="form-control form-control-lg"
                               placeholder="pod">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-info btn-lg btn-block" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        /*new Picker(document.getElementById('start_time'), {
            format: 'YYYY:MM:DD HH:mm:00',
        });
        new Picker(document.getElementById('end_time'), {
            format: 'YYYY:MM:DD HH:mm:00',
        });*/
    </script>

    <script>
        flatpickr(".js-date-picker", {
            enableTime: true,
            dateFormat: "m-d-Y H:i",
        });

        function initAutocomplete() {
            var options = {
                types: ['(cities)'],
                componentRestrictions: {country: "us"}
            };

            new google.maps.places.Autocomplete(
                (document.getElementById('from')),
                options);
            new google.maps.places.Autocomplete(
                (document.getElementById('to')),
                options);
            new google.maps.places.Autocomplete(
                (document.getElementById('at_origin')),
                options);
            new google.maps.places.Autocomplete(
                (document.getElementById('freight_loaded')),
                options);
            new google.maps.places.Autocomplete(
                (document.getElementById('current_location')),
                options);
            new google.maps.places.Autocomplete(
                (document.getElementById('at_distination')),
                options);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=en&callback=initAutocomplete"
            async defer></script>
@endsection
