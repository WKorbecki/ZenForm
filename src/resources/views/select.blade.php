<select {!! $attributes !!}>
    @foreach($options as $value => $label)
        @if(is_array($label))
            @include('zenform::select.optgroup', ['group' => $value, 'groupOptions' => $label])
        @else
            @include('zenform::select.option', ['value' => $value, 'label' => $label])
        @endif
    @endforeach
</select>