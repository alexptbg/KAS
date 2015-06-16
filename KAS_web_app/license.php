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
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
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
                                <li class="active">
                                    <a class="active" href="license.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k209'); ?></a>
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
					    <h6><?php echo get_lang($lang,'k243')."&nbsp;".date("Y-m-d H:i:s",filemtime("index.php")); ?></h6>
					</div>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </nav>
            <!-- /.navbar-static-side -->

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos"><i class="fa fa-key"></i>&nbsp;<?php echo get_lang($lang,'k210'); ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k211'); ?>
							</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <?php
								echo "
                                    <table class=\"table table-striped table-bordered table-hover\" style=\"margin-bottom:23px;\">
                                        <tbody>
                                            <tr>
                                                <td style=\"text-align: right; width: 40%;\">".get_lang($lang,'k213').":</td>
												<td>".HOST."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 40%;\">".get_lang($lang,'k214').":</td>
												<td>".$settings['hash']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 40%;\">".get_lang($lang,'k215').":</td>
												<td>".$settings['code']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 40%;\">".get_lang($lang,'k216').":</td>
												<td>".$settings['lkey']."</td>
											</tr>
										</tbody>
									</table>";
						         ?>
                                    <button type="button" class="btn btn-danger fr" onClick="document.location.href = 'license_edit.php?lang=<?=$lang?>'">
								        <i class="fa fa-unlock-alt"></i>&nbsp;<?php echo get_lang($lang,'k217'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
							    <?php echo get_lang($lang,'k212'); ?>
							</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <?php
                                //start
                                $_x = $settings['salt'];
                                $_s = strtotime(decrypt($settings['hash'],$_x));
                                $_e = strtotime(decrypt($settings['code'],$_x));
                                $_k = decrypt($settings['lkey'],$_x);
                                $_n = date('Y-m-d');
                                $_n = strtotime($_n);
                                $_d = constant('HOST');
                                $_c = get_domain($_d);
                                $_v = date('Y-m-d',$_s);
                                $_t = date('Y-m-d',$_e);
								echo "
                                    <table class=\"table table-striped table-bordered table-hover\">
                                        <tbody>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k222').":</td>
												<td>".$settings['installed']."</td>
											</tr>";           
                                            if ($installed>$_s) {
	                                            $_z = date('Y-m-d',$installed);
                                                $end = date('Y-m-d', strtotime("$_z +30 days") );
	                                            $_ex = strtotime($end);
                                                $now = strtotime(date('Y-m-d'));
                                                $datediff = $_ex - $now;
                                                $days = floor($datediff/(60*60*24));
	                                            $stop = strtotime($end);
	                                            $_z = date('Y-m-d',$end);
	                                            if ($_c != $_k) {
	                                                if (($days<30) && ($days>0)) {
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212')."</td>
                                                <td><span class=\"text-danger\">".get_lang($lang,'k223')."<span></td>                                   
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".get_lang($lang,'k224')."&nbsp;
					                                    <strong>".$days."</strong>&nbsp;".get_lang($lang,'k225')."</span>
					                            </td>
					                        </tr>";
	                                                } else {
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212')."</td>
                                                <td><span class=\"text-danger\">".get_lang($lang,'k226')."<span></td>                                   
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".get_lang($lang,'k227')."&nbsp;<strong>".$end."</strong></span>
					                            </td>
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".get_lang($lang,'k228')."</span>
					                            </td>
                                            </tr>";
	                                                }
	                                            }
                                            } else {
                                                if ($_c == $_k) {
                                                    if (($_n>$_s) and ($_n<$_e)) {
	                                                    $end = $_e;
	                                                    $now = strtotime(date('Y-m-d'));
	                                                    $datediff = $end - $now;
                                                        $days = floor($datediff/(60*60*24));
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212').":</td>
                                                <td><span class=\"text-success\">".get_lang($lang,'k218')."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k219').":</td>
                                                <td><span class=\"text-success\">".$_v."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k220').":</td>
                                                <td><span class=\"text-success\">".$_t."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k221').":</td>";
					                            if ($days<30){
						                            echo "<td><span class=\"text-danger\">".$days."</span></td>";
					                            } else {
						                            echo "<td><span class=\"text-success\">".$days."</span></td> ";
					                            }                      
                                      echo "</tr>";
	                                                } else {
			                                            $_z = date('Y-m-d',$_e);
	                                                    $now = strtotime(date('Y-m-d'));
			                                            $_i = strtotime(date('Y-m-d',$installed));
	                                                    $datediff = $now - $_e;
                                                        $days = floor($datediff/(60*60*24));
                                                        $stop = date('Y-m-d', strtotime("$_z +30 days") );
			                                            if (($days<30) && ($days>0)) {
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212').":</td>
                                                <td><span class=\"text-danger\">".get_lang($lang,'k229')."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k230').":</td>
                                                <td><span class=\"text-danger\">".$_z."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k231').":</td>
					                            <td><span class=\"text-danger\">".$days."</span></td>
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".$settings['slogan']." ".get_lang($lang,'k232')." <strong>".$stop."</strong></span>
					                            </td>
                                            </tr>";
		                                                } else {
		                                                	//here
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212').":</td>
                                                <td><span class=\"text-danger\">".get_lang($lang,'k229')."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k230').":</td>
                                                <td><span class=\"text-danger\">".$_z."</span></td>                                   
                                            </tr>
                                            <tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k231').":</td>
					                            <td><span class=\"text-danger\">".$days."</span></td>
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".$settings['slogan']." ".get_lang($lang,'k233')." <strong>".$stop."</strong>
					                                </span>
					                            </td>
                                            </tr>";
			                                            }
	                                                }
                                                } else {
                                      echo "<tr>                                    
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang,'k212').":</td>
                                                <td><span class=\"text-danger\">".get_lang($lang,'k234')."</span></td>                                   
                                            </tr>
                                            <tr>                                    
					                            <td colspan=\"2\" style=\"text-align:center;\">
					                                <span class=\"text-danger\">".$settings['slogan']." ".get_lang($lang,'k235')." </span>
					                            </td>
                                            </tr>";
                                                }
                                            }
								      echo "
										</tbody>
									</table>";
						         ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<!--end row-->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>