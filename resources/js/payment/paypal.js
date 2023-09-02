import '../bootstrap'
import axios from "axios";

function getFields() {
    return $('#checkout-form').serializeArray().reduce((obj, item) => {
        obj[item.name] = item.value
        return obj
    }, {});
}

function isEmptyFields() {
    const fields = getFields()

    return Object.values(fields).some((val) => val.length < 1)
}

// Render the PayPal button into #paypal-button-container
paypal.Buttons({

    onInit: function (data, actions) {
        actions.disable()

        $('#checkout-form').change(() => {
            if (!isEmptyFields()) {
                actions.enable()
            }
        })
    },

    onClick: function (data, actions) {
        if (isEmptyFields()) {
            alert('Please fill the form')
            return;
        }
    },

    // Call your server to set up the transaction
    createOrder: function(data, actions) {
        return axios.post('/ajax/paypal/order/create', getFields()).then(function(res) {
            console.log(res.data)
            return res.data.vendor_order_id;
        });
    },

    // Call your server to finalize the transaction
    onApprove: function(data, actions) {
        return axios.post(`/ajax/paypal/order/${data.orderId}/capture`)
            .then(function(res) {
            return res.data;
        }).then(function(orderData) {
                console.log(orderData)
               iziToast.success({
                   title: "Payment process was completed",
                   position: 'topRight',
                   onCLousing: ()=> {
                       window.location.href = `order/${orderData.id}/paypal-thank-you`
                   }

               });
        })
            .catch(error => {
                var errorDetail = Array.isArray(error.details) && error.details[0];

                if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart(); // Recoverable state, per:
                    // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                }

                if (errorDetail) {
                    var msg = 'Sorry, your transaction could not be processed.';
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                    if (error.debug_id) msg += ' (' + error.debug_id + ')';
                    return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                }

                // Successful capture! For demo purposes:
                console.log('Capture result', error, JSON.stringify(error, null, 2));
                var transaction = error.purchase_units[0].payments.captures[0];
                alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
            });
    }
}).render('#paypal-button-container');
