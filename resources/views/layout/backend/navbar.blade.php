<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{action('BackendController@index')}}">{{Lang::get('content.name page')}} Admin</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        <!-- /.dropdown -->

        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" target="#dropdown-user" href="#">
                <i class="fa fa-user fa-fw"></i>
                <?php
                    $user = Session::get('user')
                ?>
                {{$user['name'] or 'Guest'}}
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{action('AuthController@getChangePassword')}}"><i class="fa fa-gear fa-fw"></i> Change password</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{action('AuthController@getLogout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    @include('layout.backend.left_sidebar')
</nav>