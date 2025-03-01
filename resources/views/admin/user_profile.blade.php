@extends('admin.design')
@section('style')
    {{ Html::style('styles/invite_modal.css') }}
@endsection
@section('code')
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header align_btn">
                    <h2 class="">User Profile</h2>
                    <button type="button" class="btn btn-primary pull-right" id="invite_partner">Add Agent &nbsp;<i
                            class="fa fa-chevron-circle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-6 col-xxl-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Update Profile
                    </div>
                    <div class="panel-body">
                        

                    <form id="update-user-profile">
                        @csrf
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Agent Name</label>
                                <input type="text" class="form-control" id="edit_agent_name" name="edit_agent_name"
                                    placeholder="Agent Name">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Email ID</label>
                                <input type="email" class="form-control" id="edit_agent_email" name="edit_agent_email"
                                    placeholder="Email ID">
                                </select>
                            </div>

                            {{-- <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="edit_password"
                                    placeholder="Password">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Confirm Password</label>
                                <input type="password" class="form-control" id="edit_confirm_password"
                                    name="edit_confirm_password" placeholder="Confirm Password">
                                </select>
                            </div> --}}
                        </div>
                    </form>

                </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-6 col-xxl-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Change Password
                    </div>
                    <div class="panel-body">
                        
                    <form id="change-password">
                        @csrf
                        <div class="row">

                           <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Old Password</label>
                                <input type="Password" class="form-control" id="old_password" name="old_password" placeholder="Old Password">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="New Password">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Confirm Password">
                                </select>
                            </div> 

                            <div class="col-md-12 form-group">
                            <button type="button" class="btn btn-primary pull-right" id="invite_partner">
                            &nbsp; Update &nbsp;</button>
                            </div>

                        </div>
                    </form>


                    </div>
                </div>
            </div>


        </div>
    </div>

    
    

    <div class="modal fade" id="edit_agent_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit Agent</h4>
                </div>
                <div class="modal-body">
                    <form id="update-agent-form">
                        @csrf
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Agent Name</label>
                                <input type="text" class="form-control" id="edit_agent_name" name="edit_agent_name"
                                    placeholder="Agent Name">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Email ID</label>
                                <input type="email" class="form-control" id="edit_agent_email" name="edit_agent_email"
                                    placeholder="Email ID">
                                </select>
                            </div>

                            {{-- <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="edit_password"
                                    placeholder="Password">
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="" class="form-control-label">Confirm Password</label>
                                <input type="password" class="form-control" id="edit_confirm_password"
                                    name="edit_confirm_password" placeholder="Confirm Password">
                                </select>
                            </div> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_agent">Update Agent</button>
                </div>
            </div>
        </div>
    </div>

@section('script')
    {{ Html::script('scripts/invite_modal.js') }}
    <script type="text/javascript">
        $(function() {
            var table = $('.leads-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.agents') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     className: 'text-center'
                    // },
                ]
            });

            $("#invite_partner").on('click', function() {
                $("#create_agent_modal").modal('show')
            })

            $(document).on('click', '.edit_agent', function() {
                $("#edit_agent_modal").modal('show')
                // alert()
                // $("#myModal").modal()
            })
            
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $(document).on('click', '#save_agent', function() {
                $.ajax({
                    url: "{{ route('admin.create-agent') }}",
                    method: 'post',
                    data: $('#create-agent-form').serialize(),
                    success: function(result) {
                        if (result.status == 1) {
                            table.ajax.reload();
                            $("#create_agent_modal").modal('hide')
                            toastr.success("Agent created successfully !!!");
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection
