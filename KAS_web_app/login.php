<!DOCTYPE html>
<html>
<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
include('inc/config.php');
if (!empty($_GET['USR'])) {
	$USR = $_GET['USR'];
}
if (!empty($_GET['PWD'])) {
	$PWD = $_GET['PWD'];
}
?>
    <head>
        <title><?=$slogan?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta name="description" content="<?=$desc?>" />
        <link rel="shortcut icon" href="favicon.png" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" />
        <link type="text/css" rel="stylesheet" href="css/mint-admin.css" />
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/mint-admin.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
        <style> #login { display: none; } </style>
    </head>
    <body class="splash">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4" id="login">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-sun-o fa-spin fa-lg"></i>&nbsp;<span><?=$system_name?></span></h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="check.php?lang=<?=$lang?>">
                                <fieldset>
                                    <div class="form-group input-group">
									    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <?php
                            if ((!empty($USR)) && ($USR != "USR")) {
								echo "<input type=\"text\" id=\"username\" class=\"form-control required\" name=\"username\"
								          placeholder=\"".get_lang($lang,'k05')."\" value=\"".$USR."\" autofocus>";
                            } else {
								echo "<input type=\"text\" id=\"username\" class=\"form-control required\" name=\"username\"
								          placeholder=\"".get_lang($lang,'k05')."\" value=\"\">";
							}
                        ?>
                                    </div>
                                    <div class="form-group input-group">
									    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <?php
                            if ((!empty($PWD)) && ($PWD != "0000") && ($PWD != "PASSWORD") && ($PWD != "PASSWD")) {
	                            echo "<input type=\"password\" id=\"password\" class=\"form-control required passwf\" name=\"password\"
								          placeholder=\"".get_lang($lang,'k06')."\" value=\"".$PWD."\">";
                            } else {
								echo "<input type=\"password\" id=\"password\" class=\"form-control required passwf\" name=\"password\"
								          placeholder=\"".get_lang($lang,'k06')."\" value=\"\">";
							}
                        ?>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me"><?php echo get_lang($lang,'k01'); ?>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">
									    <i class="fa fa-unlock"></i> <?php echo get_lang($lang,'k02'); ?></button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
   			    $('#login').slideDown(3000, 'easeOutBounce', function() {});
                //$('#login').slideDown(1000);
                /*
                $('#login').animate({ borderSpacing: -360 },{
                    step: function(now,fx) {
                        $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                        $(this).css('-moz-transform','rotate('+now+'deg)');
                        $(this).css('transform','rotate('+now+'deg)');
                    }, duration:500
                },'linear');*/
            });
        </script>
    </body>
</html>