@extends('layouts.app')

@section('title', 'Edit track')

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <form action="{{ route('tracks.update', ['track' => $track]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <h4>Load information</h4>
                    {{-- code --}}
                    <div class="form-group">
                        <input type="text" name="code" class="form-control form-control-lg" placeholder="code" required
                               value="{{ $track->code }}">
                    </div>
                    {{-- from --}}
                    <div class="form-group">
                        <input type="text" name="from" class="form-control form-control-lg" placeholder="from" required
                               value="{{ $track->from }}">
                    </div>
                    {{-- to --}}
                    <div class="form-group">
                        <input type="text" name="to" class="form-control form-control-lg" placeholder="to" required
                               value="{{ $track->to }}">
                    </div>
                    {{-- dims --}}
                    <div class="form-group">
                        <input type="text" name="dims"
                               class="form-control form-control-lg"
                               placeholder="dims" value="{{ $track->dims }}">
                    </div>
                    {{-- load --}}
                    <div class="form-group">
                        <input type="text" name="load"
                               class="form-control form-control-lg"
                               placeholder="load" value="{{ $track->load }}">
                    </div>
                    <h4>Load status</h4>
                    {{-- at_origin --}}
                    <div class="form-group">
                        <input type="text" name="at_origin" id="at_origin"
                               class="form-control form-control-lg"
                               placeholder="at_origin" value="{{ $track->at_origin }}">
                    </div>
                    {{-- at_origin_date --}}
                    <div class="form-group">
                        <input type="text" name="at_origin_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="at_origin_date" value="{{ $track->at_origin_date }}">
                    </div>
                    {{-- freight_loaded --}}
                    <div class="form-group">
                        <input type="text" name="freight_loaded"
                               class="form-control form-control-lg"
                               placeholder="freight_loaded" value="{{ $track->freight_loaded }}">
                    </div>
                    {{-- freight_loaded_date --}}
                    <div class="form-group">
                        <input type="text" name="freight_loaded_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="freight_loaded_date" value="{{ $track->freight_loaded_date }}">
                    </div>
                    {{-- current_location --}}
                    <div class="form-group">
                        <input type="text" name="current_location" id="current_location"
                               class="form-control form-control-lg"
                               placeholder="current_location" value="{{ $track->current_location }}">
                    </div>
                    {{-- current_location_date --}}
                    <div class="form-group">
                        <input type="text" name="current_location_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="current_location_date" value="{{ $track->current_location_date }}">
                    </div>
                    {{-- at_distination --}}
                    <div class="form-group">
                        <input type="text" name="at_distination"
                               class="form-control form-control-lg"
                               placeholder="at_distination" value="{{ $track->at_distination }}">
                    </div>
                    {{-- at_distination_date --}}
                    <div class="form-group">
                        <input type="text" name="at_distination_date"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="at_distination_date" value="{{ $track->at_distination_date }}">
                    </div>
                    {{-- delivered --}}
                    <div class="form-group">
                        <input type="text" name="delivered"
                               class="form-control form-control-lg js-date-picker"
                               placeholder="delivered" value="{{ $track->delivered }}">
                    </div>
                    <h4>Load summary</h4>
                    {{-- status --}}
                    <div class="form-group">
                        <input type="text" name="status"
                               class="form-control form-control-lg"
                               placeholder="status" value="{{ $track->status }}">
                    </div>
                    {{-- status --}}
                    <div class="form-group">
                        <input type="text" name="pod"
                               class="form-control form-control-lg"
                               placeholder="pod" value="{{ $track->pod }}" required>
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
