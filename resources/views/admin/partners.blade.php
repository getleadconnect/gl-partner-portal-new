@extends('admin.master')
@section('content')
<style>

.partner-active { color:green;}
.partner-inactive{ color:red;}
.form-select option{ color:black;}

.dataTables_wrapper .dataTables_filter {
    float: right;    text-align: right;   display: flex !important;
}

#err-msg {color:red;	font-size:12px; }
.filter-select{	width:110px;	height:34px;	margin:8px 0px 8px 8px;	border-color:#aaa !important;
}
.pr-detail{position:fixed;	left:83px;	top:20px;	width:93%;	height:93%;	border:1px solid #b9d5ca;
	background:#fff; z-index:9999999;	
}
.prd-body{width:100%;	height:513px;	overflow-y:scroll;	scrollbar-width:thin; }

</style>

 <div class="page-content">
	<div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Partners</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Management</a></li>
                                <li class="breadcrumb-item active">Partners</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Manage Partners</h5>
                                <div>
								<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Partner</button>
                                    <a href="javascript:void(0);" class="btn btn-primary me-2" id="export_to_excel"><i class="fas fa-file-export"></i>&nbsp;Export</a>
                                </div>
                            </div>
                        </div>
						
						
                        <div class="card-body">
						
                                <select id="filterBox" name="filter-box" class="filter-select">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
    
                            <div class="table-responsive">

							<!--<table id="partner-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100%;">-->
                                <table id="partner-table" class="table table-striped table-hover table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
  
									<tr>
										<th>No</th>
										<th>Partner Name</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Agent</th>
										<th>Commi.(%)</th>
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
            
        </div> <!-- container-fluid -->
		
    </div> <!-- End Page-content -->



<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  <div class="offcanvas-header">
		<h5 id="offcanvasRightLabel">Add Partner</h5>
		<button type="button" class="button-close btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
	  
	  
	  <div class="loading-outer" style="display:none;">
		  <span class="spinner-loading">
		  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
		  <h6 style="color:red;"> Please Wait.......</h6>
		  </span>
	  </div>

				
		<form id="addPartner" enctype="multipart/form-data">
		  @csrf
		  
		  
			<input type="hidden" class="form-control" name="country_name" id="country_name" >
					  
		  
			<div class="form-group">
					<label for="partner_name" class="form-label">Name<span class="required">*</span></label>
					<input type="text" class="form-control" name="name" id="name" required>
				</div>
				
			   <div class="form-group">
					<label for="email" class="form-label">Email<span class="required">*</span></label>
					<input type="email" class="form-control" name="email" id="email" required>
				</div>
				
				<div class="form-group">
					<label for="mobile" class="form-label">Mobile<span class="required">*</span></label>
					<input type="hidden" class="form-control" name="country_code" id="country_code" value="91"  required>
					<br>
					<input type="tel" class="form-control" name="mobile" id="mobile" minlength=6 maxlength=15 required>
				</div>
								
				<div class="form-group">
				<div class="row">
				
				<div class="col-lg-4 col-xl-4 col-xxl-4">
					<label for="pin_code" class="form-label">Commission.(%)<span class="required">*</span></label>
					<input type="number" class="form-control" name="comm_percentage" id="comm_percentage" required>
				</div>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<label for="password" class="form-label"><b>Password<span class="required">*</span></b></label>
					<input type="text" class="form-control" name="password" id="password" required>
				</div>
				</div>
				</div>

			   <div class="form-group">
					<label for="company_name" class="form-label">Company Name<span class="required">*</span></label>
				<input type="text" class="form-control" name="company_name" id="company_name" required>
				</div>
				
			   <div class="form-group">
					<label for="website" class="form-label">Website</label>
					<input type="text" class="form-control" name="website" id="website">
				</div>
				
				<div class="form-group">
					<label for="country" class="form-label">Country<span class="required">*</span></label>
					<select class="form-control" name="country" id="country" required  style="color:#000 !important;">
					<option value="" selected disabled>select</option>
					@foreach($countries as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
					</select>
				</div>
								
				<div class="form-group">
					<label for="state" class="form-label">State<span class="required">*</span></label>
					<select class="form-control" name="state" id="state" style="color:#000 !important;" required>
					<option value="" selected disabled>select</option>
					
					</select>
				</div>
				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-7 col-xl-7 col-xxl-6">
					<label for="city" class="form-label">City<span class="required">*</span></label>
					<input type="text" class="form-control" name="city" id="city" required>
				</div>
				<div class="col-lg-5 col-xl-5 col-xxl-5">
					<label for="pin_code" class="form-label">Pin Code<span class="required">*</span></label>
					<input type="number" class="form-control" name="pin_code" minlength=6 maxlength=6 id="pin_code" required>
				</div>
				</div>
				</div>

				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-7 col-xl-7 col-xxl-6">
					<label for="bank_name" class="form-label">Bank Name</label>
					<input type="text" class="form-control" name="bank_name" id="bank_name">
				</div>
				<div class="col-lg-5 col-xl-5 col-xxl-5">
					<label for="ifsc_code" class="form-label">IFSC Code</label>
					<input type="text" class="form-control" name="ifsc_code" id="ifsc_code">
				</div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-7 col-xl-7 col-xxl-6">
					<label for="branch" class="form-label">Branch</label>
					<input type="text" class="form-control" name="branch" id="branch">
				</div>
				<div class="col-lg-5 col-xl-5 col-xxl-5">
					<label for="account_number" class="form-label">Account Number</label>
					<input type="text" class="form-control" name="account_number" id="account_number">
				</div>
				</div>
				</div>
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-7 col-xl-7 col-xxl-7">
				<label for="upi_id" class="form-label">UPI ID</label>
				<input type="text" class="form-control" name="upi_id" id="upi_id">
			</div>

			<div class="col-lg-5 col-xl-5 col-xxl-5">
				<label for="partner_status" class="form-label">Status</label>
				<select class="form-select" name="partner_status" id="partner_status">
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>
			</div>
			</div>
			<div class="form-group mt-3 mb-3" style="text-align:right;">
			<button type="button" class="button-close btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
			<button type="submit" id="partner_submit"  class="btn btn-primary">Submit</button>
			</div>
		</form>
				
	  </div>
</div>
    

	<!-- edit Partner Modal -->

   <div class="modal fade" id="edit-partner-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Edit Partner</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				
				</div>
			</div>
		</div>	
	</div>			
	


	<div class="modal fade" id="assign-agent-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Assign/Re-assign Agent</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form id="assign-agent-form">
					@csrf
					<input type="hidden" name="agent_partner_id" id="agent_partner_id">
					
					<div class="form-group">
						<label for="country" class="form-label">Agent Name<span class="required">*</span></label>
						
						<select class="form-control" name="assign_agent_id" id="assign_agent_id" required>
						<option value="" selected>select</option>
						@foreach($agents as $key=>$value)
						<option value="{{$key}}">{{$value}}</option>
						@endforeach
						</select>
						<label id="err-msg"></label>
					</div>
					
					<div class="modal-footer" style="text-align:right;margin-right:30px;">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
					<button type="button" class="btn btn-primary" id="btnAssignAgent">Submit</button>
					</div>
					</form>
				</div>
				
			</div>
		</div>	
	</div>					
		
		
	<div class="pr-detail hide">
		<div class="card">
			<div class="card-header" style="background:#b9d5ca;">
				<div class="d-flex justify-content-between align-items-center">
					<h5 class="card-title mb-0">PARTNER DETAILS</h5>
					<div>
						<button class="btn btn-outline " id="btnDetailClose"><i class="fa fa-times fs-4" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
			<div class="card-body prd-body">

				  <div class="loading-outer">
					  <span class="spinner-loading">
					  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
					  <h6 style="color:red;"> Please Wait.......</h6>
					  </span>
				  </div>

			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="set-commission-modal" tabindex="-1" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addPartnerModalLabel">Set Commission(%)</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form id="formSetCommission">
					@csrf
					<input type="hidden" name="partner_id" id="partner_id">
					
					<div class="form-group">
						<label for="country" class="form-label">Commission(%)<span class="required">*</span></label>
						<input type="number" class="form-control" name="commission" id="commission" required>
						<label id="err-msg"></label>
					</div>
					
					<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSetCommission" >Submit</button>
					</div>
					</form>
				</div>
				
			</div>
		</div>	
	</div>	

	
@push('scripts')

<script type="text/javascript">

    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });

/*$("#country").select2({
	    dropdownParent: $('#offcanvasRight')
});*/


</script>

<script>

var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});


$("#btnDetailClose").click(function()
{
	$(".pr-detail").removeClass('show');
	$(".pr-detail").fadeOut(500);
});


 $(function () {
        var table = $('#partner-table').DataTable({
            processing: true,
            serverSide: true,
			/*dom: 'lBfrtip',
			buttons: [
			'csv', 'excel'
			],*/
			
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
			ajax:
			{
				url:"{{ route('admin.get-partners') }}",
				data: function (data) 
				{
				   data.searchStatus = $('#filterBox').val();
				},
			},
			
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
			{data: 'mobile', name: 'mobile'},
            {data: 'agent_name', name: 'agent_name'},
			{data: 'commission_percentage', name: 'commission_percentage'},
			{data: 'status', name: 'status'},
            {data: 'action', name: 'action',className:'text-center'},
            ]
        });
        
$(".dataTables_filter").append(filterBox);

$("#filterBox").change(function()
 {
	table.draw();
 });

//VIEW PARTNER DETAILS --------------------------------------------------------

$("#partner-table tbody").on('click','.view-partner-details',function()
{
	$(".pr-detail").removeClass('hide');
	$(".pr-detail").fadeIn(300).addClass('show');
	
	var id=$(this).attr('id');
	
	$.ajax({
		url: "{{ url('admin/partner-details')}}"+"/"+id,
		type: 'get',
		//data: 
		success: function(res)
		{
			$(".prd-body").html(res);
		}
	});

});
//--------------------------------------------------------------------------


// adding record --------------------------------------------				
				
var addValidator=$('#addPartner').validate({ 
	
	rules: {
		pin_code: {
			required: true,
			minlength:6,
			maxlength:6,
		},
		mobile: {
			required: true,
			minlength:6,
			maxlength:15,
		},
	},

	submitHandler: function(form) 
	{
		$("#partner_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
		
		var code=phone_number.getSelectedCountryData()['dialCode'];
		$("#country_code").val(code);
		
		$(".loading-outer").css('display','block');
		
		$.ajax({
		url: "{{ route('admin.create-partner') }}",
		method: 'post',
		data: $('#addPartner').serialize(),
		success: function(result){
			if(result.status == 1)
			{
				//$("form#lead-form :input").each(function(){
				  //      $(this).val('')
					//});
				$("#partner_submit").attr('disabled',false).html('Submit')
				table.ajax.reload();
				toastr.success(result.msg);
				$('#addPartner')[0].reset();
				$("#state").html('<option value="" selected>select</option>');
				$(".loading-outer").css('display','none');
			}
			else
			{
				$("#partner_submit").attr('disabled',false).html('Submit');
				toastr.error(result.msg);
				$(".loading-outer").css('display','none');
			}
		}
		});
	  }
	});

$(".button-close").click(function()
{
	$(".loading-outer").css('display','none');
});

	$("#btnOffcanvas").click(function()
	{
		$('#addPartner')[0].reset();
		$("#state").html('<option value="" selected>select</option>');
		addValidator.resetForm();
	});

	
$("#partner-table tbody").on('change','.partner_status',function()
{
  var pval=$(this).val();
  var pid=$(this).data('id');
  
  $(this).removeClass('partner-active');
  $(this).removeClass('partner-inactive'); 

  if(pval==0)
  { 
     $(this).addClass('partner-inactive');
  }
  else
  { 
    $(this).addClass('partner-active');
  }
  
  
  jQuery.ajax({
			type: "POST",
			url: "{{route('admin.change-partner-status')}}",
			dataType: 'json',
			data: {_token:"{{csrf_token()}}",partner_id: pid,partner_status:pval},
			success: function(res)
			{
				 if(res.status==true)
				 {
				  toastr.success(res.msg);
				 }
				 else
				 {
				  toastr.error(res.msg);
				 }
			}
		});
})

		$("#partner-table tbody").on('click','.confirm_deletion',function()
        {
			if(confirm("Are you sure, delete this partner details?"))
			{
               $.ajax({
                    url: "{{ route('admin.delete-partner') }}",
                    method: 'post',
                    data: {'_token': '{{ csrf_token() }}','partner_id':$(this).attr('id')},
                    success: function(result)
                    {
                        if(result.status)
                        {
                            toastr.success("Partner successfully removed!");
                            table.ajax.reload();
                        }
                        
                    }
                });
			}
        })

				
	$("#partner-table tbody").on( 'click', '.edit-partner', function ()
		  {
			var id=$(this).attr('id');
			var Result=$("#edit-partner-modal .modal-body");
			
					jQuery.ajax({
					type: "GET",
					url: "{{url('admin/edit-partner')}}"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   Result.html(res);
					}
				});
		  });
	
		$("#partner-table tbody").on( 'click', '.set-commission', function ()
		  {
			var id=$(this).attr('id');
			$("#partner_id").val(id);
		  });
	
	
		$("#formSetCommission").submit(function(e)
        {
		   e.preventDefault();
		
			var formData=new FormData(document.getElementById('formSetCommission'));
			
		   $.ajax({
				url: "{{ route('admin.set-partner-commission-percentage') }}",
				method: 'post',
				data: formData,
				dataType:'json',
				success: function(result)
				{
					if(result.status)
					{
						toastr.success(result.msg);
						$("#set-commission-modal").modal('hide');
						table.ajax.reload();
					}
					
				},
				cache: false,
				contentType: false,
				processData: false
			});
        })
	
	
		
	 $("#country").on('change',function()
        {

            country = $(this).val()
			$("#country_name").val($('#country option:selected').text());
			
            $.ajax({
                    url: "{{ route('country-states') }}",
                    method: 'get',
                    data: {'country':country},
                    success: function(result)
                    {
                        if(result.states)
                        {
                            $("#state").empty();
							$('#state').append('<option value="" selected disabled> select </option>');
                            $.each(result.states, function(key, value) {
                                $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })
		
		$("#state").on('change',function()
        {
			$("#state_name").val($('#state option:selected').text());
        })
		
//ASSIGN AGENT TO PARTNER ----------------------------------------------------
		
        $("#partner-table tbody").on('click','.assign_agent',function()
		{
            var aid=$(this).data('id');
			
			$("#agent_partner_id").val($(this).attr('id'));
			 $("#assign_agent_id").val(aid); 
			$("#err-msg").html('');
        })


        $(document).on('click','#btnAssignAgent',function()
        {
			var agid=$("#assign_agent_id").val();

			if(agid!="")
			{
			   $.ajax({
					url: "{{ route('admin.assign-agent') }}",
					type: 'post',
					dataType:'json',
					//data: {'_token': '{{ csrf_token() }}','agent_id':agid,'partner_id' : prid},
					data:$("#assign-agent-form").serialize(),
					success: function(result){
						$("#assign-agent-modal").modal('hide')
						toastr.success("Agent assigned successfully !!!");
						table.ajax.reload();
					}
				});
			}
			else
			{
				$("#err-msg").html("Invalid agent.!");
			}
        })
 //-----------------------------------------------------------------------------------   


        $("#invite_partner").on('click',function()
        {
            $("#invite_modal").modal('show')
        })

        $("#send_invitation").on('click',function(e)
        {
            if($("#email_id").val().length == 0)
            {
                $("#email_label").addClass('hidden')
                $("#inputError").removeClass('hidden')
                $("#email_id").css({'border-color':'#a94442'})
            }
            else
            {
                $("#email_label").removeClass('hidden')
                $("#inputError").addClass('hidden')
                $("#email_id").css({'border-color':'#EBEBEB'})
                
                $(this).html('Sending&nbsp;&nbsp;<img src="http://www.bba-reman.com/images/fbloader.gif" />');
                e.preventDefault
                $.ajax({
                    url: "{{ route('agent.invite-partner') }}",
                    method: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'email_id':$("#email_id").val()
                    },
                    success: function(result){
                        $("#invite_modal").modal('hide')
                        $("#send_invitation").html("Invite now")
                        toastr.success(result.msg);
                    }
                });
            }
        });

        $('#copy').on('click', function(event) {
            $.ajax({
                url: "{{ route('agent.get-invite-link') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                },
                success: function(result)
                {
                    console.log(result)
                    if(result.status == 1)
                    {
                         $("#link").val(result.link)
                    }
                    copyToClipboard(event);
                }
            });
        });
    });


$("#export_to_excel").click(function()
{
	var status=($("#filterBox").val()!="")?$("#filterBox").val():"All";
	var lnk="{{url('admin/export-partner-list')}}"+"/"+status;
	$("#export_to_excel").attr('href',lnk);	
});



</script>

@endpush
@endsection