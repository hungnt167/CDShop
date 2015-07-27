<style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: -1px;
        -webkit-border-radius: 0 6px 6px 6px;
        -moz-border-radius: 0 6px 6px;
        border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    .dropdown-submenu>a:after {
        display: block;
        content: " ";
        float: right;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        border-left-color: #ccc;
        margin-top: 5px;
        margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
        border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
        float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
        left: -100%;
        margin-left: 10px;
        -webkit-border-radius: 6px 0 6px 6px;
        -moz-border-radius: 6px 0 6px 6px;
        border-radius: 6px 0 6px 6px;
    }
</style>

<nav class="navbar navbar-default" style="background:#e7e7e7;margin-bottom: 0;" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url().'/home'}}">{{Lang::get('content.name page')}}</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                {!! $navigator !!}
            </ul>
            </li>
            </ul>
            <form action="{{action('FrontendController@search')}}" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                        {{--<input type="hidden" value="{{csrf_token()}}" name="_token">--}}
                        <input type="text" name="keyword" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">


                <li class="dropdown">
                    <?php $user =session('user.name') ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$user or 'Guest'}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @if(Session::has('user'))
                            <li><a href="{{action('FrontendController@viewInvoicePage')}}">View Invoice</a>
                            </li>
                            <li><a href="{{action('AuthController@getChangePassword')}}">Change password</a></li>
                            <li><a href="{{action('AuthController@getUpdatePaymentAddressCustomer')}}">Update Payment Address</a></li>
                            <li><a href="{{action('AuthController@getLogout')}}">Sign out</a></li>
                        @else
                        <li><a href="{{action('AuthController@getLogin')}}">Login</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{action('FrontendController@cart')}}"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>