<!DOCTYPE html>
<html>
<?php
//error_reporting(0);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
if (!empty($_GET['SYS'])) { $SYS = $_GET['SYS']; } else { $SYS = ""; }
check_login($lang,$web_dir);
//index only
include('inc/moon.php');
//arduino inside temp controllers
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
        <link type="text/css" rel="stylesheet" href="css/ka-ex.css" /><!--icon ka-thermometer-->
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/mint-admin.js"></script>
		<script type="text/javascript" src="js/weather.js"></script>
		<script type="text/javascript" src="js/skycons.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
		<script type="text/javascript" src="js/ka-ex.js"></script>
		<script type="text/javascript">
        function get_live_out() {
	        setInterval(function () {
			    $.ajax({
				    url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0', 
				    //url: 'sa_temp_now.php',
				    success: function(point) {
				        y = eval(point);
			            $('h3#temp_now').text(y[1]+' ºC');
			            $('span#up').text(y[3]);
			            $("div#now2").html('<span><small><?php echo get_lang($lang,'k62'); ?></small></span><p>'+y[1].toFixed(1)+'ºC</p>');
			            $("div#now3").html('<small>'+y[3]+'</small>');
			        },
				    cache: false
			    });
	        },10000);
	    }
        $(function() {
			$.ajax({
				url: 'ar_out_temp_now.php?ar_id=AR_0007_2015_1.0',
				//url: 'sa_temp_now.php',
				success: function(point) {
					y = eval(point);
			        $('h3#temp_now').text(y[1]+' ºC');
			        $('span#up').text(y[3]);
			        $("div#now2").html('<span><small><?php echo get_lang($lang,'k62'); ?></small></span><p>'+y[1].toFixed(1)+'ºC</p>');
			        $("div#now3").html('<small>'+y[3]+'</small>');
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
			        $("span.wi").html('<span class="wl icon-'+weather.code+'"></span>');
			        html = '<p><strong><?php echo get_lang($lang,'k249'); ?>: </strong><span>'+high+' &deg;'+weather.units.temp+'</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k250'); ?>: </strong><span>'+low+' &deg;'+weather.units.temp+'</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k251'); ?>: </strong><span>'+weather.humidity+' %</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k252'); ?>: </strong><span>'+weather.pressure+' mb</span><br/>';
			        html += '<strong><?php echo get_lang($lang,'k253'); ?>: </strong><span>'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</span><br/>';
			        //html += '<span>'+weather.code+'</span><br/>';
			        html += '<span><strong>'+prog+'</strong></span></p>';
			        $("#weather").html(html);
			        var v=new Skycons({"color": "#FFFFFF","resizeClear": true});v.add("icon",condition);v.play();
		        },
		        cache: false,
		        error: function(error) { $("#weather").html('<p>'+error+'</p>'); }
	        });
            var isMobile = {
                Android: function() {
                    return navigator.userAgent.match(/Android/i);
                },
                BlackBerry: function() {
                    return navigator.userAgent.match(/BlackBerry/i);
                },
                iOS: function() {
                    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                },
                Opera: function() {
                    return navigator.userAgent.match(/Opera Mini/i);
                },
                Windows: function() {
                    return navigator.userAgent.match(/IEMobile/i);
                },
                any: function() {
                    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                }
            };
            //if(isMobile.iOS()) alert('iOS');
            if(!isMobile.any()){
	            $('.qrcode').css('display','block');
		    }
        });
        function showAndroidToast(toast) {
            Android.showToast(toast);
        }
        function showNotification(toast) {
            Android.Notify(toast);
        }
        //user-agent
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
        if(isAndroid) {
        	//TOAST
        	/*
            var f = function(){
                showNotification("Title,\r\nThis is a notification message!");
            }
            setInterval(f,30000);
            //NOTIFY
            setTimeout(function(){ showNotification("Title,\r\nThis is a notification message!"); },3000);
            */
        } else {
        	//do nothing for now
		}
        </script>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php?lang=<?=$lang?>">
					    <i class="fa fa-sun-o fa-fw fa-spin"></i>&nbsp;<?=$slogan?></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="index.php?lang=<?=$lang?>">
                            <i class="fa fa-dashboard fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li>
                        <a href="" id="refresh">
                            <i class="fa fa-refresh fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user  fa-2x fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php?lang=<?=$lang?>&SYS=<?=$SYS?>&USR=<?php echo $user_settings['user_name']; ?>">
							    <i class="fa fa-sign-out fa-fw"></i> <?php echo get_lang($lang, 'Logout'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar-static-top -->
            <?php @include($core); ?>
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
				    <span class="system_name"><?=$system_name?>&nbsp;<?=$version?></span>
                    <ul class="nav" id="side-menu">
                        <li>
                            <div class="user-info-wrapper">	
                                <div class="user-info-profile-image">
                                    <img src="img/avatar.png" alt="Avatar"  width="70" height="70" />
                                </div>
                                <div class="user-info">
                                    <div class="user-welcome"><?php echo get_lang($lang,'Hello'); ?>,</div>
                                    <div class="username"><?php echo $user_settings['first_name']; ?>&nbsp;<i class="fa fa-smile-o fa-lg" style="color:#f3ba0c"></i></div>
									<div class="status">
									    <span class="user"><?php echo $user_settings['user_name']; ?></span> 
									    <span class="level"><?php echo $user_settings['level']; ?></span>
									</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="index.php?lang=<?=$lang?>" class="active">
							    <i class="fa fa-dashboard fa-fw fa-3x"></i> <?php echo get_lang($lang, 'Home'); ?></a>
                        </li>
						<?php
						//air conditioners by user
						    //get all buildings/router access from user
                            $queryb = "SELECT `buildings` FROM `users` WHERE `user_name`='".$user_settings["user_name"]."'";
                            $resultb = mysql_query($queryb);
                            confirm_query($resultb);
                            if (mysql_num_rows($resultb) != 0) {
                                while($buildings_u = mysql_fetch_array($resultb)) {
		                            $buildings_list = $buildings_u['buildings'];
	                            }
	                            $buildings = explode(", ",$buildings_list);
                            }
							//klimas from users
                            $queryu = "SELECT `klimas` FROM `users` WHERE `user_name`='".$user_settings["user_name"]."'";
                            $resultu = mysql_query($queryu);
                            confirm_query($resultu);
                            if (mysql_num_rows($resultu) != 0) {
                                while($klimas_u = mysql_fetch_array($resultu)) {
		                            $klimas_list = $klimas_u['klimas'];
	                            }
	                            $klimas_u_all = explode(", ",$klimas_list);
                            }
                            if (!empty($buildings)) {
	                            foreach ($buildings as $building) {
									$klimas_all_list="";
                                    //klimas from database by router/building
                                    $query = "SELECT `inv` FROM `klimatiki` WHERE `router`='".$building."' ORDER BY `inv` ASC";
                                    $result = mysql_query($query);
                                    confirm_query($result);
                                    if (mysql_num_rows($result) != 0) {
						                while($klimas_all = mysql_fetch_array($result)) {
							                $klimas_all_list[] = $klimas_all['inv'];
					                    }
					                }
					                if (!empty($klimas_all_list)) {
					                	$z=0;
					                	foreach ($klimas_all_list as $klima) {
					                	    if (in_array($klima,$klimas_u_all)) { $z++; }
					                	}
						                echo "
                                             <li>
                                                 <a href=\"#\"><i class=\"fa fa-th fa-fw fa-3x\"></i>&nbsp;".$building."&nbsp;
                                                     <span class=\"kcount\">".$z."</span><span class=\"fa arrow\"></span></a>
							                     <ul class=\"nav nav-second-level\">";
						                foreach ($klimas_all_list as $klima) {
											if (in_array($klima,$klimas_u_all)) {
                                                echo "
                                             <li>
												 <a href=\"klima_i.php?lang=".$lang."&user=".$user_settings["user_name"]."&klima=".$klima."&r=".$building."\">
										             ".get_lang($lang, 'k68')." ".$klima."</a></li>";
											}
										}
										echo "</ul>";
										echo "</li>";
									}
							    }
						    }
						//all klimas by router //status for admins //all klimas by building//router
                        if ($user_settings['level'] > 10) {
						echo "
                        <li>
                            <a href=\"#\"><i class=\"fa fa-exclamation-circle fa-fw fa-3x\"></i> ".get_lang($lang, 'k90')."
							    <span class=\"fa arrow\"></span></a>";
                            $query = "SELECT `router_name` FROM `routers` ORDER BY `router_name` ASC";
                            $result = mysql_query($query);
                            confirm_query($result);
                            if (mysql_num_rows($result) != 0) {
								echo "<ul class=\"nav nav-second-level\">";
								while($routers = mysql_fetch_array($result)) {
									echo "
                                        <li><a href=\"status.php?lang=".$lang."&router=".$routers['router_name']."\">
										    ".$routers['router_name']."</a></li>";
								}
								echo "</ul>";
							}
                            echo "
                        </li>";
                        //all klimas by router by user //status for users
						} elseif ($user_settings['level'] == 10) {
                            //get routers by user
                            if (!empty($buildings)) {
						echo "
                        <li>
                            <a href=\"#\"><i class=\"fa fa-exclamation-circle fa-fw fa-3x\"></i> ".get_lang($lang, 'k90')."
							    <span class=\"fa arrow\"></span></a>";
							    echo "<ul class=\"nav nav-second-level\">";
	                            foreach ($buildings as $building) {
									echo "
                                        <li><a href=\"status.php?lang=".$lang."&router=".$building."\">
										    ".$building."</a></li>";
	                            }
	                    echo "
	                        </ul>
                        </li>";
	                        }
						}
                        //by addr
						if ($user_settings['level'] > 10) {
                            $query = "SELECT `addr` FROM `klimatiki` GROUP BY `addr` ORDER BY `addr` ASC";
                            $result = mysql_query($query);
                            confirm_query($result);
                            if (mysql_num_rows($result) != 0) {
								echo "
								<li>
                            <a href=\"override.php?lang=".$lang."\">
							    <i class=\"fa fa-legal fa-fw fa-3x\"></i> ".get_lang($lang, 'k126')."<span class=\"fa arrow\"></span></a>
								<ul class=\"nav nav-second-level\">";
								if ($user_settings['level'] > 10) {
									echo "
								        <li><a href=\"override_all.php?lang=".$lang."&addr=all\"><span style=\"color:red;\">
										    ".get_lang($lang, 'k128')." ".get_lang($lang, 'k10')."</span></a></li>";
								}
						        while($addrs = mysql_fetch_array($result)) {
									echo "
                                        <li><a href=\"override.php?lang=".$lang."&addr=".$addrs['addr']."\">
										    ".get_lang($lang, 'k10')." ".$addrs['addr']."</a></li>";
					            }
								echo "</ul></li>";
					        }
						}
						?>
                        <li>
                            <a href="vrf_plan.php?lang=<?=$lang?>">
							    <i class="fa fa-location-arrow fa-fw fa-3x"></i> <?php echo get_lang($lang, 'k130'); ?></a>
                        </li>
                        <li>
                            <a href="vrf_activity.php?lang=<?=$lang?>">
							    <i class="fa fa-pie-chart fa-fw fa-3x"></i> <?php echo get_lang($lang, 'k181'); ?></a>
                        </li>
                        <li>
                            <a href="vrf_errors.php?lang=<?=$lang?>">
							    <i class="fa fa-exclamation-triangle fa-fw fa-3x"></i> <?php echo get_lang($lang, 'k200'); ?></a>
                        </li>
						<?php if ($user_settings['level'] > 10): ?>
                        <li>
                            <a href="#"><i class="fa fa-cog fa-fw fa-3x"></i> <?php echo get_lang($lang, 'Settings'); ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
							    <?php if ($user_settings['level'] > 20): ?>
                                <li>
                                    <a href="routers.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k09'); ?></a>
                                </li>
                                <li>
                                    <a href="#"><?php echo get_lang($lang, 'k10'); ?>&nbsp;<span class="fa arrow"></span></a>
									<?php
                                        $query = "SELECT * FROM `routers` ORDER BY `router_name` ASC";
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        $num_rows = mysql_num_rows($result);
                                        if ($num_rows != 0) {
										    echo "<ul class=\"nav nav-third-level\">";
											while ($routerx = mysql_fetch_array($result)) {
												echo "<li class=\"\">
											          <a href=\"klimatiki.php?lang=".$lang."&id={$routerx['id']}&router={$routerx['router_name']}\">
											          ".$routerx['router_name']."&nbsp;&nbsp;<span class=\"kcount\">".count_klimas($routerx['router_name'])."</span></a></li>";
											}
											echo "</ul>";
										} else {
													//do nothing
										}
									?>
                                </li>
								<?php endif; ?>
                                <li>
                                    <a href="users.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k12'); ?></a>
                                </li>
								<?php if ($user_settings['level'] > 20): ?>
                                <li>
                                    <a href="logs.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k13'); ?></a>
                                </li>
                                <li>
                                    <a href="settings.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k11'); ?></a>
                                </li>
                                <li>
                                    <a href="license.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k209'); ?></a>
                                </li>
								<?php endif; ?>
                            </ul>
                        </li>
						<?php endif; ?>
                    </ul>
					<div class="copyrights">
					    <h5><?php echo $settings['copyrights']; ?></h5>
					    <h5>
					        <i class="fa fa-copyright"></i>&nbsp;2014&nbsp;|
					        <script type="text/javascript">document.write(new Date().getFullYear())</script>
					    </h5>
                        <h6><?php echo get_lang($lang,'k243')."&nbsp;".date("Y-m-d H:i:s",filemtime("index.php")); ?></h6>
					</div>
					<div class="qrcode">
					    <h5><?php echo get_lang($lang,'k241'); ?></h5>
					    <div class="qrimg"><img src="qrcode.php" /></div>
					</div>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos"><i class="fa fa-dashboard"></i>&nbsp;<?php echo get_lang($lang,'Home'); ?></h3>
                    </div>
                </div>
                <?php 
                
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body emerald tooltipx">
                                <a href="sa_chart.php?lang=<?=$lang?>" id="sa" class="fr" data-toggle="tooltip" data-placement="top" title="<?php echo get_lang($lang,'k205');?>">
                                    <i class="fa fa-area-chart fa-2x"></i></a>
                                <canvas id="icon" width="95" height="95" class="item-icon"></canvas>
                                <h3 id="temp_now"></h3>
								<span id="up"></span>
                            </div>
                            <div class="panel-footer">
                                <h5 class="hindex"><?php echo get_lang($lang,'k62');?>&nbsp;-&nbsp;<?php echo get_lang($lang,'k64');?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body peter-river">
							    <span class="wi"></span>
							    <div id="now2"></div>
							    <div id="now3"></div>
                                <div id="weather"></div>
                            </div>
                            <div class="panel-footer">
                                <h5 class="hindex"><?php echo get_lang($lang,'k63');?>&nbsp;-&nbsp;<?php echo get_lang($lang,'k64');?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body emerald tooltipx">
                                <i class="iconm-temperature-2 sz40"></i>
                                <a href="sa_in_chart.php?lang=<?=$lang?>" id="sa" class="fr" data-toggle="tooltip" data-placement="top" title="<?php echo get_lang($lang,'k206');?>">
                                    <i class="fa fa-area-chart fa-2x"></i></a>
								<div class="system">
		                        <?php
		                        $inside_devices = 0;
		                        foreach($inside as $ar) {
		                        	$inside_devices++;
		                        	echo "<div id=\"inside-".$inside_devices."\"></div>";
		                        }
		                        ?>
								</div>
                            </div>
                            <div class="panel-footer">
                                <h5 class="hindex"><?php echo get_lang($lang,'k195'); ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body peter-river">
                                <i class="iconm-calendar sz40"></i>
								<div class="time">
                                    <p><?php echo get_lang($lang,$day); ?></p>
					                <p><?php echo date('d').' '.get_lang($lang,$month); ?>,&nbsp;
									   <?php echo date('Y'); ?></p>
									<p id="ctime"></p>
									<p><?php $moon = new Moon(); echo $moon->phase_name(); ?></p>
									<p>
                                    <?php
                                    $moment = date("H");
                                    if ($moment >= "04" && $moment < "09") {
                                        echo get_lang($lang,'k189');
                                    }
                                    else if ($moment >= "09" && $moment < "12") {
                                        echo get_lang($lang,'k190');
                                    } 
                                    else if ($moment >= "12" && $moment < "18") {
                                        echo get_lang($lang,'k191');
                                    } 
                                    else if ($moment >= "18" && $moment < "21") {
                                        echo get_lang($lang,'k192');
                                    } 
                                    else if ($moment >= "21" && $moment < "00") {
                                        echo get_lang($lang,'k193');
                                    }
                                    else {
                                        echo get_lang($lang,'k194');
									}
                                    ?>
									</p>
								</div>
                            </div>
                            <div class="panel-footer">
                                <h5 class="hindex"><?php echo get_lang($lang,'k66'); ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    //another warnings
                    /*
                        echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang,'k152')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-danger\">Климатици са в ремонт. не пипай...</div>
                            </div>
                        </div>
                    </div>
				</div>";
				*/
                    /*
                        echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang, 'k152')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-danger\">Климатици 07, 11, и 13 в момента не работи. Фирма от София ще доиде да ги оправи.</div>
                            </div>
                        </div>
                    </div>
				</div>";
				    */
				    //warning for windows/temperature Limit
				    /*
					$sa_temp = get_temp_from_sa();
					if ($sa_temp > 26) {
                        echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang, 'k152')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-danger\">".get_lang($lang, 'k165')."</div>
                            </div>
                        </div>
                    </div>
				</div>";
					}
					*/
				    //time schedule check for all routers
				    /*
                    $queryi = "SELECT `buildings` FROM `users` WHERE `user_name`='".$user_settings["user_name"]."'";
                    $resulti = mysql_query($queryi);
                    confirm_query($resulti);
                    if (mysql_num_rows($resulti) != 0) {
                        while($buildings_l = mysql_fetch_array($resulti)) {
		                    $buildings_list2 = $buildings_l['buildings'];
	                    }
	                    $buildings2 = explode(", ",$buildings_list2);
                    }
                    if (!empty($buildings2)) {
	                    foreach ($buildings2 as $building1) {
                            $querya = "SELECT `work_sche` FROM `routers` WHERE `router_name`='".$building1."'";
                            $resulta = mysql_query($querya);
                            confirm_query($resulta);
                            if (mysql_num_rows($resulta) != 0) {
                                while($works = mysql_fetch_array($resulta)) {
		                            $work_sche = $works['work_sche'];
	                            }
	                            if ($work_sche == "Off") { 
                                    echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang, 'k152')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-danger\">".get_lang($lang, 'k151')." ".$building1.".</div>
                            </div>
                        </div>
                    </div>
				</div>";
						        } 
                            }
					    }
					}
					*/
                ?>
                
                <!--
                <div class="row">
                    <?php include('inc/tables.php'); ?>
                    <script type="text/javascript">
                        $(function() {
 	                        $('#data').load('k_u.php?lang=<?=$lang?>&user=<?=$user_settings["user_name"]?>&router=Strellson/Joop&x=');
                            var refreshId = setInterval(function() {
                                    $('#data').load('k_u.php?lang=<?=$lang?>&user=<?=$user_settings["user_name"]?>&router=Strellson/Joop&x='+ Math.random());
                            }, 15000);
                            /*$.ajaxSetup({ cache: false });*/
                        });
                    </script>
                    <div id="data"></div>
                </div>
                
                <div class="row">
                    <script type="text/javascript">
                        $(function() {
 	                        $('#data2').load('k_u.php?lang=<?=$lang?>&user=<?=$user_settings["user_name"]?>&router=Boss&x=');
                            var refreshId = setInterval(function() {
                                    $('#data2').load('k_u.php?lang=<?=$lang?>&user=<?=$user_settings["user_name"]?>&router=Boss&x='+ Math.random());
                            }, 15000);
                            /*$.ajaxSetup({ cache: false });*/
                        });
                    </script>
                    <div id="data2"></div>
                </div>
                -->
                
                <?php
                            if (!empty($buildings)) {
                            	$y=count($buildings);
	                            if ($y == 1) {
									$div = "col-lg-12";
								} elseif ($y == 2) {
									$div = "col-xs-12 col-sm-6 col-md-6";
								}
				echo "
				<div class=\"row\">
				";
	                            foreach ($buildings as $building) {
                                    echo "
                    <div class=\"".$div."\">
                      <a href=\"klima_l.php?lang=".$lang."&user=".$user_settings["user_name"]."&router=".$building."\" class=\"no_underline\">
                        <div class=\"panel panel-primary text-center panel-eyecandy\">
                            <div class=\"panel-body peter-river bindex\">
								<h1><i class=\"icon ka-modem fa-3x\"></i></h1>
                            </div>
                            <div class=\"panel-footer\">
                                <h4 class=\"hindex\">".$building."</h4>
                            </div>
                        </div>
                      </a>
                    </div>
                                    ";
	                            }
	                        }
                echo "
                </div>
                ";
                ?>
            </div>
        </div>
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
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
				                html = \"<p><span>\"+y[1]+\": </span>\";
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
				            html = \"<p><span>\"+y[1]+\": </span>\";
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