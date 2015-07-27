<div id="payment-method" class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#checkout-page" href="#payment-method-content"
               class="accordion-toggle">
                Step 5: Payment Method
            </a>
        </h2>
    </div>
    <div id="payment-method-content" class="panel-collapse collapse">
        <div class="panel-body row">
            <div class="col-md-12">
                <p>Please select the preferred payment method to use on this order.</p>

                <form action="{{action('FrontendController@createPaymentMethod')}}" method="post">
                    <input value="{{csrf_token()}}" name="_token" type="hidden"/>

                    <div class="radio-list">
                        <label>
                            <input type="radio" name="payment_method" value="CashOnDelivery"> Cash On Delivery
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="delivery-payment-method">Add Comments About Your Order</label>
                        <textarea name="comment" id="delivery-payment-method" rows="8" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-primary  pull-right" type="submit" id="button-payment-method"
                            data-toggle="collapse" data-parent="#checkout-page" data-target="#confirm-content">
                        Continue
                    </button>
                    <div class="checkbox pull-right">
                        <label>
                            <input onclick="toggle('pay_add')" type="checkbox"> I have read and agree to the <a title="Terms & Conditions"
                                                                                    href="#">Terms &
                                Conditions </a> &nbsp;&nbsp;&nbsp;
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>