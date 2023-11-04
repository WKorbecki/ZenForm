<optgroup label="{{ $group }}">
    @foreach($groupOptions as $groupOptionValue => $groupOptionLabel)
        @include('zenform::select.option', ['value' => $groupOptionValue, 'label' => $groupOptionLabel])
    @endforeach
</optgroup>