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
check_login($lang,$web_dir);
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
		
		<script type="text/javascript" src="js/ka-ex.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		
        <script type="text/javascript" src="js/plugins/hcharts/highstock.js"></script>
        <script type="text/javascript" src="js/plugins/hcharts/highcharts-more.js"></script>
        <script type="text/javascript" src="js/plugins/hcharts/unica.js"></script>
        <script type="text/javascript" src="js/plugins/hcharts/highcharts.<?=$lang?>.js"></script>
        <script type="text/javascript" src="js/plugins/hcharts/exporting.js"></script>
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
                        <a href="" id="goback" onClick="javascript: history.go(-1); return false;">
                            <i class="fa fa-arrow-left fa-2x fa-fw"></i>
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
                            <li><a href="logout.php?lang=<?=$lang?>&SYS=KAS&USR=<?php echo $user_settings['user_name']; ?>">
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
						                echo "
                                             <li>
                                                 <a href=\"#\"><i class=\"fa fa-th fa-fw fa-3x\"></i> ".$building."<span class=\"fa arrow\"></span></a>
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
						//all klimas by router
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
											          ".$routerx['router_name']."</a></li>";
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
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos"><i class="fa fa-history"></i> <?php echo get_lang($lang, 'k166'); ?></h3>
                    </div>
                </div>
				
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k195')." - ".get_lang($lang,'k196')." 5 ".get_lang($lang,'k197'); ?>
							</div>
                            <div class="panel-body" style="margin:4px 5px 10px 5px;padding:0;">
                                <script type="text/javascript">
	                            Highcharts.setOptions({
		                            global : { useUTC: false }
	                            });
                                $(function () {
	                                $.getJSON('ar_in_data_history_5m.php?lang=<?=$lang?>', function(data) {
		                                $('#ichart').highcharts('StockChart', {
		                                    chart: {
				                                spacingTop: 10,
				                                spacingBottom: 10,
				                                marginBottom: 50,
                                                animation: {
                                                    duration: 2000,
                                                    easing: 'easeOutBounce'
                                                }
		                                    },
                                            rangeSelector: {
                                                buttons: [{
                                                    type: 'hour',
                                                    count: 8,
                                                    text: '8H'
			                                    }, {
                                                    type: 'day',
                                                    count: 1,
                                                    text: '1D'
                                                }, {
                                                    type: 'day',
                                                    count: 2,
                                                    text: '2D'
                                                }, {
                                                    type: 'day',
                                                    count: 3,
                                                    text: '3D'
                                                }, {
                                                    type: 'day',
                                                    count: 7,
                                                    text: '7D'
                                                }, {
                                                    type: 'day',
                                                    count: 15,
                                                    text: '15D'
                                                }, {
                                                    type: 'month',
                                                    count: 1,
                                                    text: '1M'
                                                }, {
                                                    type: 'all',
                                                    text: 'All'
                                                }],
                                                selected: 0,
			                                    inputEnabled : false
                                            },
		                                    title: {
		                                        text: '<?php echo get_lang($lang,'k195'); ?>'
		                                    },
                                            subtitle: {
                                                text: '<?php echo get_lang($lang,'k196')." 5 ".get_lang($lang,'k197'); ?>'
                                            },
                                            xAxis: {
                                                title: {
                                                    text: null
                                                }
                                            },
                                            yAxis: {
		                                        showLastLabel: false,
                                                title: {
                                                    text: '<?php echo get_lang($lang,'k168'); ?> (ºC)'
                                                },
		                                        offset: 20,
		                                        max: 40,
		                                        min: 0
                                            },
                                            plotOptions: {
                                                series: {
                                                    animation: {
                                                        duration: 2000,
                                                        easing: 'easeOutBounce'
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            tooltip: {
                                                shared: true,
                                                formatter: function() {
                                                    var p = '';
                                                    p += '<b>' + Highcharts.dateFormat('%b %e, %Y, %H:%M',this.x) +'</b><br/>';
                                                    $.each(this.points, function(i, series){
                                                        p +='<span style="color:' + this.series.color + '">' + this.series.name + '</span>: ' + Highcharts.numberFormat(this.y,1) + ' ºC<br/>'
                                                    });
                                                    return p;
                                                }
                                            },
                                            legend: {
			                                    enabled: true,
                                                floating: false,
			                                    borderWidth: 0
                                            },
		                                    series: data
		                                });
	                                });
                                });
                                </script>
								<div id="ichart" style="height:534px;width:100%;margin:0;padding:0;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k195')." - ".get_lang($lang,'k196')." 60 ".get_lang($lang,'k197'); ?>
							</div>
                            <div class="panel-body" style="margin:4px 5px 10px 5px;padding:0;">
                                <script type="text/javascript">
	                            Highcharts.setOptions({
		                            global : { useUTC: false }
	                            });
                                $(function () {
	                                $.getJSON('ar_in_data_history_60m.php?lang=<?=$lang?>', function(data) {
		                                $('#hchart').highcharts('StockChart', {
		                                    chart: {
				                                spacingTop: 10,
				                                spacingBottom: 10,
				                                marginBottom: 50,
                                                animation: {
                                                    duration: 2000,
                                                    easing: 'easeOutBounce'
                                                }
		                                    },
                                            rangeSelector: {
                                                buttons: [{
                                                    type: 'hour',
                                                    count: 8,
                                                    text: '8H'
			                                    }, {
                                                    type: 'day',
                                                    count: 1,
                                                    text: '1D'
                                                }, {
                                                    type: 'day',
                                                    count: 2,
                                                    text: '2D'
                                                }, {
                                                    type: 'day',
                                                    count: 3,
                                                    text: '3D'
                                                }, {
                                                    type: 'day',
                                                    count: 7,
                                                    text: '7D'
                                                }, {
                                                    type: 'day',
                                                    count: 15,
                                                    text: '15D'
                                                }, {
                                                    type: 'month',
                                                    count: 1,
                                                    text: '1M'
                                                }, {
                                                    type: 'all',
                                                    text: 'All'
                                                }],
                                                selected: 0,
			                                    inputEnabled : false
                                            },
		                                    title: {
		                                        text: '<?php echo get_lang($lang,'k195'); ?>'
		                                    },
                                            subtitle: {
                                                text: '<?php echo get_lang($lang,'k196')." 60 ".get_lang($lang,'k197'); ?>'
                                            },	
                                            xAxis: {
                                                title: {
                                                    text: null
                                                }
                                            },
                                            yAxis: {
		                                        showLastLabel: false,
                                                title: {
                                                    text: '<?php echo get_lang($lang,'k168'); ?> (ºC)'
                                                },
		                                        offset: 20,
		                                        max: 40,
		                                        min: 0
                                            },
                                            plotOptions: {
                                                series: {
                                                    animation: {
                                                        duration: 2000,
                                                        easing: 'easeOutBounce'
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            tooltip: {
                                                shared: true,
                                                formatter: function() {
                                                    var p = '';
                                                    p += '<b>' + Highcharts.dateFormat('%b %e, %Y, %H:%M',this.x) +'</b><br/>';
                                                    $.each(this.points, function(i, series){
                                                        p +='<span style="color:' + this.series.color + '">' + this.series.name + '</span>: ' + Highcharts.numberFormat(this.y,1) + ' ºC<br/>'
                                                    });
                                                    return p;
                                                }
                                            },
                                            legend: {
			                                    enabled: true,
                                                floating: false,
			                                    borderWidth: 0
                                            },
		                                    series: data
		                                });
	                                });
                                });
                                </script>
								<div id="hchart" style="height:534px;width:100%;margin:0;padding:0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k198')." - ".get_lang($lang,'k196')." 60 ".get_lang($lang,'k197'); ?>
							</div>
                            <div class="panel-body" style="margin:4px 5px 10px 5px;padding:0;">
                                <script type="text/javascript">
	                            Highcharts.setOptions({
		                            global : { useUTC: false }
	                            });
                                $(function () {
	                                $.getJSON('ar_in_data_history_hum_60m.php?lang=<?=$lang?>', function(data) {
		                                $('#humchart').highcharts('StockChart', {
		                                    chart: {
				                                spacingTop: 10,
				                                spacingBottom: 10,
				                                marginBottom: 50,
                                                animation: {
                                                    duration: 2000,
                                                    easing: 'easeOutBounce'
                                                }
		                                    },
                                            rangeSelector: {
                                                buttons: [{
                                                    type: 'hour',
                                                    count: 8,
                                                    text: '8H'
			                                    }, {
                                                    type: 'day',
                                                    count: 1,
                                                    text: '1D'
                                                }, {
                                                    type: 'day',
                                                    count: 2,
                                                    text: '2D'
                                                }, {
                                                    type: 'day',
                                                    count: 3,
                                                    text: '3D'
                                                }, {
                                                    type: 'day',
                                                    count: 7,
                                                    text: '7D'
                                                }, {
                                                    type: 'day',
                                                    count: 15,
                                                    text: '15D'
                                                }, {
                                                    type: 'month',
                                                    count: 1,
                                                    text: '1M'
                                                }, {
                                                    type: 'all',
                                                    text: 'All'
                                                }],
                                                selected: 0,
			                                    inputEnabled : false
                                            },
		                                    title: {
		                                        text: '<?php echo get_lang($lang,'k198'); ?>'
		                                    },
                                            subtitle: {
                                                text: '<?php echo get_lang($lang,'k196')." 60 ".get_lang($lang,'k197'); ?>'
                                            },	
                                            xAxis: {
                                                title: {
                                                    text: null
                                                }
                                            },
                                            yAxis: {
		                                        showLastLabel: false,
                                                title: {
                                                    text: '<?php echo get_lang($lang,'k199'); ?> %'
                                                },
		                                        offset: 20,
		                                        max: 100,
		                                        min: 20
                                            },
                                            plotOptions: {
                                                series: {
                                                    animation: {
                                                        duration: 2000,
                                                        easing: 'easeOutBounce'
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            tooltip: {
                                                shared: true,
                                                formatter: function() {
                                                    var p = '';
                                                    p += '<b>' + Highcharts.dateFormat('%b %e, %Y, %H:%M',this.x) +'</b><br/>';
                                                    $.each(this.points, function(i, series){
                                                        p +='<span style="color:' + this.series.color + '">' + this.series.name + '</span>: ' + Highcharts.numberFormat(this.y,0) + ' %<br/>'
                                                    });
                                                    return p;
                                                }
                                            },
                                            legend: {
			                                    enabled: true,
                                                floating: false,
			                                    borderWidth: 0
                                            },
		                                    series: data
		                                });
	                                });
                                });
                                </script>
								<div id="humchart" style="height:534px;width:100%;margin:0;padding:0;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>