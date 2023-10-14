// Set your Stripe public key
var stripe = Stripe('pk_test_51IIZhJHWljDTRHuTXfsx0qPNlbfiuDnqFYZOLOFHZ5oFaVgvTLr5AKEgl3gFfoNXoxE1vf2wFtNyhbjxjFU8FfIf00jHpAWNW4');
var elements = stripe.elements();

var style = {
    base: {
        fontSize: '16px',
        color: '#32325d',
    },
};

var card = elements.create('card', { style: style });
card.mount('#card-element');

card.on('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var form = document.getElementById('payment-form');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    stripe.createToken(card).then(function (result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Token is created. You can send this token to your server to process the payment.
            var token = result.token.id;
            document.getElementById('stripe_token').value=token;
            document.getElementById('payment-form').submit();

            // fetch('/process-payment', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //     },
            //     body: JSON.stringify({ token: token }),
            // })
            // .then(function (response) {
            //     return response.json();
            // })
            // .then(function (data) {
            //     if (data.success) {
            //         // Payment was successful, you can redirect the user to a success page.
            //         window.location.href = '/success';
            //     } else {
            //         // Payment failed, you can redirect the user to an error page.
            //         // document.getElementById('stripe_token').value='new value';
            //         window.location.href = '/error';
            //     }
            // });
        }
    });
});
