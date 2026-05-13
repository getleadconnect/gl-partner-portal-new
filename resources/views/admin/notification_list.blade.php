@extends('admin.master')
@section('content')
<style>
/* ============ NOTIFICATIONS — PAGE HEADER ============ */
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: #0F172A; letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: #475569; }

/* ============ TABLE ============ */
.gl-noti {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    padding:10px;
}
.gl-noti table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-noti table.data thead tr { background: var(--gl-surface-2); }
.gl-noti table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-noti table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-noti table.data tbody tr:hover td { background: #FAFBFC; }

/* Pills */
.gl-noti .pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 500;
    background: #F1F5F9; color: #475569;
}
.gl-noti .pill::before { content:''; width:5px; height:5px; border-radius:50%; background: currentColor; }
.gl-noti .pill.new     { background: #ECFDF5; color: #059669; }
.gl-noti .pill.read    { background: #F1F5F9; color: #94A3B8; }
.gl-noti .pill.admin   { background: #FBF5E5; color: #B68B3C; }
.gl-noti .pill.partner { background: #EEF2F8; color: #1E3A5F; }

/* Toolbar */
.gl-noti-toolbar {
    padding: 12px 16px;
    display: flex; align-items: center; justify-content: flex-start;
    gap: 14px; border-bottom: 1px solid #F0F2F5;
    flex-wrap: wrap; background: #FAFAFB;
}
.gl-noti-toolbar .filter-label {
    font-size: 11.5px; color: #94A3B8; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.04em;
}
.gl-noti-toolbar .filter-group { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.gl-noti-toolbar .date-range { display: inline-flex; align-items: center; gap: 6px; }
.gl-noti-toolbar .date-range__label {
    font-size: 11.5px; color: #94A3B8; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.04em; margin: 0;
}
.gl-noti-toolbar .filter-select-gl,
.gl-noti-toolbar .date-range__input {
    padding: 6px 10px; border: 1px solid #E7E9EE; border-radius: 6px;
    background: #FFFFFF; font-size: 12.5px; color: #0F172A;
    font-family: inherit; cursor: pointer; outline: none;
}
.gl-noti-toolbar .filter-select-gl:focus,
.gl-noti-toolbar .date-range__input:focus { border-color: #1E3A5F; }
.gl-noti-toolbar .date_clear {
    width: 28px; height: 28px; padding: 0;
    display: inline-flex; align-items: center; justify-content: center;
    background: #FFFFFF; border: 1px solid #E7E9EE; border-radius: 999px;
    color: #94A3B8; cursor: pointer;
    transition: all .15s ease;
}
.gl-noti-toolbar .date_clear:hover { border-color: #DC2626; color: #DC2626; }
.gl-noti-toolbar .date_clear i { font-size: 14px; line-height: 1; }

/* Row action button */
.gl-noti .row-action { display: inline-flex; gap: 6px; }
.gl-noti .row-action-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--gl-border); background: var(--gl-surface);
    border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft); cursor: pointer; padding: 0;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-noti .row-action-btn i { font-size: 15px; line-height: 1; }
.gl-noti .row-action-btn:hover { background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F; }
.gl-noti .row-action-btn.danger:hover { background: #FEE2E2; border-color: #DC2626; color: #DC2626; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Notifications</h1>
                <div class="gl-page-subtitle">All system and partner notifications.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding:0;">

                        <div class="gl-noti-toolbar">
                            <div class="filter-group">
                                <div class="date-range">
                                    <label class="date-range__label">From</label>
                                    <input type="date" id="filter_date_from" class="filter-select-gl date-range__input">
                                    <label class="date-range__label">To</label>
                                    <input type="date" id="filter_date_to" class="filter-select-gl date-range__input">
                                    <button type="button" id="filter_date_clear" class="date_clear" title="Clear date range"><i class="bx bx-x"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive gl-noti">
                            <table id="notification-table" class="data" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notification</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
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

@push('scripts')
<script type="text/javascript">
$(function () {
    toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" };
});

$(function () {
    var table = $('#notification-table').DataTable({
        processing: true,
        serverSide: true,
        "language": {
            searchPlaceholder: 'Search',
            sSearch: '',
        },
        ajax: {
            url: "{{ route('admin.notification-list') }}",
            data: function (d) {
                d.date_from = $('#filter_date_from').val() || '';
                d.date_to   = $('#filter_date_to').val()   || '';
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'notification', name: 'notification' },
            { data: 'cdate' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', className: 'text-center' },
        ]
    });

    // Date range — redraw on change
    $('#filter_date_from, #filter_date_to').on('change', function () {
        table.ajax.reload();
    });

    // Clear button
    $('#filter_date_clear').on('click', function () {
        $('#filter_date_from, #filter_date_to').val('');
        table.ajax.reload();
    });

    $("#notification-table tbody").on('click', '.confirm_deletion', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this notification?',
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
                url: "{{ url('admin/delete-notification') }}/" + id,
                type: 'get',
                dataType: 'json',
                success: function (result) {
                    if (result.status) {
                        toastr.success("Notification successfully removed!");
                        table.ajax.reload();
                    } else {
                        toastr.error('Could not delete the notification.');
                    }
                },
                error: function () {
                    toastr.error('Could not delete the notification, please try again.');
                }
            });
        });
    });
});
</script>
@endpush
@endsection
