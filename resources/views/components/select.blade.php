  @props(['label' => null])
  @isset($label)
      <x-input-label
          :value="$label"
          :for="$attributes->get('id', $attributes->get('name'))"
          :required="$attributes->get('required', false)"
      />
  @endisset
  <select {{ $attributes->class(['mt-1 w-full rounded-lg border-gray-300 text-gray-700']) }}>
      {{ $slot }}
  </select>
