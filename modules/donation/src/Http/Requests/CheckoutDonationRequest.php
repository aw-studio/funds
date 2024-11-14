<?php

namespace Funds\Donation\Http\Requests;

use Funds\Donation\Enums\DonationType;
use Funds\Foundation\Contracts\PaymentGatewayInterface;
use Funds\Foundation\Facades\Funds;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutDonationRequest extends FormRequest
{
    public PaymentGatewayInterface $paymentGateway;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->paymentGateway = Funds::payment()
            ->resolve(DonationType::tryFrom($this->input('donation_type')) ?? DonationType::OneTime);

        $rules = [
            'donation_type' => 'required',
            'amount' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'name' => ['required', 'string'],
            'pays_fees' => ['nullable', 'boolean'],
            'recipient_address' => ['nullable', 'array:'.implode(',', [
                'name',
                'street',
                'address_addition',
                'postal_code',
                'city',
                'country',
            ])],
        ];

        if ($this->route('reward') !== null) {
            $rules = array_merge($rules, [
                'shipping_name' => ['required', 'string'],
                'street' => ['required', 'string', 'min:5'],
                'address_addition' => ['nullable', 'string'],
                'postal_code' => ['required', 'string', 'min:4'],
                'city' => ['required', 'string', 'min:2'],
                'country' => ['required', 'string'],
            ]);

            if ($this->route('reward')->variants()->exists()) {
                $rules = array_merge($rules, [
                    'reward_variant' => ['required', 'exists:reward_variants,id'],
                ]);
            }
        }

        $receiptAddressRule = Rule::requiredIf(function () {
            return $this->input('requires_receipt') === true
                && $this->input('use_shipping_address_for_receipt') !== true;
        });

        $rules = array_merge($rules, [
            'requires_receipt' => ['nullable', 'boolean'],
            'use_shipping_address_for_receipt' => ['nullable', 'boolean'],
            'receipt_name' => [$receiptAddressRule, 'nullable', 'string'],
            'receipt_address' => [$receiptAddressRule,  'nullable', 'string'],
            'receipt_postal_code' => [$receiptAddressRule,  'nullable', 'string'],
            'receipt_city' => [$receiptAddressRule,  'nullable', 'string'],
            'receipt_country' => [$receiptAddressRule, 'nullable', 'string'],
        ]);

        return array_merge($rules, $this->paymentGateway::rules());
    }
}
