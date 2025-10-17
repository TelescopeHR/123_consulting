@if ($paginator->hasPages())
	<div class="pagination">
		<ul class="pagination-list m-0 d-flex align-items-center">

			{{-- Previous Page Link --}}
			<li class="page-item pagination-action previous-button {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
				<a class="page-link" href="{{ $paginator->previousPageUrl() ?? '#' }}">
					<img src="{{ asset('assets/images/pagination-arrow.svg') }}" width="24px" height="24px" alt="Previous">
				</a>
			</li>

			{{-- Page Numbers --}}
			@foreach ($elements as $element)
				{{-- Separator ("...") --}}
				@if (is_string($element))
					<li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
				@endif

				{{-- Page Links --}}
				@if (is_array($element))
					@foreach ($element as $page => $url)
						<li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
							<a class="page-link" href="{{ $url }}">{{ $page }}</a>
						</li>
					@endforeach
				@endif
			@endforeach

			{{-- Next Page Link --}}
			<li class="page-item pagination-action next-button {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
				<a class="page-link" href="{{ $paginator->nextPageUrl() ?? '#' }}">
					<img src="{{ asset('assets/images/pagination-arrow.svg') }}" width="24px" height="24px" alt="Next">
				</a>
			</li>
		</ul>
	</div>
@endif
