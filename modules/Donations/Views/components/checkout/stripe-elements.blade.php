<div {{ $attributes->merge([]) }}>
    <div id="payment-element">
        <!-- Elements will create form elements here -->
    </div>

    <div id="error-message">
        <!-- Display error message to your customers here -->
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // Load the publishable key from the server. The publishable key
            // is set in your .env file.
            const publishableKey = @js($publishableKey);
            const supportedDonationTypes = @js($supportedDonationTypes);
            const stripe = Stripe(publishableKey);

            // get amount from form input element named amount
            // of course this is crated from the server in the end, but some payment mehtods
            // do want to show the amount before the payment
            // TODO: how to update the amount?
            const amountInput = document.querySelector('input[name="amount"]');
            const amount = amountInput.value * 100;

            const options = {
                mode: 'payment',
                amount: amount,
                currency: 'eur',
                paymentMethodCreation: 'manual',
                appearance: {},
            };
            // Set up Stripe.js and Elements to use in checkout form
            const elements = stripe.elements(options);
            // Create and mount the Payment Element
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');
            const form = document.getElementById('payment-element').closest('form');
            const submitBtn = document.getElementById('submit');

            const handleError = (error) => {
                const messageContainer = document.querySelector('#error-message');
                messageContainer.textContent = error.message;
                submitBtn.disabled = false;
            }

            form.addEventListener('submit', async (event) => {
                const formData = new FormData(form);
                const donationType = formData.get('donation_type');
                if (!supportedDonationTypes.includes(donationType)) {
                    // Exit early if the donation type is not supported
                    // and let the system take over form submission
                    console.log('Donation type not supported by stripe gateway');
                    return;
                }
                event.preventDefault();
                // Prevent multiple form submissions
                if (submitBtn.disabled) {
                    return;
                }
                // Disable form submission while loading
                submitBtn.disabled = true;


                let confirmationToken = await getConfirmationToken();

                submitCheckoutForm(formData, confirmationToken);

            });

            const submitCheckoutForm = async (formData, confirmationToken) => {
                formData.append('confirmation_token', confirmationToken.id);

                const res = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token'),
                    },
                    body: formData
                });

                const data = await res.json();
                // Handle any next actions or errors. See the Handle any next actions step for implementation.
                handleServerResponse(data);
            }

            const getConfirmationToken = async () => {
                // Trigger form validation and wallet collection
                const {
                    error: submitError
                } = await elements.submit();
                if (submitError) {
                    handleError(submitError);
                    return;
                }
                // Create the ConfirmationToken using the details collected by the Payment Element
                // and additional shipping information
                const {
                    error,
                    confirmationToken
                } = await stripe.createConfirmationToken({
                    elements,
                    params: {}
                });

                if (error) {
                    // This point is only reached if there's an immediate error when
                    // creating the ConfirmationToken. Show the error to your customer (for example, payment details incomplete)
                    handleError(error);
                    return;
                }
                return confirmationToken
            }

            const handleServerResponse = async (response) => {
                console.log(response);

                if (response.error) {
                    handleError(response.error);
                    return
                }

                if (response.status === 'requires_action') {
                    return await handleStripeNextAction(
                        response.client_secret,
                        response.return_url,
                    );
                }

                return redirectToSuccess(response.return_url);
            };

            const handleStripeNextAction = async (clientSecret, returnUrl) => {
                const {
                    error,
                    paymentIntent
                } = await stripe.handleNextAction({
                    clientSecret
                });

                if (error) {
                    handleError(error);
                    return null;
                };

                return redirectToSuccess(returnUrl);
            };

            const redirectToSuccess = (url) => {
                window.location.href = url
            };
        });
    </script>
</div>
