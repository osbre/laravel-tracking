@extends('layouts.app')

@section('title', 'Tracks')

@section('head')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row pb-2">
            <a href="{{ route('tracks.create') }}" class="btn btn-info btn-lg btn-block">Create</a>
        </div>
        <div class="row">
            {{ $tracks->links() }}
            <table class="table table-bordered table-responsive-lg table-striped">
                <thead>
                <th>code</th>
                <th>from</th>
                <th>to</th>
                <th>start date</th>
                <th>end date</th>
                </thead>
                <tbody>
                @foreach($tracks as $track)
                    <tr>
                        <td>{{ $track->code }}</td>
                        <td>{{ $track->from }}</td>
                        <td>{{ $track->to }}</td>
                        <td>{{ $track->start_time }}</td>
                        <td>{{ $track->end_time }}</td>
                        <td>
                            <div class='btn-group'>
                                <a href="{{route('tracks.edit',$track->id)}}" class='btn btn-secondary btn-sm'>
                                    <i class="material-icons">mode_edit</i>
                                </a>
                                <a href="" class='btn btn-danger btn-sm'
                                   onclick="event.preventDefault(); document.getElementById('destroy_form{{$loop->iteration}}').submit();">
                                    <i class="material-icons">delete</i>
                                </a>
                                <form action="{{route('tracks.destroy',$track->id)}}" method="post"
                                      id='destroy_form{{$loop->iteration}}'>
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tracks->links() }}
        </div>
    </div>
@endsection
