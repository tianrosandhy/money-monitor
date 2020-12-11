<ul class="pagination transaction-pagination my-3">
    @if($transactions['has_prev_page'])
    <li class="page-item">
        <a class="page-link" href="#" data-page="{{ $transactions['page'] - 1 }}"><< Prev</a>
    </li>
    @else
    <li class="page-item disabled">
        <a class="page-link" href="#"><< Prev</a>
    </li>
    @endif

    @if($transactions['has_next_page'])
    <li class="page-item">
        <a class="page-link" href="#" data-page="{{ $transactions['page'] + 1 }}">Next >></a>
    </li>
    @else
    <li class="page-item disabled">
        <a class="page-link" href="#">Next >></a>
    </li>
    @endif
</ul>