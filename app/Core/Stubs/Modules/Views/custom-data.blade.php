@foreach($data as $row)
<div class="bg-white mb-3 custom-post-item">
    <h5 class="card-title">{{ $row['title'] }}</h5>
    <p class="card-text"><small class="text-muted">{{ $row['description'] }}</small></p>
    {!! $row['action'] !!}
</div>
@endforeach