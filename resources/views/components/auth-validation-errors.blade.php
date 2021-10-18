@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium" style="color: red;">
            {{ __('lang.validation_error_title') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm" style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ __($error) }}</li>
            @endforeach
        </ul>
    </div>
@endif
