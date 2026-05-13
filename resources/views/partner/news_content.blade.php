<style>
.gl-news-article {
    font-family: 'Geist', -apple-system, BlinkMacSystemFont, sans-serif;
    --gl-text: #0F172A;
    --gl-text-soft: #475569;
    --gl-text-muted: #94A3B8;
    --gl-border-soft: #F0F2F5;
    --gl-accent: #1E3A5F;
}
.gl-news-article__header {
    padding: 22px 28px 18px;
    border-bottom: 1px solid var(--gl-border-soft);
    background: linear-gradient(180deg, #FFFFFF 0%, #FAFBFD 100%);
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.gl-news-article__icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    background: #EEF2F8;
    color: var(--gl-accent);
    display: grid; place-items: center;
    flex-shrink: 0;
}
.gl-news-article__icon i { font-size: 18px; }
.gl-news-article__meta {
    font-size: 10.5px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 600;
    color: var(--gl-text-muted);
    margin-bottom: 4px;
}
.gl-news-article__title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gl-text);
    letter-spacing: -0.01em;
    line-height: 1.3;
    margin: 0;
}
.gl-news-article__date {
    margin-top: 8px;
    font-size: 12px;
    color: var(--gl-text-muted);
    font-family: 'Geist Mono', monospace;
    display: inline-flex; align-items: center; gap: 6px;
}
.gl-news-article__date i { font-size: 14px; }
.gl-news-article__close {
    margin-left: auto;
    width: 32px; height: 32px;
    border-radius: 6px;
    border: 1px solid #E7E9EE;
    background: #fff;
    color: var(--gl-text-soft);
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background .15s ease, color .15s ease, border-color .15s ease;
}
.gl-news-article__close:hover {
    background: #FEE2E2; border-color: #DC2626; color: #DC2626;
}
.gl-news-article__close i { font-size: 16px; line-height: 1; }
.gl-news-article__body {
    padding: 22px 28px 28px;
    font-size: 14px;
    color: var(--gl-text-soft);
    line-height: 1.7;
}
.gl-news-article__body p { margin: 0 0 14px 0; }
.gl-news-article__body p:last-child { margin-bottom: 0; }
.gl-news-article__body h1,
.gl-news-article__body h2,
.gl-news-article__body h3,
.gl-news-article__body h4 {
    color: var(--gl-text);
    margin: 22px 0 10px;
    line-height: 1.3;
    font-weight: 600;
}
.gl-news-article__body h1 { font-size: 18px; }
.gl-news-article__body h2 { font-size: 16px; }
.gl-news-article__body h3 { font-size: 15px; }
.gl-news-article__body h4 { font-size: 14px; }
.gl-news-article__body ul,
.gl-news-article__body ol {
    margin: 0 0 14px 22px;
    padding: 0;
}
.gl-news-article__body li { margin-bottom: 6px; }
.gl-news-article__body a { color: var(--gl-accent); }
.gl-news-article__body a:hover { text-decoration: underline; }
.gl-news-article__body img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 12px 0;
    border: 1px solid var(--gl-border-soft);
}
.gl-news-article__body blockquote {
    margin: 14px 0;
    padding: 10px 16px;
    background: #FAFAFB;
    border-left: 3px solid var(--gl-accent);
    color: var(--gl-text-soft);
    font-style: italic;
    border-radius: 0 6px 6px 0;
}
.gl-news-article__body code {
    background: #F1F5F9;
    color: #0F172A;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12.5px;
    font-family: 'Geist Mono', monospace;
}
</style>

<div class="gl-news-article">
    <div class="gl-news-article__header">
        <div class="gl-news-article__icon">
            <i class="bx bx-news"></i>
        </div>
        <div style="flex:1;">
            <div class="gl-news-article__meta">Announcement</div>
            <h2 class="gl-news-article__title">{{ $news->title }}</h2>
            <div class="gl-news-article__date">
                <i class="bx bx-calendar"></i>
                {{ \Carbon\Carbon::parse($news->created_at)->format('d M Y · h:i A') }}
            </div>
        </div>
        <button type="button" class="gl-news-article__close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="bx bx-x"></i>
        </button>
    </div>

    <div class="gl-news-article__body">
        {!! $news->news_content !!}
    </div>
</div>
