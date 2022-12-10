@extends('frontend.master')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h1 class="box-title">My Tasks</h1>
                </div><!-- /.box-header -->
                <div class="box-body">
                        <table class="table table-striped table-bordered" id="example2">
                        <thead  style="background-color: #222d32; color:aliceblue;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description </th>
                                <th scope="col">Order</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody id="myownTasks">

                            </tbody>
                        </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
