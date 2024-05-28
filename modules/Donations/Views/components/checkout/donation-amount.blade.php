@props(['reward' => null])
@php
    $defaulAmount = $reward ? $reward->min_amount->get() / 100 : 10;
@endphp
<x-input
    name="amount"
    type="number"
    placeholder="{{ __('Amount') }}"
    min="{{ $reward?->min_amount->get() / 100 }}"
    value="{{ old('amount') ?? $defaulAmount }}"
    required
/>
