<h1>{title}</h1>


<?php if (session_has_error_message()){?>

    <div class="container-fluid container-fixed-lg p-l-20 p-r-20">
        <div class="row">
            <div class="col-sm-8 col-md-6"><?php print_errors(session_get_error_message()); ?></div>
        </div>
    </div>
<?php }?>



<form action="<?php echo base_url(get_route_authenticate())?>" method="POST">

<input type="text" name="user" value="<?php echo $var_user ?>" placeholder="{user}"/><br>
<input type="password" name="password" /><br>
<input type="submit" value="{submit}" />

</form>