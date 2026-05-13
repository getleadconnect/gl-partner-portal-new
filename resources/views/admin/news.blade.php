@extends('admin.master')
@section('content')
<style>
.error { color:red !important; font-size:12px !important; }

/* ============ NEWS — PAGE HEADER ============ */
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

/* ============ TABLE ============ */
.gl-news {
    --gl-surface: #FFFFFF; --gl-surface-2: #FAFAFB;
    --gl-border: #E7E9EE; --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A; --gl-text-soft: #475569; --gl-text-muted: #94A3B8;
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    padding:10px;
}
.gl-news table.data { width: 100%; border-collapse: collapse; font-size: 13px; }
.gl-news table.data thead tr { background: var(--gl-surface-2); }
.gl-news table.data thead th {
    padding: 10px 16px; text-align: left;
    font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;
    color: var(--gl-text-muted); font-weight: 600;
    border-bottom: 1px solid var(--gl-border-soft); white-space: nowrap;
}
.gl-news table.data tbody td {
    padding: 12px 16px; border-bottom: 1px solid var(--gl-border-soft);
    color: var(--gl-text-soft); vertical-align: middle; background: var(--gl-surface);
}
.gl-news table.data tbody tr:hover td { background: #FAFBFC; }

/* Row action buttons */
.gl-news .row-action { display: inline-flex; gap: 6px; }
.gl-news .row-action-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--gl-border); background: var(--gl-surface);
    border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    color: var(--gl-text-soft); cursor: pointer; padding: 0;
    text-decoration: none;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.gl-news .row-action-btn i { font-size: 15px; line-height: 1; }
.gl-news .row-action-btn:hover { background: #EEF2F8; border-color: #1E3A5F; color: #1E3A5F; }
.gl-news .row-action-btn.danger:hover { background: #FEE2E2; border-color: #DC2626; color: #DC2626; }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Latest News</h1>
                <div class="gl-page-subtitle">Announcements visible to partners on the portal.</div>
            </div>
            <div class="gl-page-header__actions">
                <a href="{{ route('admin.add-news') }}" class="gl-btn gl-btn-primary">
                    <i class="bx bx-plus"></i> Add News
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding:0;">
                        <div class="table-responsive gl-news">
                            <table id="news-table" class="data" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Content</th>
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

@push('scripts')

@if (Session::get('success'))
    <script>
        toastr.options = { "closeButton": true, "progressBar": true };
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif

<script type="text/javascript">
$(function () {
    toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" };
});

$(function () {
    var table = $('#news-table').DataTable({
        processing: true,
        serverSide: true,
        stateStatus: true,
        "language": { searchPlaceholder: 'Search', sSearch: '' },
        "lengthMenu": [10, 25, 50, 100, 150, 200],
        ajax: { url: "{{ route('admin.get-news-list') }}" },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'news_content', name: 'news_content' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });

    $("#news-table tbody").on('click', '.confirm_deletion', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this news entry?',
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
                url: "{{ route('admin.delete-news') }}",
                method: 'post',
                data: { '_token': '{{ csrf_token() }}', 'news_id': id },
                success: function (result) {
                    if (result.status) {
                        toastr.success("News successfully removed!");
                        table.ajax.reload();
                    } else {
                        toastr.error('Could not delete the news.');
                    }
                },
                error: function () {
                    toastr.error('Could not delete the news, please try again.');
                }
            });
        });
    });
});
</script>
@endpush
@endsection
