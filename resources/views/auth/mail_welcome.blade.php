<h1>Hi,You !</h1>

<p>We'd like to personally welcome you to TopMp3.</p>
<p>-----------------------------------------------</p>
    username: {{ $name }}
    password: {{ $password }}
<p>This is link active your Account:<a href="{{action('AuthController@doActive',['nameUser'=>$name,'keyActive'=>$key])}}">Active</a></p>
<hr/>
<p> Thank you for registering!</p>