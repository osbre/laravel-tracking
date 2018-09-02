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
                <form action="{{ route('tracks.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="btn-group d-flex" role="group">
                        <a href="{{ route('tracks.index') }}" class="btn btn-warning w-100">Back</a>
                        <button type="submit" class="btn btn-info w-100">Save</button>
                    </div>
                    <h4 class="text-info">Load Information</h4>
                    {{-- code --}}
                    <div class="form-group">
                        <label>Tracking</label>
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="Tracking"
                               required>
                    </div>
                    {{-- from --}}
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from" class="form-control form-control-lg autocomplete"
                               placeholder="From" required>
                    </div>
                    {{-- to --}}
                    <div class="form-group" id="locationField">
                        <label>To</label>
                        <input type="text" name="to" class="form-control form-control-lg autocomplete" placeholder="To"
                               required>
                    </div>
                    {{-- dims --}}
                    <div class="form-group">
                        <label>Dimensions (LxWxH)</label>
                        <input type="text" name="dims"
                               class="form-control form-control-lg"
                               placeholder="Dimensions (LxWxH)">
                    </div>
                    {{-- load --}}
                    <div class="form-group">
                        <label>Load</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="load_pc" placeholder="pc(s)">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="load_lbs" placeholder="lbs">
                            </div>
                        </div>
                    </div>
                    <h4 class="text-info">Load Status</h4>
                    {{-- at_origin --}}
                    <div class="form-group">
                        <label>Origin</label>
                        <input type="text" name="at_origin"
                               class="form-control form-control-lg autocomplete"
                               placeholder="Origin">
                    </div>
                    {{-- at_origin_date --}}
                    <div class="form-group">
                        <label>Origin date</label>
                        <input type="text" name="at_origin_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Origin date">
                    </div>
                    {{-- freight_loaded list--}}
                    <div id="freight_loaded_container">
                        <h3>Freight loaded </h3>
                        <button type="button" class="btn btn-success btn-block" id="add_freight_loaded_btn">Add freight
                            loaded
                        </button>
                        <div class="card card-body">
                            {{-- freight_loaded--}}
                            <div class="form-group">
                                <label>Freight loaded</label>
                                <input type="text" name="freight_loads[]"
                                       class="form-control form-control-lg autocomplete"
                                       placeholder="Freight loaded">
                            </div>
                            {{-- freight_loaded_date --}}
                            <div class="form-group">
                                <label>Freight loaded date</label>
                                <input type="text" name="freight_loaded_dates[]"
                                       class="form-control form-control-lg js-date-picker"
                                       placeholder="Freight loaded date">
                            </div>
                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                        </div>
                    </div>
                    {{-- current_location --}}
                    <div class="form-group">
                        <label>Current location</label>
                        <input type="text" name="current_location"
                               class="form-control form-control-lg autocomplete"
                               placeholder="Current location">
                    </div>
                    {{-- current_location_date --}}
                    <div class="form-group">
                        <label>Current location date</label>
                        <input type="text" name="current_location_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Current location date">
                    </div>
                    {{-- destinations list--}}
                    <div id="destination_container">
                        <h3>Destinations</h3>
                        <button type="button" class="btn btn-success btn-block" id="add_destination_btn">
                            Add Destination
                        </button>
                        <div class="card card-body">
                            {{-- destination--}}
                            <div class="form-group">
                                <label>Destination</label>
                                <input type="text" name="destinations[]"
                                       class="form-control form-control-lg autocomplete"
                                       placeholder="Destination">
                            </div>
                            {{-- destination_date --}}
                            <div class="form-group">
                                <label>Destination date</label>
                                <input type="text" name="destination_dates[]"
                                       class="form-control form-control-lg js-date-picker"
                                       placeholder="Destination date">
                            </div>
                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                        </div>
                    </div>
                    {{-- delivered --}}
                    <div class="form-group">
                        <label>Delivered</label>
                        <input type="text" name="delivered"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="Delivered">
                    </div>
                    <h4 class="text-info">Load Summary</h4>
                    {{-- status --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control form-control-lg">
                            <option value="0" selected>On away a pick up</option>
                            <option value="1">At pick up</option>
                            <option value="2">At transit</option>
                            <option value="3">At delivery</option>
                            <option value="4">Delivered</option>
                        </select>
                    </div>
                    {{-- status --}}
                    <div class="form-group">
                        <label>Signed by</label>
                        <input type="text" name="pod"
                               class="form-control form-control-lg"
                               placeholder="Signed by">
                    </div>
                    <h4 class="text-info">Photos</h4>
                    <div class="alert alert-info" role="alert">
                        <b>Note:</b> File size is no more than 1 MB.
                    </div>
                    <div id="photos_container">
                        <button type="button" class="btn btn-success btn-block" id="add_photo_btn">Add photo</button>
                        <div class="card card-body">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photos[]">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger delete_btn">DELETE</button>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <input type="submit" class="btn btn-info btn-lg btn-block" value="Add">
                    </div>
                </form>
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
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=en&callback=initAutocomplete"
            async defer></script>
@endsection
