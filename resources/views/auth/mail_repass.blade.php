<h1>Hi,You !</h1>

<p>We were reset your password.</p>
<p>....</p>
<p>-----------------------------------------------</p>
username: {{ $name }}
password: {{ $password }}
<p>Let Login:<a href="{{action('AuthController@getLogin')}}">Go</a></p>
<hr/>
<p> Thank you!</p>