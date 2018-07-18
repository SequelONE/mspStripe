<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('[[+publishable_key]]');
    var form;
    jQuery(function($) {
        var pmRadio = $('input[name=paymentMethod]');
        form = pmRadio.parents('form');
        form.on('submit', function(event) {
            var $form = $(this),
                    method = pmRadio.filter(':checked').val();
            if (method == [[+method_id]]) {
                // Disable the submit button to prevent repeated clicks
                $form.find('button').attr('disabled', true);
                Stripe.card.createToken(form, stripeResponseHandler);
                // Prevent the form from submitting with the default action
                return false;
            }
            return true;
        });
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            // Show the errors on the form
            form.find('.payment-errors').text(response.error.message);
            form.find('button').attr('disabled', false);
        } else {
            // response contains id and card, which contains additional card details
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // and submit
            form.get(0).submit();
        }
    };
</script>