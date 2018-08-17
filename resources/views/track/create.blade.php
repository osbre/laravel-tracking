@extends('layouts.app')

@section('title', 'Add track')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/picker.min.css') }}">
    <script src="{{ asset('css/picker.min.js') }}"></script>
@endsection

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="{{ route('tracks.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="code" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="from" class="form-control form-control-lg" placeholder="from" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="to" class="form-control form-control-lg" placeholder="to" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="dimansions" id=""
                               class="form-control form-control-lg"
                               placeholder="dimansions">
                    </div>

                    <div class="form-group">
                        <input type="text" name="start_time" id="start_time"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="start time" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="at_origin" id=""
                               class="form-control form-control-lg"
                               placeholder="at_origin">
                    </div>

                    <div class="form-group">
                        <input type="text" name="freight_loaded" id=""
                               class="form-control form-control-lg"
                               placeholder="freight_loaded">
                    </div>

                    <div class="form-group">
                        <input type="text" name="current_location"
                               class="form-control form-control-lg"
                               placeholder="current_location" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="end_time" id="end_time"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="end time" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="delivered" id=""
                               class="form-control form-control-lg"
                               placeholder="delivered">
                    </div>

                    <div class="form-group">
                        <input type="text" name="pod" id=""
                               class="form-control form-control-lg"
                               placeholder="pod">
                    </div>
                    {{-- end additional fields, not required --}}


                    <div class="form-group">
                        <input type="submit" class="btn btn-info btn-lg btn-block" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        new Picker(document.getElementById('start_time'), {
            format: 'YYYY:MM:DD HH:mm:00',
        });
        new Picker(document.getElementById('end_time'), {
            format: 'YYYY:MM:DD HH:mm:00',
        });
    </script>
@endsection
