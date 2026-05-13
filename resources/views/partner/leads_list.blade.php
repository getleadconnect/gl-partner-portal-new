@extends('partner.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ MY LEADS — PAGE HEADER ============ */
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: #0F172A; letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: #475569; }
.gl-page-header__actions { display: inline-flex; align-items: center; gap: 10px; }
.gl-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 8px;
    font-size: 13px; font-weight: 500; line-height: 1.2;
    font-family: inherit; text-decoration: none; cursor: pointer;
    border: 1px solid transparent; white-space: nowrap;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-btn i { font-size: 15px; line-height: 1; }
.gl-btn-outline { background: #FFFFFF; border-color: #E7E9EE; color: #0F172A; }
.gl-btn-outline:hover { background: #FAFAFB; border-color: #CBD5E1; }
.gl-btn-primary { background: #1E3A5F; color: #fff; border-color: #1E3A5F; box-shadow: 0 1px 2px rgba(15,23,42,0.08); }
.gl-btn-primary:hover { background: #15294A; border-color: #15294A; color: #fff; }

/* ============ TOOLBAR ============ */
.gl-leads-toolbar {
    padding: 12px 16px;
    display: flex; align-items: center; justify-content: flex-start;
    gap: 14px; border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap; background: #FAFAFB;
}
.gl-leads-toolbar .filter-label {
    font-size: 11.5px; color: #94A3B8; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.04em;
}
.gl-leads-toolbar .filter-group { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.gl-leads-toolbar .filter-select-gl {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-leads-toolbar .filter-select-gl:focus { border-color: #1E3A5F; }

/* ============ TABLE ============ */
.gl-leads {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    padding:10px;
}
.gl-leads table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-leads table.data thead tr { background: var(--gl-surface-2); }
.gl-leads table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-leads table.data thead th.num { text-align: right; }
.gl-leads table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-leads table.data tbody tr:hover td { background: #FAFBFC; }
.gl-leads table.data td.num { font-family: 'Geist Mono', monospace; text-align: right; font-variant-numeric: tabular-nums; }
.gl-leads table.data td .num.strong { color: var(--gl-text); font-weight: 600; font-family: 'Geist Mono', monospace; }
.gl-leads table.data td .num.muted  { color: var(--gl-text-muted); font-family: 'Geist Mono', monospace; }

/* Lead avatar cell */
.gl-leads .row-avatar { display: inline-flex; align-items: center; gap: 10px; }
.gl-leads .row-avatar .av {
    width: 32px; height: 32px; border-radius: 50%;
    display: grid; place-items: center; font-size: 11px; font-weight: 600;
    color: #fff; flex-shrink: 0; letter-spacing: 0.02em;
}
.gl-leads .row-avatar .av.c1 { background: #1E3A5F; }
.gl-leads .row-avatar .av.c2 { background: #059669; }
.gl-leads .row-avatar .av.c3 { background: #B68B3C; }
.gl-leads .row-avatar .av.c4 { background: #DC2626; }
.gl-leads .row-avatar .av.c5 { background: #475569; }
.gl-leads .row-avatar .av.c6 { background: #2C5282; }
.gl-leads .row-avatar .nm { line-height: 1.25; }
.gl-leads .row-avatar .nm .name { color: var(--gl-text); font-weight: 500; font-size: 13px; }
.gl-leads .row-avatar .nm .sub { color: var(--gl-text-muted); font-size: 11px; margin-top: 2px; font-family: 'Geist Mono', monospace; }

/* Pills (status + payment) */
.gl-leads .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 500;
    background: #F1F5F9; color: #475569;
}
.gl-leads .pill::before { content:''; width:5px; height:5px; border-radius:50%; background: currentColor; }
.gl-leads .pill.paid    { background: #ECFDF5; color: #059669; }
.gl-leads .pill.unpaid  { background: #FEE2E2; color: #DC2626; }
.gl-leads .pill.pending { background: #FEF3C7; color: #B45309; }
.gl-leads .pill.won     { background: #ECFDF5; color: #059669; }
.gl-leads .pill.qual    { background: #EEF2F8; color: #1E3A5F; }
.gl-leads .pill.demo    { background: #FEF3C7; color: #D97706; }
.gl-leads .pill.cold    { background: #FEE2E2; color: #DC2626; }

/* Days in stage */
.gl-leads .days {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'Geist Mono', monospace; font-size: 12px; color: var(--gl-text-soft);
}
.gl-leads .days.fresh { color: var(--gl-text-muted); }
.gl-leads .days.stale { color: #D97706; font-weight: 500; }
.gl-leads .days.cold  { color: #DC2626; font-weight: 600; }
.gl-leads .days .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

/* Row action buttons */
.gl-leads .row-action { display: inline-flex; gap: 6px; }
.gl-leads .row-action-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--gl-border); background: var(--gl-surface);
    border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft); cursor: pointer; padding: 0;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-leads .row-action-btn i { font-size: 15px; line-height: 1; }
.gl-leads .row-action-btn:hover { background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F; }
.gl-leads .row-action-btn.danger:hover { background: #FEE2E2; border-color: #DC2626; color: #DC2626; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">My Leads</h1>
                <div class="gl-page-subtitle">Track and manage the leads you've submitted.</div>
            </div>
            <div class="gl-page-header__actions">
                <button id="btnOffcanvas" type="button" class="gl-btn gl-btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                    <i class="bx bx-plus"></i> Add Lead
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding:0;">

                        <div class="gl-leads-toolbar">
                            <span class="filter-label">Filter</span>
                            <div class="filter-group">
                                <select id="filter_status" class="filter-select-gl">
                                    <option value="">Status: Any</option>
                                    @foreach($lead_status as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <select id="filter_payment_status" class="filter-select-gl">
                                    <option value="">Payment: Any</option>
                                    <option value="1">Paid</option>
                                    <option value="0">Not Paid</option>
                                    <option value="2">Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive gl-leads">
                            <table id="my-leads-table" class="data" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lead</th>
                                        <th>Area</th>
                                        <th>Lead Status</th>
                                        <!--<th>Days in Stage</th>-->
                                        <th class="num">Deal Value</th>
                                        <th class="num">Commission</th>
                                        <th>Payment</th>
                                        <th>Pay Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
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
                { data: 'DT_RowIndex',    name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'lead',           name: 'lead',          orderable: false, searchable: false },
                { data: 'area',           name: 'area' },
                { data: 'lead_status',    name: 'lead_status',   orderable: false },
               // { data: 'days_in_stage',  name: 'days_in_stage', orderable: false, searchable: false },
                { data: 'deal_value',     name: 'deal_value',    orderable: false, searchable: false, className: 'num' },
                { data: 'commission_amount', name: 'commission_amount', className: 'num' },
                { data: 'p_status',       name: 'p_status',      orderable: false },
                { data: 'pay_date',       name: 'pay_date',      orderable: false },
                { data: 'action',         name: 'action',        orderable: false, searchable: false, className: 'text-center' },
            ]
        });

 
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
		
		
		$("#my-leads-table tbody").on('click','.confirm_deletion',function()
        {
			var leadId = $(this).data('id');
			Swal.fire({
				title: 'Delete this lead?',
				text:  'This action cannot be undone.',
				icon:  'warning',
				showCancelButton:  true,
				confirmButtonText: 'Yes, delete',
				cancelButtonText:  'Cancel',
				confirmButtonColor: '#DC2626',
				cancelButtonColor:  '#94A3B8',
				reverseButtons:     true,
			}).then(function (result) {
				if (!result.isConfirmed) return;
				$.ajax({
					url: "{{ route('partner.delete-lead') }}",
					method: 'post',
					data: {'_token':'{{ csrf_token() }}', 'lead_id': leadId},
					success: function (result) {
						if (result.status) {
							toastr.success("Lead successfully removed!");
							table.ajax.reload();
						} else {
							toastr.error(result.msg || 'Could not delete the lead.');
						}
					},
					error: function () {
						toastr.error('Could not delete the lead, please try again.');
					}
				});
			});
		});

});

	
	
</script>

@endpush
@endsection