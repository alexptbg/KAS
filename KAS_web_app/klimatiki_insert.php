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
$router = mysql_prep($_GET['router']);
$id = mysql_prep($_GET['id']);
$r_settings = get_router_settings($router,$id);
$socket_ip = $r_settings['ip_address'];
$socket_port = $r_settings['port'];
include('inc/socket.php');
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
                <!-- /.navbar-header -->
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
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-2x fa-fw"></i>
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
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
            </nav>
            <!-- /.navbar-static-top -->

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
                            <a href="vrf_activity.php?lang=<?=$lang?>">
							    <i class="fa fa-pie-chart fa-fw fa-3x"></i> <?php echo get_lang($lang, 'k181'); ?></a>
                        </li>
                        <li>
                            <a href="vrf_errors.php?lang=<?=$lang?>">
							    <i class="fa fa-exclamation-triangle fa-fw fa-3x"></i> <?php echo get_lang($lang, 'k200'); ?></a>
                        </li>
						<?php if ($user_settings['level'] > 10): ?>
                        <li class="active">
                            <a class="active" href="#"><i class="fa fa-cog fa-fw fa-3x"></i> <?php echo get_lang($lang, 'Settings'); ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
							    <?php if ($user_settings['level'] > 20): ?>
                                <li>
                                    <a href="routers.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k09'); ?></a>
                                </li>
                                <li class="active">
                                    <a class="active" href="#"><?php echo get_lang($lang, 'k10'); ?>&nbsp;<span class="fa arrow"></span></a>
									<?php
                                        $query = "SELECT * FROM `routers` ORDER BY `router_name` ASC";
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        $num_rows = mysql_num_rows($result);
                                        if ($num_rows != 0) {
										    echo "<ul class=\"nav nav-third-level\">";
											while ($routerx = mysql_fetch_array($result)) {
												if ($routerx['router_name'] == $router) {
													echo "<li>
											          <a class=\"active\" href=\"klimatiki.php?lang=".$lang."&id={$routerx['id']}&router={$routerx['router_name']}\">
											          ".$routerx['router_name']."</a></li>";
												} else {
													echo "<li>
											          <a href=\"klimatiki.php?lang=".$lang."&id={$routerx['id']}&router={$routerx['router_name']}\">
											          ".$routerx['router_name']."</a></li>";
												}
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
                            <!-- /.nav-second-level -->
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
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </nav>
            <!-- /.navbar-static-side -->

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos"><i class="fa fa-th"></i> <?php echo get_lang($lang, 'k10'); ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
				
                <?php if ($user_settings['level'] > 10): ?>
                <div class="row">
                    <div class="col-lg-12">
                            <?php
								if(isset($_POST['submit'])) {
									$ak_router = mysql_prep($_POST['k_router']);
									$ak_inv = mysql_prep($_POST['inv']);
									$ak_rtu = mysql_prep($_POST['rtu']);
									$ak_addr = mysql_prep($_POST['addr']);
									$ak_building = mysql_prep($_POST['building']);
									$ak_floor = mysql_prep($_POST['floor']);
									$ak_group = mysql_prep($_POST['group']);
									$ak_zona = mysql_prep($_POST['zona']);
									$ak_place = mysql_prep($_POST['place']);
									$ak_type = mysql_prep($_POST['type']);
									$ak_vrf = mysql_prep($_POST['vrf']);
									$ak_prog = mysql_prep($_POST['prog']);
									$ak_start_w = mysql_prep($_POST['start_w']);
									$ak_stop_w = mysql_prep($_POST['stop_w']);
									$ak_start_s = mysql_prep($_POST['start_s']);
									$ak_stop_s = mysql_prep($_POST['stop_s']);
									$check = check_klimatik_before_add($ak_inv,$ak_rtu);
									if (($ak_router != NULL) && ($check == FALSE)) {
										//try to insert
	                                    mysql_query("SET NAMES utf8");
		                                $query = "INSERT INTO `klimatiki` (`router`, `inv`, `rtu`, `addr`, `building`, `floor`, `group`, `zona`, `place`, `type`, `vrf`, `prog`, `start_w`, `stop_w`, `start_s`, `stop_s`) 
										          VALUES ('$ak_router', '$ak_inv', '$ak_rtu', '$ak_addr', '$ak_building', '$ak_floor', '$ak_group', '$ak_zona', '$ak_place', '$ak_type', '$ak_vrf', '$ak_prog', '$ak_start_w', '$ak_stop_w', '$ak_start_s', '$ak_stop_s')";
                                        $result = mysql_query($query);
                                        confirm_query($result);
                                        if ($result) {
											//inserted successfully
											//socket
	                                        $d = substr(chunk_split($ak_inv, 2, ' '), 0, -1);
	                                        $de = explode(" ", $d);
	                                        $delay = $de[0]*10+$de[1];
											$com = 'cmd';
	                                        $command = 'prog';
											if ($ak_prog != NULL) {
			$frame = "%sche_".$ak_inv." ".lcfirst($ak_prog)." %prog_".$ak_inv."_start_w ".$ak_start_w." %prog_".$ak_inv."_stop_w ".$ak_stop_w.
			                                                " %prog_".$ak_inv."_start_s ".$ak_start_s." %prog_".$ak_inv."_stop_s ".$ak_stop_s.
															" ".$ak_inv." ".$delay;
            try {
                if(!($command == NULL)) {
		            $server = 'server';
	                if ($command == 'prog') {
    	                $sc = new ClientSocket();
    	                $sc->open($socket_ip,$socket_port);
    	                $sc->send("$server $com $command $frame\r\n");
		            }
	            }
            }
            catch (Exception $e){ echo $e->getMessage(); }
											}
                                            echo "<div class=\"panel panel-primary\">";
                                            echo "<div class=\"panel-heading\">
                                                      ".get_lang($lang, 'k50')."
                                                  </div>";
										    echo "<div class=\"panel-body\"><div class=\"alert alert-success\">";
                                            echo get_lang($lang, 'k52');
                                            echo "</div></div></div>";
				                            $url = "klimatiki.php?lang=".$lang."&router=".$router."&id=".$id;
				                            redir($url,'2');
										} else {
											//error with insert
                                            echo "<div class=\"panel panel-primary\">";
                                            echo "<div class=\"panel-heading\">
                                                      ".get_lang($lang, 'k50')."
                                                  </div>";
										    echo "<div class=\"panel-body\"><div class=\"alert alert-danger\">";
                                            echo get_lang($lang, 'k33');
                                            echo "</div></div>";
											echo "<div class=\"panel-footer\">";
                                            echo "<button type=\"button\" class=\"btn btn-primary btn-lg\" onClick=\"javascript: history.go(-1); return false;\"><i class=\"fa fa-arrow-left\"></i>&nbsp;".get_lang($lang, 'k34')."</button>";
                                            echo "</div></div>";
										}
									} else {
										//can't add //name exists already in database
                                        echo "<div class=\"panel panel-primary\">";
                                        echo "<div class=\"panel-heading\">
                                                  ".get_lang($lang, 'k50')."
                                              </div>";
										echo "<div class=\"panel-body\"><div class=\"alert alert-danger\">";
                                        echo get_lang($lang, 'k53');
                                        echo "</div></div>";
										echo "<div class=\"panel-footer\">";
                                        echo "<button type=\"button\" class=\"btn btn-primary btn-lg\" onClick=\"javascript: history.go(-1); return false;\"><i class=\"fa fa-arrow-left\"></i>&nbsp;".get_lang($lang, 'k34')."</button>";
                                        echo "</div></div>";
									}					
								} else {
									//error //not submited
                                    echo "<div class=\"panel panel-primary\">";
                                    echo "<div class=\"panel-heading\">
                                              ".get_lang($lang, 'k50')."
                                          </div>";
									echo "<div class=\"panel-body\"><div class=\"alert alert-danger\">";
                                    echo get_lang($lang, 'k33');
                                    echo "</div></div>";
								    echo "<div class=\"panel-footer\">";
                                    echo "<button type=\"button\" class=\"btn btn-primary btn-lg\" onClick=\"javascript: history.go(-1); return false;\"><i class=\"fa fa-arrow-left\"></i>&nbsp;".get_lang($lang, 'k34')."</button>";
                                    echo "</div></div>";
								}
							?>
                    </div>
				</div>
				<?php else: ?>		
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <?php echo get_lang($lang, 'Error'); ?>
                            </div>
                            <div class="panel-body">
							    <div class="alert alert-warning">
                                    <?php echo get_lang($lang, 'k30'); ?>
								</div>
                            </div>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-primary btn-lg" onClick="document.location.href = 'routers.php?lang=<?=$lang?>'">
								    <i class="fa fa-times"></i>&nbsp;<?php echo get_lang($lang, 'k28'); ?></button>
                            </div>
                        </div>
                    </div>
				</div>
				<?php endif; ?>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>