<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                {{var_dump(\Illuminate\Support\Facades\Session::get('user'))}}
                <div class="title">Access Deny!</div>
                <div class="panel panel-warning">
                	  <div class="panel-heading">
                			<h3 class="panel-title">Go to Homepage</h3>
                	  </div>
                	  <div class="panel-body">
                			{{--<a href="{{action('FrontendController@index')}}">Go</a>--}}
                	  </div>
                </div>
            </div>
        </div>
    </body>
</html>
