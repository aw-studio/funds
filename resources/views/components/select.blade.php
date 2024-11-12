  @props(['label' => null])
  <div>
      @isset($label)
          <x-input-label
              :value="$label"
              :for="$attributes->get('id', $attributes->get('name'))"
              :required="$attributes->get('required', false)"
          />
      @endisset
      <select {{ $attributes->class(['w-full rounded-lg border-gray-300 text-gray-700']) }}>
          {{ $slot }}
      </select>
  </div>
