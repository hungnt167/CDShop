<div id="payment-address" class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content"
               class="accordion-toggle">
                Step 2: Account &amp; Billing Details
            </a>
        </h2>
    </div>
    <div id="payment-address-content" class="panel-collapse collapse">
        <div class="panel-body row">
            <div class="col-md-6 col-sm-6">
                <h3>Your Personal Details</h3>

                <form action="{{action('AuthController@createCustomer')}}" method="post">
                    <input value="{{csrf_token()}}" name="_token" type="hidden"/>

                    <div class="form-group">
                        <label for="firstname">First Name <span class="require">*</span></label>
                        <input name="first_name" value="{{old('first_name')}}" type="text" id="firstname"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name <span class="require">*</span></label>
                        <input name="last_name" value="{{old('last_name')}}" type="text" id="lastname"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail <span class="require">*</span></label>
                        <input name="email" value="{{old('email')}}" type="text" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone <span class="require">*</span></label>
                        <input name="phone" value="{{old('phone')}}" type="tel" id="telephone" class="form-control">
                    </div>
                    <h3>User name</h3>

                    <div class="form-group">
                        <label for="name">User name <span class="require">*</span></label>
                        <input name="name" type="text" id="name" class="form-control">
                    </div>
                    <h3>Your Password</h3>

                    <div class="form-group">
                        <label for="password">Password <span class="require">*</span></label>
                        <input name="password" type="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Password Confirm <span class="require">*</span></label>
                        <input name="confirmpassword" type="password" id="password-confirm" class="form-control">
                    </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h3>Your Address</h3>


                <div class="form-group">
                    <label for="address1">Address 1</label>
                    <input name="address1" value="{{old('address1')}}" type="text" id="address1" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address2">Address 2</label>
                    <input name="address2" value="{{old('address2')}}" type="text" id="address2" class="form-control">
                </div>

                <div class="form-group">
                    <label for="country">City <span class="require">*</span></label>
                    <select name="city_id" value="{{old('city_id')}}" class="form-control input-sm" id="city_id">
                        @foreach($cities as $city)
                            <option value="{{$city['id']}}"> {{$city['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="region-state">Region/State <span class="require">*</span></label>
                    <select name="state_id" value="{{old('state_id')}}" class="form-control input-sm" id="state">
                        <option value=""> --- Please Select ---</option>
                        <option value="3513">Aberdeen</option>
                        <option value="3514">Aberdeenshire</option>
                        <option value="3515">Anglesey</option>
                    </select>
                </div>
                <div>
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="g-recaptcha" data-sitekey="6LdkCQoTAAAAALNT3hXvjB3fQXX9Rc1_zmyd4LyF"></div>
                </div>
            </div>

            <hr>
            <div class="col-md-12">

                <div class="checkbox">
                    <label>
                        <input name="check" type="checkbox" checked="checked"> My delivery and billing addresses are the
                        same.
                    </label>
                </div>
                <button class="btn btn-primary  pull-right" onclick="toggle('conf');" type="submit"
                        data-toggle="collapse"
                        data-parent="#checkout-page" data-target="#confirm-content"
                        id="button-confirm">Continue
                </button>
                <div class="checkbox pull-right">
                    <label>
                        <input type="checkbox"> I have read and agree to the <a title="Privacy Policy"
                                                                                href="#">Privacy Policy</a>
                        &nbsp;&nbsp;&nbsp;
                    </label>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>