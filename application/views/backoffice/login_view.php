<h1>{title}</h1>

<form action="<?php echo get_route_authenticate()?>" method="POST">

<input type="text" name="user" placeholder="{user}"/><br>
<input type="password" name="password" /><br>
<input type="submit" value="{submit}" />

</form>