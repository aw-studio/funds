<div
    {{ $attributes->merge([]) }}
    x-data="stripeElements($data)"
>
    <div id="payment-element">
        <!-- Elements will create form elements here -->
    </div>

    <div
        id="error-message"
        class="text-red-500"
    >
        <!-- Display error message to your customers here -->
    </div>
    @pushOnce('scripts')
        <script src="https://js.stripe.com/v3/"></script>
    @endPushOnce
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('stripeElements', ($data) => ({
                stripe: null,
                elements: null,
                supportedDonationTypes: @js($supportedDonationTypes),

                init() {
                    this.stripe = Stripe(@js($publishableKey));
                    this.elements = this.initStripeElements();

                    this.$watch('amount', (value) => {
                        this.updateStripeElements(value);
                    })

                    this.registerFormSubmitListener()
                },

                initStripeElements() {
                    const options = {
                        mode: 'payment',
                        amount: this.amount,
                        currency: 'eur',
                        paymentMethodCreation: 'manual',
                        appearance: {},
                    };

                    // Set up Stripe.js and Elements to use in checkout form
                    const elements = this.stripe.elements(options);
                    // Create and mount the Payment Element
                    const paymentElement = elements.create('payment');
                    paymentElement.mount('#payment-element');
                    return elements;
                },

                updateStripeElements(amount) {
                    // Create and mount the Payment Element
                    const paymentElement = this.elements.getElement('payment');

                    paymentElement.update({
                        amount: amount
                    });
                },


                registerFormSubmitListener() {
                    // could be a ref
                    const form = document.getElementById('payment-element').closest('form');

                    form.addEventListener('submit', async (event) => {
                        if (this.submitEnabled === false) {
                            return;
                        }

                        if (this.shouldTakeOverFormSubmission() == false) {
                            return;
                        }

                        event.preventDefault();

                        this.submitEnabled = false;
                        this.submitStripeCheckoutForm(form);
                    });
                },

                shouldTakeOverFormSubmission() {
                    return this.supportedDonationTypes.includes(this.type);
                },


                async submitStripeCheckoutForm(form) {
                    const formData = new FormData(form);

                    let confirmationToken = await this.getConfirmationToken();
                    formData.append('confirmation_token', confirmationToken.id);

                    const res = await fetch(form.action, {
                        method: form.method,
                        headers: {
                            'accept': 'application/json',
                            'X-CSRF-TOKEN': formData.get('_token'),
                        },
                        body: formData
                    });

                    const data = await res.json();

                    if (res.status === 500) {
                        this.handleError(data);
                        return;
                    }
                    // Handle any next actions or errors. See the Handle any next actions step for implementation.
                    this.handleServerResponse(data);
                },

                async getConfirmationToken() {
                    const {
                        error: submitError
                    } = await this.elements.submit();

                    if (submitError) {
                        this.handleError(submitError);
                        return;
                    }

                    // Create the ConfirmationToken using the details collected by the Payment Element
                    // and additional shipping information
                    const {
                        error,
                        confirmationToken
                    } = await this.stripe.createConfirmationToken({
                        elements: this.elements,
                        params: {}
                    });

                    if (error) {
                        // This point is only reached if there's an immediate error when
                        // creating the ConfirmationToken. Show the error to your customer (for example, payment details incomplete)
                        this.handleError(error);
                        return;
                    }

                    return confirmationToken
                },

                async handleServerResponse(response) {

                    this.resetErrorMessages();

                    // Handle validation errors
                    if (response.errors) {
                        this.handleErrors(response.errors);
                        return;
                    }

                    if (response.error) {
                        this.handleError(response.error);
                        return
                    }

                    if (response.status === 'requires_action') {
                        const {
                            error,
                            paymentIntent
                        } = await this.stripe.handleNextAction({
                            clientSecret: response.client_secret,
                        });

                        if (error) {
                            this.handleError(error);
                            return null;
                        };

                    }
                    if (!response.return_url) {
                        console.error('No return url provided in response');
                        return;
                    }

                    return this.redirectToSuccess(response.return_url);
                },

                redirectToSuccess(url) {
                    window.location.href = url
                },

                resetErrorMessages() {
                    const messageContainer = document.querySelector('#error-message');
                    messageContainer.innerHTML = '';
                },

                handleErrors(errors) {
                    const messageContainer = document.querySelector('#error-message');

                    for (let field in errors) {
                        let errorMessage = errors[field][0];
                        let errorElement = document.createElement('p');
                        errorElement.textContent = errorMessage;
                        messageContainer.appendChild(errorElement);
                    }

                    this.submitEnabled = true;
                },

                handleError(error) {
                    const messageContainer = document.querySelector('#error-message');
                    messageContainer.textContent = error.message;
                    this.submitEnabled = true;
                }

            }))
        })
    </script>
</div>
