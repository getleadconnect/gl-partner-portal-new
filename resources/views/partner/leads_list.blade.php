@extends('partner.master')
@section('content')
<style>
.error
{
	color:red !important;
	font-size:12px !important;
}

.filter-select
{
	width:110px;
	height:34px;
	margin:8px 0px 8px 8px;
	border-color:#aaa !important;
}
.numericCol{ float:right;}


</style>

 <div class="page-content">
	<div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">My-leads</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">Leads</li>
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
                                <h5 class="card-title mb-0">Manage Leads</h5>
                                <div>
								
								<button id="btnOffcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Leads</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
						
                            <div class="d-flex">
							    <select id="filter_status" class="filter-select">
									<option value="" selected disabled>Status</option>
                                    <option value="">All</option>
									@foreach($lead_status as $value)
										<option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
							
                                <select id="filter_payment_status" class="filter-select">
								   <option value="" selected disabled>Payment</option>
                                    <option value="">All</option>
                                    <option value="1">Paid</option>
                                    <option value="0">Not Paid</option>
                                </select>
                            </div>
                            <div class="table-responsive">
							
							
							<table id="my-leads-table" class="table table-striped table-centered align-middle table-nowrap mb-0" style="width:100% !important;">
                                    <thead>
                                      
										<tr >
											<th>No</th>
											<th>Lead</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Area</th>
											<th>Lead Status</th>
											<th align="right">Amount</th>
											<th>Commission</th>
											<th>Payment Status</th>
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
    </div>

	
<div class="modal" id="edit-lead-modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Lead</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    
	
      </div>
      
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  <div class="offcanvas-header">
		<h5 id="offcanvasRightLabel">Add Lead</h5>
			<button type="button" class="button-close btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
	  
	  	  
	  <div class="loading-outer" style="display:none;">
		  <span class="spinner-loading">
		  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
		  <h6 style="color:red;"> Please Wait.......</h6>
		  </span>
	  </div>
	  	  
		<form id="lead-form">
			  @csrf
			  
			  <input type="hidden" class="form-control"  name="country_name" id="country_name" >
			  
				<div class="form-group">
						<label for="recipient-name" class="form-control-label">Customer Name<span style="color: red;">*</span></label>
							<input type="text" class="form-control" placeholder=""
								value="{{ old('name') }}" name="name" id="name" required>
					</div>
					
				   <div class="form-group">
					 <label for="recipient-name" class="form-control-label">Mobile Number<span
									style="color: red;">*</span></label>
						<br><input type="hidden" class="form-control" placeholder="" value="91" name="country_code"  id="country_code">
						<input type="number" class="form-control" placeholder="" value="{{ old('mobile') }}" name="mobile" id="mobile" required>
					</div>
					
					<div class="form-group">
						<label for="recipient-name" class="form-control-label">Company Name(your firm)<span style="color: red;">*</span></label>
							<input type="text" class="form-control" placeholder=""
								value="{{ old('company_name') }}" name="company_name" id="company_name" required>
					</div>
					
					<div class="form-group">
						 <label for="recipient-name" class="form-control-label">Designation</label>
							<input type="text" class="form-control" placeholder=""
								value="{{ old('designation') }}" name="designation" id="designation" >
					</div>

				<div class="form-group">
						 <label for="recipient-name" class="form-control-label">Email<span style="color: red;">*</span></label>
							<input type="email" class="form-control" placeholder=""
								value="{{ old('email') }}" name="email" id="email" required>
				</div>
				
				<div class="form-group">
					<label for="recipient-name" class="form-control-label">Business Category<span style="color: red;">*</span></label>
					   <select id="bussiness_category_id" name="bussiness_category_id" class="form-control" style="color:#000 !important;" required>
						  <option value="0" selected disabled>select</option>
						  @foreach($bussiness_categories as $key=>$value)
						  <option value="{{$key}}" >{{$value}}</option>
						  @endforeach
						  {{--{!! Form::select('edit_bussiness_category_id', $bussiness_categories, null, ['class' => 'form-control','id'=>'edit_business_category_id']) !!}--}}
					   </select>
				</div>
						
				
				{{-- <!--<div class="form-group">
					<label for="recipient-name" class="form-label">Lead Type<span style="color: red;">*</span></label>
					   <select id="plan_type" name="plan_type" class="form-control" required>
						  <option value="0" selected disabled>select</option>
						  <option value="1">Product</option>
						  <option value="2">Service</option>
					   </select>
				</div>--> --}}
				
				{{-- <!--<div class="form-group">
					<label for="recipient-name" class="form-label">Select Plan<span style="color: red;">*</span></label>
					<select id="plan" name="plan" class="form-control" name="plan" required>
					<option value="" selected disabled>select</option>
					</select>
				</div>--> --}}

				<div class="form-group">
					<label for="partnerPhone" class="form-label">Country</label>
					<select class="form-control" name="country" id="country">
					<option value="" selected disabled>select</option>
					@foreach($countries as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="recipient-name" class="form-label">State</label>
					<select name="state" id="state" class="form-control">
					<option value="" selected disabled>select</option>
					</select>
				</div>

				<div class="form-group">
				<div class="row">
				<div class="col-lg-7 col-xl-7 col-xxl-6">
				<label for="recipient-name" class="form-label">Area/Location</label>
					<input type="text" class="form-control" placeholder=""
					 value="{{ old('area') }}" name="area" id="area" >
				</div>
				<div class="col-lg-5 col-xl-5 col-xxl-5">
					<label for="recipient-name" class="form-label">Pincode</label>
					<input type="number" class="form-control" placeholder=""
					 value="{{ old('pincode') }}" name="pincode" id="pincode" >
				</div>
				</div>
				</div>
								
				<div class="form-group">
					<label for="recipient-name" class="form-label">Address</label>
					<textarea class="form-control" name="address" id="address" placeholder="">{{ old('address') }}</textarea>
				</div>
				<div class="form-group">
					<label for="recipient-name" class="form-label">Remarks</label>
					<textarea class="form-control" name="remarks" id="remarks" placeholder="">{{ old('remarks') }}</textarea>
				</div>
				
				
			<div class="form-group mt-3 mb-3" style="text-align:right;">
				<button type="button"  class=" button-close btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
				<button type="submit" id="lead_submit"  class="btn btn-primary">Submit</button>
			</div>
			
		</form>
				
	</div>
</div>

<!-- End Page-content -->

@push('scripts')

<script type="text/javascript">
    $(function () {
    toastr.options = {
        // "positionClass": "toast-top-right cp",
        "showDuration": "300000",
        "hideMethod": "fadeOut"
        }
    });

</script>

<script>

var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});

 $(function () {

    var table = $('#my-leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],

			ajax: {
                url: "{{ route('partner.get-leads') }}",
                data: function (d) 
                {
                    d.status = $('#filter_status').val();
					d.paymentStatus = $('#filter_payment_status').val();
                }
            },
			
            columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'email', name: 'email'},
				{data: 'mobile', name: 'mobile'},
				{data: 'area', name: 'area'},
				{data: 'lead_status', name: 'lead_status'},
				{data: 'amount_collected', name: 'amount_collected'},
				{data: 'commission_amount', name: 'commission_amount'},
				{data: 'p_status', name: 'p_status'},
				{data: 'action', name: 'action'},
            ]
        });

$(".dataTables_filter").append(filter_status);
$(".dataTables_filter").append(filter_payment_status);

 
 $('#filter_payment_status').change(function()
 {
	 table.ajax.reload();
 });
 
  $('#filter_status').change(function()
 {
	 table.ajax.reload();
 });
 
 
  
var addLeadValidator=$('#lead-form').validate({ 
                rules: {
                    name: {
                        required: true
                    },

                    mobile: {
                        required: true,
                        minlength:10,
                        maxlength:10,
                    },

                    minlength: {
                        required: true,
                        minlength: 10
                    },
                    maxlength: {
                        required: true,
                        maxlength: 10
                    }
                },
                submitHandler: function(form) 
                {
                    $("#lead_submit").attr('disabled',true).html('Saving <i class="fa fa-spinner fa-spin"></i>')
					
					$(".loading-outer").css('display','block');
										
					var code=phone_number.getSelectedCountryData()['dialCode'];
					$("#country_code").val(code);
										
					formData=new FormData(document.getElementById('lead-form'));
					
                    $.ajax({
						url: "{{ route('partner.create-lead') }}",
						type: 'post',
						dataType:'json',
						data: formData ,  //$("#lead-form").serialize(),
						success: function(result)
                        {
                            if(result.status == 1)
                            {
                                table.ajax.reload();    
                                toastr.success(result.msg);
								$("#lead-form")[0].reset();
                                $("#lead_submit").attr('disabled',false).html('Submit')
								$("#state").html('<option value="" selected>select</option>');
								$(".loading-outer").css('display','none');
								
                            }
                            else{
								toastr.error(result.msg);
								$("#lead_submit").attr('disabled',false).html('Submit')
								$(".loading-outer").css('display','none');
							}
                        },
						cache: false,
						contentType: false,
						processData: false
						
                    });
                  }
            });

$(".button-close").click(function()
{
	$(".loading-outer").css('display','none');
});


$("#btnOffcanvas").click(function()
{
	$('#lead-form')[0].reset();
	$("#state").html('<option value="" selected>select</option>');
	$("#lead_submit").attr('disabled',false).html('Submit');
	addLeadValidator.resetForm();
});

		
		$("#my-leads-table tbody").on('click','.edit_lead',function()
        {
            var lid=$(this).attr('id');
			var Result=$("#edit-lead-modal .modal-body");

            $.ajax({
                    url: "{{ url('partner/edit-lead')}}"+"/"+lid,
                    type: 'get',
                    //data: {'lead_id':$(this).data('id')},
					dataType:"html",
                    success: function(res)
                    {
                        Result.html(res);
                    }
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
                            $('#state').empty();
							$('#state').append('<option value="" selected disabled> select </option>');
                            $.each(result.states, function(key, value) {
                                $('#state').append('<option value="'+ value +'">'+ value +'</option>');
                            });
                        }
                    }
                });
        })

        

        $("#plan_type").on('change',function()
        {
            plan_type = $(this).val()

            $.ajax({
                    url: "{{ route('get-plans') }}",
                    method: 'get',
                    data: {'plan_type':plan_type},
                    success: function(result)
                    {
                        $('#plan').html('<option value="" selected disabled>select</option>');
                        $('#plan').append(result.data);
                    }
                });
        })
		
		
		$(document).on('click','.confirm_deletion',function()
        {
			$.ajax({
				url: "{{ route('partner.delete-lead') }}",
				method: 'post',
				data: {'_token': '{{ csrf_token() }}','lead_id':$(this).data('id')},
				success: function(result)
				{
					if(result.status)
					{
						toastr.success("Lead successfully removed!");
						table.ajax.reload();
					}
					
				}
			});
		});

});

	
	
</script>

@endpush
@endsection