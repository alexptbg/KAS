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
                            <a href="index.php?lang=<?=$lang?>">
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
                            <a href="vrf_activity.php?lang=<?=$lang?>" class="active">
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
                                    <a href="settings.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k11'); ?></a>
                                </li>
                                <li>
                                    <a href="logs.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k13'); ?></a>
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
					</div>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos"><i class="fa fa-pie-chart"></i> <?php echo get_lang($lang, 'k181'); ?></h3>
                    </div>
                </div>
				
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k182'); ?>
							</div>
                            <div class="panel-body" style="margin:4px 5px 10px 5px;padding:0;">
                            <?php
                                //usernames from logs
                                $query = "SELECT `user` FROM `logs` GROUP BY `user`";
                                $result = mysql_query($query);
                                confirm_query($result);
                                $num_rows = mysql_num_rows($result);
                                if ($num_rows != 0) {
									while ($users = mysql_fetch_array($result)) {
										if (($users['user'] != 'Alex') && ($users['user'] != 'alex')) {
											$all_users[] = $users['user'];
										}
									}
									//next
									if (!empty($all_users)) {
										//get names
										foreach ($all_users as $single) {
                                            $query = "SELECT `first_name`,`last_name`,`level` FROM `users` WHERE `user_name`='".$single."'";
                                            $result = mysql_query($query);
                                            confirm_query($result);
                                            $num_rows = mysql_num_rows($result);
                                            if ($num_rows != 0) {
									            while ($names = mysql_fetch_array($result)) {
									        	    $all_names[] = $names['first_name']." ".$names['last_name'];
									            }
									            //get actions
                                                $query = "SELECT `user`,COUNT(*) FROM `logs` WHERE `user`='".$single."'";
                                                $result = mysql_query($query);
                                                confirm_query($result);
                                                $num_rows = mysql_num_rows($result);
                                                if ($num_rows != 0) {
									                while ($row = mysql_fetch_array($result)) {
									                	$actions[] = $row['COUNT(*)'];
									                }
									            }
									        }
									    }
									    if ((!empty($all_names)) && (!empty($actions))) {
									        //first date
									        $query = "SELECT `date` FROM `logs` ORDER BY `id` ASC LIMIT 1";
                                            $result = mysql_query($query);
                                            confirm_query($result);
                                            $num_rows = mysql_num_rows($result);
                                            if ($num_rows != 0) {
									            while ($row = mysql_fetch_array($result)) {
									            	$first_date = $row['date'];
									            }
									        }
									        //last date
									        $query = "SELECT `date` FROM `logs` ORDER BY `id` DESC LIMIT 1";
                                            $result = mysql_query($query);
                                            confirm_query($result);
                                            $num_rows = mysql_num_rows($result);
                                            if ($num_rows != 0) {
									            while ($row = mysql_fetch_array($result)) {
									            	$last_date = $row['date'];
									            }
									        }
									        echo "
                                <script type=\"text/javascript\">
Highcharts.setOptions({
    global : {
	    useUTC : false
	}
});
$(function () {
    Highcharts.setOptions({
        colors: ['#06a7ec', '#f9932d', '#20ed1b', '#f724e1', '#24CBE5', '#fd0909', '#de76b1', '#FFF263', '#6AF9C4']
    });
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.4).get('rgb')] // darken
            ]
        };
    });
    $('#hchart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        title: {
            text: '".get_lang($lang,'k182')."'
        },
        subtitle: {
            text: '".$first_date." - ".$last_date."'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        fontSize: '13px'
                    }
                }
            },
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
        series: [{
            type: 'pie',
            name: '".get_lang($lang, 'k181')."',
            data: [";
                $z=0;
                foreach($all_users as $single){
					echo " ['".$all_names[$z]."',   ".$actions[$z]."], ";
					$z++;
				}
                echo "
            ]
        }]
    });
});
                                </script>
                                <div id=\"hchart\" style=\"height:534px;width:100%;margin:0;padding:0;\"></div>";
									    } else {
											echo "<br/>
											      <div class=\"alert alert-warning\">".get_lang($lang, 'k183')."</div>";
										}
									}
								} else {
									//do nothing for now
								}
                            ?>	
                            </div>
                        </div>
                    </div>
                </div>
				<!--end row-->
                <?php
                if ((!empty($all_names)) && (!empty($actions))) {
                    echo "<div class=\"row\">";
                    $master = array_combine($all_names,$actions);
                    arsort($master);
                    $i=1;
                    foreach($master as $u => $v) {
                        if($i<=3) {
                            echo "
                    <div class=\"col-xs-12 col-md-4 tooltipx\">
                        <div class=\"panel panel-primary text-center panel-eyecandy\">
                            <div class=\"panel-body\" style=\"height:190px;\">
                                <img src=\"img/cup".$i.".png\" alt=\"\" style=\"width:128px;\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".$i." ".get_lang($lang,'k207')."\" />
                                <h3>".$v."</h3>
                            </div>
                            <div class=\"panel-footer\">
                                <span class=\"panel-eyecandy-title\">
                                    <h5>".$u."</h5>
                                </span>
                            </div>
                        </div>
                    </div>";
						}
                        $i++;
					}
                    echo "</div>"; 
                }
                ?>
                <!--end row-->
                <?php
                //get all usernames from system
                $query = "SELECT `user_name` FROM `users`";
                $result = mysql_query($query);
                confirm_query($result);
                $num_rows = mysql_num_rows($result);
                if ($num_rows != 0) {
                	echo "
                <div class=\"row\">
                    <div class=\"col-lg-4\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">
							    ".get_lang($lang,'k204')."
							</div>
                            <div class=\"panel-body\">
                                <ul class=\"list-unstyled\">";
				    while ($usernames = mysql_fetch_array($result)) {
					    if (($usernames['user_name'] != "Alex") && ($usernames['user_name'] != "alex") && ($usernames['user_name'] != "test10") && ($usernames['user_name'] != "klima")) {
						    $all_usernames[] = $usernames['user_name'];
						}
					}
                    $diff = array_diff($all_usernames,$all_users);
                    //print_r($diff);
					if (!empty($diff)) {
					    //get names ($diff)
						foreach ($diff as $alone) {
                            $query = "SELECT `first_name`,`last_name`,`level` FROM `users` WHERE `user_name`='".$alone."'";
                            $result = mysql_query($query);
                            confirm_query($result);
                            $num_rows = mysql_num_rows($result);
                            if ($num_rows != 0) {
							    while ($namex = mysql_fetch_array($result)) {
								    //$all_namex[] = $namex['first_name']." ".$namex['last_name'];
								    echo "
                                    <li>
                                        <i class=\"fa fa-user fa-fw\"></i>&nbsp;
                                        <span class=\"text-danger uppercase\">".$namex['first_name']." ".$namex['last_name']."</span>
                                    </li>";
								}
							}
						}
						//print_r($all_namex);
                    }
					echo "      </ul>
                            </div>
                        </div>
                    </div>
                </div>";
				}
                //print_r($all_usernames);
                //echo "<br/>";
                //print_r($all_users);
                //echo "<br/>";
                ?>
            </div>
        </div>
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>