<option value="{{ $value }}" @selected($multiple ? in_array($value, $selected ?? []) : $value == $selected)>
    {{ $label }}
</option>