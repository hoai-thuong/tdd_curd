@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Content</th>
                </tr>
                @foreach($tasks as $task)
                    <tr>
                        <th>{{$task->id}}</th>
                        <th>{{$task->name}}</th>
                        <th>{{$task->content}}</th>
                        <th>
                            <form method="POST" action="{{route('tasks.destroy',['id'=>$task->id])}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">DELETE</button>
                                <a href="{{route('tasks.edit',['id'=>$task->id])}}" class="btn btn-warning">
                                    Edit
                                </a>
                            </form>

                        </th>
                    </tr>

                @endforeach

            </table>
            <div>{{$tasks->links()}}</div>

        </div>

    </div>
@endsection
