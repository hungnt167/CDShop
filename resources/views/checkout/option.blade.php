<div id="checkout" class="panel panel-info">
    <div class="panel-heading">
        <a data-toggle="collapse" data-parent="#checkout-page" href="#checkout-content"
           class="accordion-toggle">
            <h2 class="panel-title">

                Step 1: Checkout Options

            </h2>
        </a>
    </div>
    <div id="checkout-content" class="panel-collapse collapse">
        <div class="panel-body row">
            <div class="col-md-6 col-sm-6">
                <h3>New Customer</h3>

                <p>Checkout Options:</p>

                <form action="{{action('FrontendController@selectOptionCheckout')}}" method="post">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                    <div class="radio-list">
                        <label>
                            <input type="radio" name="account" value="register"> Register Account
                        </label>
                        <label>
                            <input type="radio" name="account" value="guest"> Guest Checkout
                        </label>
                    </div>
                    <p>By creating an account you will be able to shop faster, be up to date on an order's
                        status, and keep track of the orders you have previously made.</p>
                    <button class="btn btn-primary" onclick="toggle('opt')"  type="submit" data-toggle="collapse"
                            data-parent="#checkout-page" data-target="#payment-address-content">Continue
                    </button>
                </form>
            </div>
            <div class="col-md-6 col-sm-6">
                <h3>Returning Customer</h3>

                <p>I am a returning customer.</p>

                <form action="{{action('AuthController@postLogin')}}" method="POST" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">User name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password-login">Password</label>
                        <input name="password" type="password" id="password-login" class="form-control">
                    </div>
                    <a href="#">Forgotten Password?</a>

                    <div class="padding-top-20">
                        <button class="btn btn-primary" onclick="toggle('opt')" type="submit">Login</button>
                    </div>
                    <hr>
                    <div class="login-socio">
                        <p class="text-muted">or login using:</p>
                        {{--<ul class="social-icons">--}}
                        {{--<li><a href="#" data-original-title="facebook" class="facebook"--}}
                        {{--title="facebook"></a></li>--}}
                        {{--<li><a href="#" data-original-title="Twitter" class="twitter"--}}
                        {{--title="Twitter"></a></li>--}}
                        {{--<li><a href="#" data-original-title="Google Plus" class="googleplus"--}}
                        {{--title="Google Plus"></a></li>--}}
                        {{--<li><a href="#" data-original-title="Linkedin" class="linkedin"--}}
                        {{--title="LinkedIn"></a></li>--}}
                        {{--</ul>--}}
                    </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>