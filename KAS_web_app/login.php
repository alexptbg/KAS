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
$inside = array("AR_0001_2015_1.0","AR_0002_2015_1.0","AR_0003_2015_1.0","AR_0004_2015_1.0","AR_0005_2015_1.0");
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
        <link type="text/css" rel="stylesheet" href="css/weather.css" />
        <link type="text/css" rel="stylesheet" href="css/iconmoon.min.css" />
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/mint-admin.js"></script>
		<script type="text/javascript" src="js/weather.js"></script>
		<script type="text/javascript" src="js/skycons.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript">
        function get_live_out() {
	        setInterval(function () {
			    $.ajax({
				    url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0', 
				    success: function(point) {
				        y = eval(point);
			            $("div.nowl").html('<span><small><?php echo get_lang($lang,'k62'); ?></small></span><p>'+y[1].toFixed(1)+'ºC</p>');
			            $("div.now2").html('<small>'+y[3]+'</small>');
			        },
				    cache: false
			    });
	        },10000);
	    }
        $(function() {
			$.ajax({
				url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0',
				success: function(point) {
					y = eval(point);
			        $("div.nowl").html('<span><small><?php echo get_lang($lang,'k62'); ?></small></span><p>'+y[1].toFixed(1)+'ºC</p>');
			        $("div.now2").html('<small>'+y[3]+'</small>');
			    },
				cache: false
			});
	        get_live_out();
            //get weather
	        $.simpleWeather({
		        //zipcode: 'BUXX0015',
		        woeid: '836607',//gotse delchev
		        unit: 'c',
		        success: function(weather) {
			        low = weather.low-3;
			        high = weather.high-1;
			             if (weather.code == 26) { var condition = Skycons.CLOUDY; var prog = "<?php echo get_lang($lang,'k254'); ?>"; }
			        else if (weather.code == 27) { var condition = Skycons.PARTLY_CLOUDY_NIGHT; var prog = "<?php echo get_lang($lang,'k254'); ?>"; }
			        else if (weather.code == 28) { var condition = Skycons.PARTLY_CLOUDY_DAY; var prog = "<?php echo get_lang($lang,'k254'); ?>"; }
			        else if (weather.code == 29) { var condition = Skycons.PARTLY_CLOUDY_NIGHT; var prog = "<?php echo get_lang($lang,'k255'); ?>"; }
			        else if (weather.code == 30) { var condition = Skycons.PARTLY_CLOUDY_DAY; var prog = "<?php echo get_lang($lang,'k255'); ?>"; }
			        else if (weather.code == 31) { var condition = Skycons.CLEAR_NIGHT; var prog = "<?php echo get_lang($lang,'k256'); ?>"; }
			        else if (weather.code == 32) { var condition = Skycons.CLEAR_DAY; var prog = "<?php echo get_lang($lang,'k256'); ?>"; }
			        else if (weather.code == 11) { var condition = Skycons.RAIN; var prog = "<?php echo get_lang($lang,'k257'); ?>"; }//test
			        else if (weather.code == 12) { var condition = Skycons.RAIN; var prog = "<?php echo get_lang($lang,'k257'); ?>"; }//test
			        else if (weather.code == 18) { var condition = Skycons.SLEET; var prog = "<?php echo get_lang($lang,'k258'); ?>"; }
			        else if (weather.code == 16) { var condition = Skycons.SNOW; var prog = "<?php echo get_lang($lang,'k259'); ?>"; }
			        else if (weather.code == 24) { var condition = Skycons.WIND; var prog = "<?php echo get_lang($lang,'k260'); ?>"; }
			        else if (weather.code == 20) { var condition = Skycons.FOG; var prog = "<?php echo get_lang($lang,'k261'); ?>" }
			        else if (weather.code == 42) { var condition = Skycons.SNOW; var prog = "<?php echo get_lang($lang,'k262'); ?>" }
			        else if (weather.code == 14) { var condition = Skycons.SNOW; var prog = "<?php echo get_lang($lang,'k262'); ?>" }
			        now = weather.temp+' &deg;'+weather.units.temp;
			        $("span.wil").html('<span class="wl icon-'+weather.code+'"></span>');
			        //$("div.nowl").html('<span><small><?php echo get_lang($lang,'k62'); ?></small></span><p>'+now1+'</p>');
			        html = '<p><strong><?php echo get_lang($lang,'k249'); ?>: </strong><span>'+high+' &deg;'+weather.units.temp+'</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k250'); ?>: </strong><span>'+low+' &deg;'+weather.units.temp+'</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k251'); ?>: </strong><span>'+weather.humidity+' %</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k252'); ?>: </strong><span>'+weather.pressure+' mb</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k253'); ?>: </strong><span>'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</span><br/>';
			        //html += '<span>'+weather.code+'</span><br/>';
			        html += '<span><strong>'+prog+'</strong></span></p>';
			        $("#weatherl").html(html);
			        var v=new Skycons({"color": "#FFFFFF","resizeClear": true});v.add("icon",condition);v.play();
		        },
		        cache: false,
		        error: function(error) { $("#weatherl").html('<p>'+error+'</p>'); }
	        });
        });
        </script>
    </head>
    <body class="splash">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4" id="login">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-sun-o fa-spin fa-lg"></i>&nbsp;<span><?=$system_name?></span></h3>
                        </div>
                        <div class="extend">
                            <div class="panel-body wet-ashpalt">
							    <span style="text-transform:uppercase;text-decoration:underline;font-size:16px;">
							        <?php echo get_lang($lang,'k63');?>&nbsp;-&nbsp;<?php echo get_lang($lang,'k64');?></span>
							    <span class="wil"></span>
							    <div class="nowl"></div>
							    <div class="now2"></div>
                                <div id="weatherl" style="height:100px !important;"></div>
                            </div>
                            <div class="panel-body nephritis">
                                <span style="text-transform:uppercase;text-decoration:underline;font-size:16px;"><?php echo get_lang($lang,'k195'); ?></span>
                                <i class="iconm-temperature-2 sz40l"></i>
								<div class="systeml" style="height:78px !important;">
		                        <?php
		                        $inside_devices = 0;
		                        foreach($inside as $ar) {
		                        	$inside_devices++;
		                        	echo "<div id=\"inside-".$inside_devices."\"></div>";
		                        }
		                        ?>
								</div>
                            </div>
                        </div>
                        <div class="panel-body wet-ashpalt">
                            <p style="text-transform:uppercase;text-decoration:underline;font-size:16px;"><?php echo get_lang($lang,'k248'); ?></p>
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
                                    <!--<div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me"><?php echo get_lang($lang,'k01'); ?>
                                        </label>
                                    </div>-->
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">
									    <i class="fa fa-unlock"></i> <?php echo get_lang($lang,'k02'); ?></button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
		$inside_devices = 0;
		foreach($inside as $ar) {
			$inside_devices++;
			$timerz = $inside_devices+14;
			echo "
		<script type=\"text/javascript\">
        function get_live_in_s".$inside_devices."() {
	        setInterval(function () {
			    $.ajax({
				    url: \"ar_in_temp_now.php?ar_id=".$ar."\", 
				    success: function(point) {
				        y = eval(point);
				        if (y != null) {
				        	if (y[1] != \"Error\") {
				                html = \"<p><span><strong>\"+y[1]+\"</strong>: </span>\";
				                html += \"<span>\"+y[2].toFixed(1)+\" ºC - </span>\";
				                html += \"<span>\"+y[3]+\" %</span></p>\";
				            } else {
								html = \"<p><span>\"+y[1]+\": </span>\";
								html += \"<span>\"+y[2]+\"</span></p>\";
							}
							$(\"#inside-".$inside_devices."\").html(html);
				        }
			        },
				    cache: false,
				    error: function(error) { $(\"#inside-".$inside_devices."\").html(\"<p>\"+error+\"</p>\"); }
			    });
	        },".$timerz."000);
	    }
	    $(function() {
			$.ajax({
			    url: \"ar_in_temp_now.php?ar_id=".$ar."\", 
			    success: function(point) {
				    y = eval(point);
				    if (y != null) {
				    	if (y[1] != \"Error\") {
				            html = \"<p><span><strong>\"+y[1]+\"</strong>: </span>\";
				            html += \"<span>\"+y[2].toFixed(1)+\" ºC - </span>\";
				            html += \"<span>\"+y[3]+\" %</span></p>\";
				        } else {
							html = \"<p><span>\"+y[1]+\": </span>\";
							html += \"<span>\"+y[2]+\"</span></p>\";
						}
						$(\"#inside-".$inside_devices."\").html(html);
				    }
			    },
				cache: false,
				error: function(error) { $(\"#inside-".$inside_devices."\").html(\"<p>\"+error+\"</p>\"); }
			});
	        get_live_in_s".$inside_devices."();
	    });
		</script>";
		}
	    ?>
    </body>
</html>