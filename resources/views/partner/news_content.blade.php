<div class="offcanvas-header">
		<h5 id="offcanvasRightLabel">{{$news->title}}</h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body" style="padding:30px;">
	{!! $news->news_content !!}
</div>

