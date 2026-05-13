@extends('partner.master')
@section('content')
<style>
/* ============ LATEST NEWS — PAGE HEADER ============ */
.gl-news-page {
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    --gl-surface: #FFFFFF;
    --gl-border: #E7E9EE;
    --gl-border-soft: #F0F2F5;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    --gl-accent: #1E3A5F;
}
.gl-page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 8px 4px 20px; flex-wrap: wrap;
}
.gl-page-title { font-size: 24px; font-weight: 700; color: var(--gl-text); letter-spacing: -0.01em; margin: 0 0 4px 0; line-height: 1.2; }
.gl-page-subtitle { font-size: 13px; color: var(--gl-text-soft); }

/* News grid */
.gl-news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
@media (max-width: 1100px) { .gl-news-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 700px)  { .gl-news-grid { grid-template-columns: 1fr; } }

.gl-news-card {
    background: var(--gl-surface);
    border: 1px solid var(--gl-border);
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 2px rgba(15,23,42,0.04);
    transition: box-shadow .15s ease, transform .15s ease, border-color .15s ease;
}
.gl-news-card:hover {
    border-color: #CBD5E1;
    box-shadow: 0 8px 20px rgba(15,23,42,0.06);
    transform: translateY(-1px);
}
.gl-news-card__accent {
    height: 4px;
    background: linear-gradient(90deg, #1E3A5F 0%, #2C5282 60%, #B68B3C 100%);
}
.gl-news-card__body {
    padding: 18px 20px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.gl-news-card__meta {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px;
    color: var(--gl-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
    margin-bottom: 10px;
}
.gl-news-card__meta i { font-size: 14px; line-height: 1; }
.gl-news-card__title {
    font-size: 15px;
    font-weight: 600;
    color: var(--gl-text);
    text-decoration: none;
    line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.gl-news-card__title:hover { color: var(--gl-accent); }
.gl-news-card__excerpt {
    font-size: 13px;
    color: var(--gl-text-soft);
    line-height: 1.6;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 14px;
}
.gl-news-card__footer {
    display: flex; justify-content: space-between; align-items: center;
    border-top: 1px solid var(--gl-border-soft);
    padding-top: 12px;
}
.gl-news-card__date {
    font-size: 11.5px;
    color: var(--gl-text-muted);
    font-family: 'Geist Mono', monospace;
}
.gl-news-card__read {
    display: inline-flex; align-items: center; gap: 4px;
    background: transparent;
    border: none;
    color: var(--gl-accent);
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    font-family: inherit;
    text-decoration: none;
    padding: 0;
}
.gl-news-card__read:hover { text-decoration: underline; }
.gl-news-card__read i { font-size: 15px; line-height: 1; }

/* Empty state */
.gl-news-empty {
    background: var(--gl-surface);
    border: 1px dashed var(--gl-border);
    border-radius: 10px;
    padding: 48px 20px;
    text-align: center;
    color: var(--gl-text-muted);
    font-size: 13.5px;
}
.gl-news-empty i { font-size: 28px; display: block; margin-bottom: 10px; color: var(--gl-text-muted); }

/* Article offcanvas */
.offcanvas.offcanvas-end { width: 50% !important; }
@media (max-width: 900px) { .offcanvas.offcanvas-end { width: 90% !important; } }
</style>

<div class="page-content">
    <div class="container-fluid gl-news-page">

        <div class="gl-page-header">
            <div class="gl-page-header__text">
                <h1 class="gl-page-title">Latest News</h1>
                <div class="gl-page-subtitle">Announcements and updates from the Getlead team.</div>
            </div>
        </div>

        @if(count($news) > 0)
            <div class="gl-news-grid">
                @foreach($news as $nws)
                    <article class="gl-news-card">
                        <div class="gl-news-card__accent"></div>
                        <div class="gl-news-card__body">
                            <div class="gl-news-card__meta">
                                <i class="bx bx-news"></i> News
                            </div>
                            <a href="javascript:;" class="gl-news-card__title news-content" id="{{ $nws->id }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                                {{ $nws->title }}
                            </a>
                            <div class="gl-news-card__excerpt">
                                {!! \Str::limit(strip_tags($nws->news_content), 220) !!}
                            </div>
                            <div class="gl-news-card__footer">
                                <span class="gl-news-card__date">
                                    {{ \Carbon\Carbon::parse($nws->created_at)->format('d M Y') }}
                                </span>
                                <a href="javascript:;" class="gl-news-card__read news-content" id="{{ $nws->id }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                                    Read more <i class="bx bx-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="gl-news-empty">
                <i class="bx bx-news"></i>
                No news yet — check back soon.
            </div>
        @endif

    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"></div>

@push('scripts')
<script type="text/javascript">
$(function () {
    toastr.options = { "showDuration": "300000", "hideMethod": "fadeOut" };
});

$(function () {
    $(document).on('click', '.news-content', function () {
        $("#offcanvasRight").html('');
        var id = $(this).attr('id');
        var Result = $("#offcanvasRight");
        jQuery.ajax({
            type: "GET",
            url:  "{{ url('partner/get-news-data') }}/" + id,
            dataType: 'html',
            success: function (res) {
                Result.html(res);
            }
        });
    });
});
</script>
@endpush
@endsection
