@extends('admin.design')
@section('style')
{{ Html::style('styles/invite_modal.css') }}
@endsection
@section('code')
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header align_btn">
                <h2 class="">Product/Services</h2>
                <button type="button" class="btn btn-primary pull-right" id="new-ps"><i class="fa fa-paper-plane"></i> New Product/Service</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Product/Services Table
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover leads-table" id="dataTables-example" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Plan Name</th>
                                    <th>Type</th>
                                    <th>Users</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-ps-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Product/Service</h4>
            </div>
            <div class="modal-body">
            <form id="edit-ps-form">
                @csrf
               <div class="row">
                <div class="col-md-12 form-group">
                    <label for="recipient-name" class="form-control-label">Plan Type</label>
                    <select class="form-control" id="edit_plan_type" name="edit_plan_type" >
                        <option value=1>Product</option>
                        <option value=2>Service</option>
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Plan</label>
                    <input type="text" class="form-control" id="edit_plan_name" name="edit_plan_name" placeholder="Plan Name">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Users</label>
                    <input type="number" class="form-control" id="edit_users" name="edit_users" placeholder="Users">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Month</label>
                    <input type="number" class="form-control"  id="edit_month" name="edit_month" placeholder="Month">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Pricing</label>
                    <input type="number" class="form-control" id="edit_pricing" name="edit_pricing" placeholder="Pricing">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="recipient-name" class="form-control-label">Plan Status</label>
                    <select class="form-control" id="edit_plan_status" name="edit_plan_status" >
                        <option value=1>Active</option>
                        <option value=0>Inactive</option>
                    </select>
                </div>
               </div>
               <input type="hidden" id="ps_id" value="" name="ps_id">
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-ps">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create-ps-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Product/Service</h4>
            </div>
            <div class="modal-body">
            <form id="create-ps-form">
                @csrf
               <div class="row">
                <div class="col-md-12 form-group">
                    <label for="recipient-name" class="form-control-label">Plan Type</label>
                    <select class="form-control" id="plan_type" name="plan_type" >
                        <option value=1>Product</option>
                        <option value=2>Service</option>
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Plan</label>
                    <input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="Plan Name">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Users</label>
                    <input type="number" class="form-control" id="users" name="users" placeholder="Users">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Month</label>
                    <input type="number" class="form-control"  id="month" name="month" placeholder="Month">
                    </select>
                </div>
                <div class="col-md-12 form-group">
                    <label for="" class="form-control-label">Pricing</label>
                    <input type="number" class="form-control" id="pricing" name="pricing" placeholder="Pricing">
                    </select>
                </div>
               </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-ps">Save</button>
            </div>
        </div>
    </div>
</div>
@section('script')
{{ Html::script('scripts/invite_modal.js') }}
<script type="text/javascript">
    $(function () {
        var table = $('.leads-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.list-product-services') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'plan_type', name: 'plan_type'},
            {data: 'users', name: 'users'},
            {data: 'pricing', name: 'pricing'},
            {data: 'plan_status', name: 'plan_status'},
            {data: 'action', name: 'action'},
            ]
        });

    $(document).on('click','.edit_product_service',function()
    {
        $.ajax({
            url: "{{ route('admin.get-product-service-details') }}",
            method: 'get',
            data: {'id':$(this).data('id')},
            success: function(result)
            {   
                plan = result.data
                $("#edit_plan_status").val(plan.status)
                $("#edit_plan_type").val(plan.type)
                $("#edit_plan_name").val(plan.plan_name)
                $("#edit_users").val(plan.users)
                $("#edit_month").val(plan.month)
                $("#edit_pricing").val(plan.pricing)
                $("#ps_id").val(plan.id)
                $("#edit-ps-modal").modal('show')
            }
        });
    });
    
    $(document).on('click','#update-ps',function()
    {
        $.ajax({
                url: "{{ route('admin.update-product-service-details') }}",
                method: 'post',
                data: $('#edit-ps-form').serialize(),
                success: function(result){
                    if(result.status == 1)
                    {
                        table.ajax.reload();    
                        $("#edit-ps-modal").modal('hide')
                        toastr.success(result.msg);
                    }
                }
                });
     });


     $(document).on('click','#new-ps',function()
     {
        $("#create-ps-modal").modal()
     });

     $(document).on('click','#save-ps',function()
     {
        $.ajax({
                url: "{{ route('admin.create-product-service-details') }}",
                method: 'post',
                data: $('#create-ps-form').serialize(),
                success: function(result){
                    if(result.status == 1)
                    {
                        table.ajax.reload();    
                        $("#create-ps-modal").modal('hide')
                        toastr.success(result.msg);
                    }
                }
                });
      });

    });
</script>
@endsection
@endsection