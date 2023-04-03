<div {{ $attributes->merge(['class' => 'alert alert-'.$type]) }}>
    <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</a>
    {{ $message }}
</div>
