@extends('frontend.master')
@section('content')

<section class="content">
    <div class="pull-left">
        <button class="btn btn-success" onclick="window.location='{{url('/index')}}'">
            Add Task
        </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">Task List</h1>
                </div><!-- /.box-header -->
                <div class="box-body">
                        <table class="table table-striped table-bordered datatable" id="example2">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description </th>
                                <th scope="col">Order</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                                @if (isset($tasks))
                                @foreach($tasks as $task)
                                    <tr class="row1" data-id="{{ $task->id }}">
                                        <td style="width: 10px; cursor: move;"><i class="fa fa-arrows-alt text-muted"></i></td>
                                        <td>{{$task->id}}</td>
                                        <td>{{$task->title}}</td>
                                        <td>{{$task->description}}</td>
                                        <td>{{$task->order}}</td>
                                        <td>
                                            <div class="checkbox">
                                                <input type="checkbox" name= "status" data-toggle="toggle" class="toggle-class" data-on="Completed" data-off= "Pending" <?php if($task['status']=='Completed'){echo "checked";}?> data-id="{{$task->id}}" {{ $task->status ? 'unchecked' : '' }} autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-default edit-task">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            {{-- <a href="{{route('show', ['id' => encrypt($task->id)])}}" class="btn btn-default">
                                                <i class="fa fa-edit"></i>
                                            </a> --}}
                                            <a href="javascript:void(0)" data-id="{{encrypt($task->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-default delete-task">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            {{-- <a  href="{{route('delete', ['id' => encrypt($task->id), 'action' => 'delete'])}}"
                                                onclick="return confirm('Are you sure?')" class="btn btn-default">
                                                <i class="fa fa-trash"></i>
                                            </a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- <div class="d-flex justify-content-center">
                            {{  $tasks->links() }}
                        </div> --}}

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
