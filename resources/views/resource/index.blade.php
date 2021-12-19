@extends('base')

@section('content')

<div class="modal" id="modalDelete" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Confirm delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="modalDeleteResourceForm" action="" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-primary" value="Delete product"/>
        </form>
      </div>
    </div>
  </div>
</div>

<h1>{{ $enterprise }}</h1>

@isset($message)
    <div class="alert alert-{{ $type ?? 'success' }}" role="alert">
        {{ $message }}
    </div>
@endisset

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
        </tr>
    </thead>
    <tbody>
    @foreach($resources as $resource)
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
                <a href="{{ url('resource/' . $resource['id']) }}">Show</a>
            </td>
            <td>
                <a href="{{ url('resource/' . $resource['id'] . '/edit') }}">Edit</a>
            </td>
            <td>
                <a href="javascript: void(0);" data-url="{{ url('resource/' . $resource['id']) }}" data-bs-toggle="modal" data-bs-target="#modalDelete">Delete</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<a href="{{ url('resource/create') }}" class="btn btn-primary btn-lg" type="button">Add new product</a>

@endsection

@section('js')
    <script src="{{ url('assets/js/delete.js') }}"></script>
@endsection