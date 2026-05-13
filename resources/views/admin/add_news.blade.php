@extends('admin.master')
@section('content')
<style>
/* ============ ADD NEWS — PAGE HEADER ============ */
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

/* Form area */
.gl-news-form { padding: 4px 4px; }
.gl-news-form .form-label {
    font-size: 12px; color: #475569; font-weight: 500;
    margin-bottom: 6px; display: block;
}
.gl-news-form .form-control {
    padding: 8px 12px;
    border: 1px solid #E7E9EE; border-radius: 6px;
    font-size: 13px; font-family: inherit;
    background: #FFFFFF; color: #0F172A;
}
.gl-news-form .form-control:focus { border-color: #1E3A5F; outline: none; box-shadow: none; }
.gl-news-form .form-actions {
    display: flex; gap: 8px; justify-content: flex-end;
    margin-top: 16px;
}
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Add News</h1>
                <div class="gl-page-subtitle">Publish a new announcement visible to partners.</div>
            </div>
            <div class="gl-page-header__actions">
                <a href="{{ route('admin.news') }}" class="gl-btn gl-btn-outline">
                    <i class="bx bx-arrow-back"></i> Back to News
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ route('admin.create-news') }}" enctype="multipart/form-data" class="gl-news-form">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="news_content" class="form-label">News Content</label>
                                <textarea class="form-control content1" style="height:200px;" name="news_content" id="news_content" required></textarea>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('admin.news') }}" class="gl-btn gl-btn-outline">Cancel</a>
                                <button type="submit" class="gl-btn gl-btn-primary">
                                    <i class="bx bx-save"></i> Publish News
                                </button>
                            </div>
                        </form>

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
</script>
@endpush
@endsection
