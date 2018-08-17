@extends('layouts.app')

@section('title', 'Tracking app')

@section('head')
    <style>
        html,
        body {
            height: 100%;
        }

        #cover {
            height: 100%;
            text-align: center;
            display: flex;
            align-items: center;
        }

        #cover-caption {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <section id="cover">
        <div id="cover-caption">
            <div id="container" class="container">
                <div class="row">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <h1 class="display-3">Tracking app</h1>
                        <div class="info-form">
                            <form action="{{ route('track') }}" method="post" class="form-inline justify-content-center">
                                @csrf
                                <label class="sr-only" for="codeInput">Code</label>
                                <input type="text" name="code" class="form-control form-control-lg mb-2 mr-sm-2"
                                       id="codeInput"
                                       placeholder="code">
                                <button type="submit" class="btn btn-lg btn-info mb-2">CHECK</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection