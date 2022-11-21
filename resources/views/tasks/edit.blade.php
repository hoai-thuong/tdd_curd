@extends('layouts.app');
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Edit task</h2>
                <form action="{{route('tasks.update',['id' => $tasks->id])}}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-header">
                            <input type="text" class="form-group" value="{{$tasks->name}}" name="name"
                                   placeholder="Name...">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-group" value="{{$tasks->content}}" name="content"
                                   placeholder="Content..">
                        </div>
                        <button class="btn btn-success">Update</button>

                    </div>
                    {{--                    <button class="btn btn-success">Update</button>--}}
                </form>
            </div>

        </div>
    </div>
@endsection
