@extends('base')

@section('content')

<h1>{{ $enterprise }}</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                {{ $resource['id'] }}
            </td>
            <td>
                {{ $resource['name'] }}
            </td>
            <td>
                {{ $resource['price'] }}
            </td>
            <td>
                <a href="{{ url('resource') }}">Back</a>
            </td>
        </tr>
    </tbody>
</table>

@endsection