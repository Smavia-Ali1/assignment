@extends('frontend.master')
@section('content')

<section class="content">
    <div class="pull-left" style="margin-bottom:3px;">
        <button class="btn btn-success" onclick="window.location='{{url('/home')}}'">
            View Task
        </button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-fw fa-tasks"></i>
                    <h3 class="box-title" style="padding: 10px;">ADD TASK</h3>
                </div>
                <div class="box-body">
                    <form class="form-group" method="POST" id="create_form" onsubmit="return validateCreateform(this.id)"  enctype="multipart/form-data">
                        @csrf
                        <input type="text" id="createApi" hidden>
                        <div><label>
                                Title:
                            </label></div>
                        <div>
                            <input type="text" name="title" id="title" class="form-control required">
                        </div>
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div><label>
                                Description:
                            </label></div>
                        <div>
                            <textarea class="form-control" id="description"  name="description" type="text"
                                            value=""></textarea>
                        </div>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <br>
                        <div class="pull-right">
                            <button type="submit" value="Submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
