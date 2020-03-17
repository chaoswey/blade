<!-- /resources/views/components/alert.blade.php -->

@props(['type', 'message'])

<div {{ $attributes->merge(['class' => 'alert alert-'.$type]) }}>
    {{ $message }}
</div>
