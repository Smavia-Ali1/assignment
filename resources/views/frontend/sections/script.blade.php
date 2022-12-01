<script src="{{asset('/')}}frontend/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{asset('/')}}frontend/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="{{asset('/')}}frontend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{asset('/')}}frontend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="{{asset('/')}}frontend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{asset('/')}}frontend/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('/')}}frontend/dist/js/adminlte.min.js"></script>
<script src="{{asset('/')}}frontend/dist/js/demo.js"></script>
<!-- DataTables -->
<script src="{{asset('/')}}frontend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}frontend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="EditTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Edit Task</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="edit_task" onsubmit="return validateUpdateform(this.id)" id="update_form" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="lg:py-8 lg:px-20 flex-1 space-y-4 p-6">
                    <input type="text" name="id" id="edit_id" hidden>
                    <label class="label125">Title</label>
                    <div class="form-group">
                        <input class="form-control required" id="edit_title"  name="title" type="text"
                            autocomplete="off" required>
                    </div>
                    <label class="label125">Description</label>
                    <div class="form-group">
                        <textarea class="form-control" id="edit_description"  name="description" type="text"
                                ></textarea>
                    </div>
                    <input type="text" name="order" id="edit_order" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
        </form>
      </div>
    </div>
  </div>
<script>
    function validateCreateform(formid) {
            var isValid = true;
            var form = $("form#" + formid);
            form.find('input.required').each(function() {
                if ($(this).val() === null || $(this).val() === "") {
                    $(this).addClass('invalid');
                    isValid = false;
                }
            });
            $('form input.required').on('focus', function() {
                $(this).removeClass('invalid');
            });
            if (!(isValid)) {
                return false;
            } else {
                return true;
            }
            return isValid;
        }

        function validateUpdateform(formid) {
            var isValid = true;
            var form = $("form#" + formid);
            form.find('input.required').each(function() {
                if ($(this).val() === null || $(this).val() === "") {
                    $(this).addClass('invalid');
                    isValid = false;
                }
            });
            $('form input.required').on('focus', function() {
                $(this).removeClass('invalid');
            });
            if (!(isValid)) {
                return false;
            } else {
                return true;
            }
            return isValid;
        }
        $('#create_form').on('submit',function(e){
            e.preventDefault();

            let title = $('#title').val();
            let description = $('#description').val();
            $.ajaxSetup({
                    headers: {"Authorization": localStorage.getItem('token')}
            });
            $.ajax({
              url: "/api/create/task",
              type:"POST",
              data:{
                "_token": "{{ csrf_token() }}",
                // headers: {"Authorization": 'Bearer' + localStorage.getItem('token')},
                title:title,
                description:description,
              },
              success:function(response){

                    toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                    location.href = '/home',
                    toastr.success(response['message']);
              },
              error: function(response) {
                toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                toastr.error(response['message']);
              },
              });
            });

            $(document).ready(function(){
                $('.edit-task').on('click', function () {
                    $('#EditTaskModal').modal('show');

                    $tr = $(this).closest('tr');
                    var data = $tr.children("td").map(function(){
                        return $(this).text();
                    }).get();
                    console.log(data);

                    $('#edit_id').val(data[1]);
                    $('#edit_title').val(data[2]);
                    $('#edit_description').val(data[3]);
                    $('#edit_order').val(data[4]);
                });
                $('.edit_task').on('submit', function(e){
                    var id = $('#edit_id').val();
                    $.ajaxSetup({
                        headers: {"Authorization": localStorage.getItem('token')}
                    });
                    $.ajax({
                        url: "/api/update/task/"+ id,
                        type:"PUT",
                        data: $('.edit_task').serialize(),
                        success:function(response){
                            toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                    toastr.info(response['message']);
                        }
                });
            });
            });


            $('.delete-task').on('click', function () {
            var id =   $(this).attr('data-id');
            var URL = "{{url('/api/delete/task')}}/" + id;
            $.ajaxSetup({
                    headers: {"Authorization": localStorage.getItem('token')}
            });
            $.ajax({
                type: 'get',
                url: URL,
                success: function (response) {
                    toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                    location.reload(), toastr.warning(response['message']);
                },
                error: function(response) {
                toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                toastr.error(response['message']);
              },
            })
        });
            $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'Completed' : 'Pending';
        var id = $(this).data('id');
        $.ajaxSetup({
                    headers: {"Authorization": localStorage.getItem('token')}
            });
        $.ajax({
                type: "GET",
                dataType: "JSON",
                url: '/api/task/status',
                data: {'status' : status, 'id': id},
                success:function(data){
                    console.log(data.success)
                }
            });
    });



    $(function () {
      $('.datatable').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    });

    $(function () {
        $( "#sortable" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function(e) {
              updateTaskOrder();
          }
        });
        function updateTaskOrder() {
        let order = {};
        let token = $('meta[name="csrf-token"]').attr('content');
        let URL = '{{ url('/api/update/order') }}';
        $('tr.row1').each(function() {
            order[$(this).data('id')] = $(this).index();
        });
        $.ajax({
        url: URL,
        type: 'POST',
        data: {order: order},
        success: function(response){
            toastr.options = {
                        "closeButton":false,
                        "debug":false,
                        "newestOnTop":false,
                        "progressBar":true,
                        "positionClass":"toast-top-right",
                        "preventDuplicates":true,
                        "onclick":null,
                        "showDuration":"300",
                        "hideDuration":"1000",
                        "timeOut":"120000",
                        "extendedTimeOut":"1000",
                        "showEasing":"swing",
                        "hideEasing":"linear",
                        "showMethod":"fadeIn",
                        "hideMethod":"fadeOut"
                    }
                    toastr.info(response['message']);
            location.reload();
        }
    })
        }
      });



  </script>
