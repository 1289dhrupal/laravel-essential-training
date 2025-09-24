{{-- create a select component that takes in the name of the input and its list of key value pairs --}}
@props(['name', 'options' => [], 'selected_value' => ''])
<select name="{{ $name }}"
    {{ $attributes->merge(['class' => 'w-full mt-6 p-2 border border-gray-300 rounded']) }}>
    <option value="">-- Select an option --</option>
    @foreach ($options as $key => $value)
        <option value="{{ $key }}" {{ $selected_value == $key ? 'selected' : '' }}>{{ $value }}</option>
    @endforeach
</select>
