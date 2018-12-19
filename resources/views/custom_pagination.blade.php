<style>
    ul.pagination li { margin-right: 5px; }
</style>

@if ($paginator->lastPage() > 1)
    <ul class="pagination fix mt-100 mb-0">
        <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}"><i class="zmdi zmdi-long-arrow-left"></i></a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" ><i class="zmdi zmdi-long-arrow-right"></i></a>
        </li>
    </ul>
@endif