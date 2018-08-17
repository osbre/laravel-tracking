@extends('layouts.app')

@section('title', 'Edit track')

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="{{ route('tracks.update', ['track' => $track]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="code" required
                               value="{{ $track->code }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="from" class="form-control form-control-lg" placeholder="from" required
                               value="{{ $track->from }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="to" class="form-control form-control-lg" placeholder="to" required
                               value="{{ $track->to }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="start_time" id="start_time"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="start time" value="{{ $track->start_time }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="end_time" id="end_time"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="end time" value="{{ $track->end_time }}">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-info btn-lg btn-block" value="Edit">
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
