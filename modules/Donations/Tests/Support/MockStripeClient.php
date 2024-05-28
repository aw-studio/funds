<?php

namespace Funds\Donations\Tests\Support;

use Illuminate\Support\Arr;
use Stripe\HttpClient\ClientInterface;

class MockStripeClient implements ClientInterface
{
    public $rbody = '{}';

    public $rcode = 200;

    public $rheaders = [];

    public function __construct()
    {
    }

    public function request($method, $absUrl, $headers, $params, $hasFile)
    {

        // Handle creating a Payment Intent
        if ($method == 'post' && $absUrl == 'https://api.stripe.com/v1/payment_intents') {
            $this->rbody = $this->getPaymentIntent();
        }

        return [$this->rbody, $this->rcode, $this->rheaders];
    }

    protected function getPaymentIntent($params = [])
    {
        return json_encode(array_merge([
            'id' => 'pi_'.str()->random(24),
            'object' => 'payment_intent',
            'amount' => 100,
            'amount_capturable' => 0,
            'amount_details' => [
                'tip' => [],
            ],
            'amount_received' => 0,
            'application' => null,
            'application_fee_amount' => null,
            'automatic_payment_methods' => [
                'allow_redirects' => 'always',
                'enabled' => true,
            ],
            'canceled_at' => null,
            'cancellation_reason' => null,
            'capture_method' => 'automatic_async',
            'client_secret' => 'pi_'.str()->random(12).'_secret_'.str()->random(24),
            'confirmation_method' => 'automatic',
            'created' => 1716548553,
            'currency' => 'eur',
            'customer' => null,
            'description' => null,
            'invoice' => null,
            'last_payment_error' => null,
            'latest_charge' => null,
            'livemode' => false,
            'metadata' => [],
            'next_action' => [
                'redirect_to_url' => [
                    'return_url' => 'http://funds.test/c/1/checkout/return',
                    'url' => 'https://pm-redirects.stripe.com/authorize/acct_1P5nHoHqkqlJSFXU/pa_nonce_QAGQ8ivsvUBN58x2U6jepcNpbEl56gK',
                ],
                'type' => 'redirect_to_url',
            ],
            'on_behalf_of' => null,
            'payment_method' => 'pm_1PJvtNHqkqlJSFXUn8CEDTr1',
            'payment_method_configuration_details' => [
                'id' => 'pmc_1P5nP5HqkqlJSFXUeWtzHvCT',
                'parent' => null,
            ],
            'payment_method_options' => [
                'card' => [
                    'installments' => null,
                    'mandate_options' => null,
                    'network' => null,
                    'request_three_d_secure' => 'automatic',
                ],
                'giropay' => [],
                'paypal' => [
                    'preferred_locale' => null,
                    'reference' => null,
                ],
                'sofort' => [
                    'preferred_language' => null,
                ],
            ],
            'payment_method_types' => [
                0 => 'card',
                1 => 'giropay',
                2 => 'sofort',
                3 => 'paypal',
            ],
            'processing' => null,
            'receipt_email' => null,
            'review' => null,
            'setup_future_usage' => null,
            'shipping' => null,
            'source' => null,
            'statement_descriptor' => null,
            'statement_descriptor_suffix' => null,
            'status' => 'requires_action',
            'transfer_data' => null,
            'transfer_group' => null,
        ], Arr::only($params, ['amount', 'currency'])));
    }
}
