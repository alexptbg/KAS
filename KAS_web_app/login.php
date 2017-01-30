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
$inside = array("AR_0001_2015_1.0","AR_0002_2015_1.0","AR_0003_2015_1.0","AR_0004_2015_1.0","AR_0005_2015_1.0","AR_0006_2015_1.0");
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
        <link type="text/css" rel="stylesheet" href="css/iconmoon.min.css" />
        <link type="text/css" rel="stylesheet" href="css/ka-ex.css" /><!--icon ka-thermometer-->
        <link type="text/css" rel="stylesheet" href="css/weather.css" />
        <link type="text/css" rel="stylesheet" href="css/weather-icons.min.css" />
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/mint-admin.js"></script>
        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript">
        var wicon = {
          //day
          "01d": "wi-day-sunny",
          "02d": "wi-day-cloudy",
          "03d": "wi-cloud",
          "04d": "wi-cloudy",
          "09d": "wi-showers",
          "10d": "wi-rain",
          "11d": "wi-thunderstorm",
          "13d": "wi-snow",
          "50d": "wi-day-fog",
          //night
          "01n": "wi-night-clear",
          "02n": "wi-night-alt-cloudy",
          "03n": "wi-cloud",
          "04n": "wi-cloudy",
          "09n": "wi-showers",
          "10n": "wi-rain",
          "11n": "wi-thunderstorm",
          "13n": "wi-snow",
          "50n": "wi-night-fog"
        };
        function get_live_out() {
	        setInterval(function () {
			    $.ajax({
				    url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0', 
				    success: function(point) {
				        y = eval(point);
			            $("div.now2").html('<small>'+y[2]+'</small>');
			            $('td#temp').html(y[1].toFixed(1));
			        },
				    cache: false
			    });
	        },10000);
	    }
	    function get_weather() {
			setInterval(function () {
              $.ajax({
                url: '../weather/api.php',
                dataType: 'json',
                type: 'get',
                contentType: 'application/json',
                success: function(data,textStatus,jQxhr){
                  //console.log(data);
                  //alert(data[0].wdesc);
                  var sunrise = moment(data[0].wsunrise,"HH:mm:ss").format("HH:mm");
                  var sunset = moment(data[0].wsunset,"HH:mm:ss").format("HH:mm");
                  //$('.td-weather-city').text('Гоце Делчев');//data.name
                  $('td#condi').text(data[0].wdesc);
                  //$('p#temp').text(data.main.temp);
                  $('td#icond i.wi').addClass(wicon[data[0].wicon]);
                  $('h3#icond i.wi').addClass(wicon[data[0].wicon]);
                  //console.log(data[0].wicon);
                  //console.log(data.weather[0].icon);
                  $('td#min').text(data[0].wmin+'ºC');
                  $('td#max').text(data[0].wmax+'ºC');
                  $('td#hum').text(data[0].whum+'%');
                  $('td#wind').text(data[0].wwind+'км/ч');
                  $('td#nuv').text(data[0].wclouds+'%');
                  $('td#mb').text(data[0].wpress+'mb');
                  $('td#sunrise').text(sunrise);
                  $('td#sunset').text(sunset);
                },
                error: function(jqXhr,textStatus,errorThrown){
                  console.log(errorThrown);
                },
                type: 'GET',
                timeout: 5000,
                cache: false
              });
			},60000);
		}
        $(function() {
			$.ajax({
				url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0',
				success: function(point) {
					y = eval(point);
			        $("div.now2").html('<small>'+y[2]+'</small>');
			        $('td#temp').html(y[1].toFixed(1));
			    },
				cache: false
			});
	        get_live_out();
	        get_weather();
            //get weather
            $.ajax({
              url: '../weather/api.php',
              dataType: 'json',
              type: 'get',
              contentType: 'application/json',
              success: function(data,textStatus,jQxhr){
                //console.log(data);
                //alert(data[0].wdesc);
                var sunrise = moment(data[0].wsunrise,"HH:mm:ss").format("HH:mm");
                var sunset = moment(data[0].wsunset,"HH:mm:ss").format("HH:mm");
                //$('.td-weather-city').text('Гоце Делчев');//data.name
                $('td#condi').text(data[0].wdesc);
                //$('p#temp').text(data.main.temp);
                $('td#icond i.wi').addClass(wicon[data[0].wicon]);
                $('h3#icond i.wi').addClass(wicon[data[0].wicon]);
                //console.log(data[0].wicon);
                //console.log(data.weather[0].icon);
                $('td#min').text(data[0].wmin+'ºC');
                $('td#max').text(data[0].wmax+'ºC');
                $('td#hum').text(data[0].whum+'%');
                $('td#wind').text(data[0].wwind+'км/ч');
                $('td#nuv').text(data[0].wclouds+'%');
                $('td#mb').text(data[0].wpress+'mb');
                $('td#sunrise').text(sunrise);
                $('td#sunset').text(sunset);
              },
              error: function(jqXhr,textStatus,errorThrown){
                console.log(errorThrown);
              },
              type: 'GET',
              timeout: 5000,
              cache: false
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
                                <div id="weather">
                                    <table id="ext" style="margin-top: 0;">
                                        <tr><td id="icond" colspan="2" style="text-align: center;"><i class="wi"></i>&nbsp;</td></tr>
                                        <tr><td id="condi" colspan="2">&nbsp;</td></tr>
                                        <tr><td id="temp" colspan="2" style="text-align: center;">&nbsp;</td></tr>
                                    	<tr style="line-height: 12px;"><td id="min">&nbsp;</td><td id="max">&nbsp;</td></tr>
                                    	<tr style="line-height: 12px;"><td id="hum">&nbsp;</td><td id="wind">&nbsp;</td></tr>
                                    	<tr style="line-height: 12px;"><td id="nuv">&nbsp;</td><td id="mb">&nbsp;</td></tr>
                                    	<tr style="line-height: 12px;"><td id="sunrise">&nbsp;</td><td id="sunset">&nbsp;</td></tr>
                                    </table>
                                </div>
                                <div class="now2" style="text-align: center;font-size: 10px;"></div>
                            </div>
                            <div class="panel-body nephritis">
                                <span style="text-transform:uppercase;text-decoration:underline;font-size:16px;"><?php echo get_lang($lang,'k195'); ?></span>
                                <i class="iconm-temperature-2 sz40l"></i>
								<div class="systeml" style="height:95px !important;">
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
				                html += \"<span>\"+y[2].toFixed(1)+\" ºC</p>\";
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
				            html += \"<span>\"+y[2].toFixed(1)+\" ºC</p>\";
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