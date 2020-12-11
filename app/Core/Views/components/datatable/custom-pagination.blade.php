<?php
$max_threshold = 5;
$index_start = 1;
$index_end = $max_page;
$show_prev_dots = false;
$show_next_dots = true;

if($page < ($max_threshold / 2)){
    $index_end = $max_threshold;
    if($index_end > $max_page){
        $index_end = $max_page;
    }
}
else{
    $index_end = $page + floor($max_threshold / 2);
    if($index_end >= $max_page){
        $index_end = $max_page;
        $show_next_dots = false;
    }
    if($index_end - $max_threshold >= $index_start){
        $index_start = $index_end - $max_threshold + 1;
    }
}


if($index_start > 1){
    $show_prev_dots = true;
}
?>
@if($index_end > 1)
<nav class="custom-pagination">
    <ul class="pagination">
        @if ($page <= 1)
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="#" data-page="{{ $page-1 }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        @if($show_prev_dots)
        <li class="page-item">
            <a class="page-link" href="#" data-page="1" rel="first" aria-label="@lang('pagination.previous')">1</a>
        </li>
        <li class="page-item disabled">
            <span class="page-link">...</span>
        </li>
        @endif

        @for($i=$index_start; $i<=$index_end; $i++)
            @if ($i == $page)
                <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="#" data-page="{{ $i }}">{{ $i }}</a></li>
            @endif
        @endfor

        @if($show_next_dots)
        <li class="page-truetem disabled">
            <span class="page-link">...</span>
        </li>
        <li class="page-item">
            <a class="page-link" href="#" data-page="{{ $max_page }}" rel="prev" aria-label="@lang('pagination.previous')">{{ $max_page }}</a>
        </li>

        @endif

        @if ($page < $max_page)
            <li class="page-item">
                <a class="page-link" href="#" rel="next" data-page="{{ $page+1 }}" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
</nav>
@endif