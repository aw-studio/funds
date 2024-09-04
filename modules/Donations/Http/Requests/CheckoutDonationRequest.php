<?php

namespace Funds\Donations\Http\Requests;

use Funds\Core\Contracts\PaymentGatewayInterface;
use Funds\Core\Facades\Funds;
use Funds\Donations\Enums\DonationType;
use Illuminate\Foundation\Http\FormRequest;

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
                'address',
                'address_addition',
                'postal_code',
                'city',
                'country',
            ])],
        ];

        if ($this->route('reward') !== null) {
            $rules = array_merge($rules, [
                'shipping_name' => ['required', 'string'],
                'address_addition' => ['nullable', 'string'],
                'address' => ['required', 'string', 'min:5'],
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

        return array_merge($rules, $this->paymentGateway::rules());
    }
}
