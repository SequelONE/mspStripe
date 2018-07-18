<div class="sc-stripe-gateway">

    <span class="payment-errors"></span>

    <div class="form-row">
        <label>
            <span>Card Number</span>
            <input type="text" size="20" data-stripe="number"/>
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>CVC</span>
            <input type="text" size="4" data-stripe="cvc"/>
        </label>
    </div>

    <div class="form-row">
        <label>
            <span>Expiration (MM/YYYY)</span>
            <input type="text" size="2" data-stripe="exp-month"/>
        </label>
        <span> / </span>
        <input type="text" size="4" data-stripe="exp-year"/>
    </div>
</div>