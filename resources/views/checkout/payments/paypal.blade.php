<style>
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }

    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 250px;
        }
    }
</style>
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id={{config('paypal.' . env('PAYPAL_MODE') . '.client_id')}}&currency={{config('paypal.currency')}}"></script>

@vite(['resources/js/payment/paypal.js'])
