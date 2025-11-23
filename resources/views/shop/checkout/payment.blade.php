@extends('layouts.app')

@section('title', 'Checkout - Payment')
@section('header', 'Checkout - Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                <div class="space-y-4">
                    @forelse($cartItems as $item)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <h3 class="font-medium">{{ $item->product->name ?? $item->name }}</h3>
                                <p class="text-gray-600 text-sm">Qty: {{ $item->quantity ?? $item->quantity }}</p>
                            </div>
                            <p class="font-medium">${{ number_format((($item->product ? $item->product->price : $item->price) * ($item->quantity ?? $item->quantity)) / 100, 2) }}</p>
                        </div>
                    @empty
                        <p class="text-center py-4 text-gray-600">No items in cart.</p>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Subtotal</span>
                        <span>${{ number_format($cartTotal / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Shipping</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Tax</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg pt-2 border-t">
                        <span>Total</span>
                        <span id="total-amount">${{ number_format($cartTotal / 100, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>

                <div class="mb-6">
                    <p class="font-medium">{{ $shippingInfo['first_name'] }} {{ $shippingInfo['last_name'] }}</p>
                    <p>{{ $shippingInfo['address'] }}</p>
                    <p>{{ $shippingInfo['city'] }}, {{ $shippingInfo['state'] }} {{ $shippingInfo['zipcode'] }}</p>
                    <p>{{ $shippingInfo['country'] }}</p>
                </div>

                <h2 class="text-xl font-semibold mb-4">Payment Method</h2>

                <form id="payment-form" method="POST" action="{{ route('checkout.process.payment') }}">
                    @csrf
                    <input type="hidden" id="payment-intent" name="payment_intent">

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input
                                type="radio"
                                id="cod"
                                name="payment_method"
                                value="cod"
                                required
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                checked
                            >
                            <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                                Cash on Delivery
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input
                                type="radio"
                                id="stripe"
                                name="payment_method"
                                value="stripe"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                            >
                            <label for="stripe" class="ml-3 block text-sm font-medium text-gray-700">
                                Credit Card (Stripe)
                            </label>
                        </div>

                        <!-- Stripe payment fields (initially hidden) - replaced with Stripe Elements -->
                        <div id="stripe-fields" class="hidden space-y-4 mt-4">
                            <!-- Stripe Elements will go here -->
                            <div id="card-element" class="mt-4">
                                <!-- A Stripe Element will be inserted here -->
                            </div>

                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert" class="text-red-600 text-sm mt-2"></div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('checkout.shipping') }}" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            &larr; Back to Shipping
                        </a>
                        <button id="submit-button" type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the Stripe publishable key from your config
    const stripe = Stripe('{{ config("cashier.key") }}');

    const stripeRadio = document.getElementById('stripe');
    const codRadio = document.getElementById('cod');
    const stripeFields = document.getElementById('stripe-fields');
    const paymentForm = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const cardElementContainer = document.getElementById('card-element');
    const cardErrors = document.getElementById('card-errors');
    const paymentIntentInput = document.getElementById('payment-intent');

    // Create an instance of Elements
    const elements = stripe.elements();

    // Custom styling can be passed to parameters when creating an Element
    const style = {
        base: {
            color: '#000',
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: 'rgba(0,0,0,0.5)',
            },
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a',
        },
    };

    // Create an instance of the card Element
    const card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` div
    card.mount(cardElementContainer);

    // Handle real-time validation errors from the card Element.
    card.on('change', function(event) {
        if (event.error) {
            cardErrors.textContent = event.error.message;
        } else {
            cardErrors.textContent = '';
        }
    });

    // Toggle Stripe fields visibility
    stripeRadio.addEventListener('change', function() {
        if (this.checked) {
            stripeFields.classList.remove('hidden');
        }
    });

    codRadio.addEventListener('change', function() {
        if (this.checked) {
            stripeFields.classList.add('hidden');
        }
    });

    // Handle form submission
    paymentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Get the payment method
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (paymentMethod === 'stripe') {
            // Disable the submit button to prevent multiple clicks
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';

            // Create a payment method
            stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: '{{ $shippingInfo['first_name'] . ' ' . $shippingInfo['last_name'] }}',
                    email: '{{ Auth::user()->email }}',
                    address: {
                        line1: '{{ $shippingInfo['address'] }}',
                        city: '{{ $shippingInfo['city'] }}',
                        state: '{{ $shippingInfo['state'] }}',
                        postal_code: '{{ $shippingInfo['zipcode'] }}',
                        country: '{{ $shippingInfo['country'] }}',
                    },
                },
            }).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error
                    cardErrors.textContent = result.error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Place Order';
                } else {
                    // Create payment intent from backend first
                    fetch('{{ route("checkout.create-payment-intent") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            amount: {{ $cartTotal }},
                            payment_method: result.paymentMethod.id
                        })
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.error) {
                            cardErrors.textContent = data.error;
                            submitButton.disabled = false;
                            submitButton.textContent = 'Place Order';
                        } else {
                            // Confirm the payment
                            stripe.confirmCardPayment(data.client_secret, {
                                payment_method: result.paymentMethod.id,
                            }).then(function(result) {
                                if (result.error) {
                                    // Show error to your customer
                                    cardErrors.textContent = result.error.message;
                                    submitButton.disabled = false;
                                    submitButton.textContent = 'Place Order';
                                } else {
                                    // The payment has been processed
                                    if (result.paymentIntent.status === 'succeeded') {
                                        // Set the payment intent ID in the form
                                        paymentIntentInput.value = result.paymentIntent.id;

                                        // Submit the form
                                        paymentForm.submit();
                                    }
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        cardErrors.textContent = 'An error occurred while processing your payment.';
                        submitButton.disabled = false;
                        submitButton.textContent = 'Place Order';
                    });
                }
            });
        } else {
            // For COD, just submit the form directly
            paymentForm.submit();
        }
    });
});
</script>
@endpush
@endsection