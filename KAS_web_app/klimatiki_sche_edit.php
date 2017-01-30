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
$u = $_GET['user'];
$k = $_GET['klima'];
$r = $_GET['r'];
$k_settings = get_klima_settings($k);
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
		<link rel="stylesheet" type="text/css" href="js/plugins/validation/jquery.validationEngine.css" />
		<script type="text/javascript" src="js/plugins/validation/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="js/plugins/validation/lang/jquery.validationEngine-<?=$lang?>.js"></script>
		<script type="text/javascript" src="js/forms.js"></script>
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
					                	$z=0;
					                	foreach ($klimas_all_list as $klima) {
					                	    if (in_array($klima,$klimas_u_all)) { $z++; }
					                	}					
										if ($building == $r) {
						                echo "
                                             <li class=\"active\">
                                                 <a href=\"#\" class=\"active\"><i class=\"fa fa-th fa-fw fa-3x\"></i>&nbsp;".$building."&nbsp;
                                                     <span class=\"kcount\">".$z."</span><span class=\"fa arrow\"></span></a>
							                     <ul class=\"nav nav-second-level\">";
										} else {
						                echo "
                                             <li>
                                                 <a href=\"#\"><i class=\"fa fa-th fa-fw fa-3x\"></i>&nbsp;".$building."&nbsp;
                                                     <span class=\"kcount\">".$z."</span><span class=\"fa arrow\"></span></a>
							                     <ul class=\"nav nav-second-level\">";
										}													 
						                foreach ($klimas_all_list as $klima) {
											if (in_array($klima,$klimas_u_all)) {
												if ($klima == $k) {
                                                echo "
                                             <li class=\"active\">
												 <a href=\"klima_i.php?lang=".$lang."&user=".$user_settings["user_name"]."&klima=".$klima."&r=".$building."\" class=\"active\">
										             ".get_lang($lang, 'k68')." ".$klima."</a></li>";
												} else {
                                                echo "
                                             <li>
												 <a href=\"klima_i.php?lang=".$lang."&user=".$user_settings["user_name"]."&klima=".$klima."&r=".$building."\">
										             ".get_lang($lang, 'k68')." ".$klima."</a></li>";
												}
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
							if (!empty($buildings)) {
								echo "
								<li>
                            <a href=\"override.php?lang=".$lang."\">
							    <i class=\"fa fa-legal fa-fw fa-3x\"></i>&nbsp;".get_lang($lang,'k126')."<span class=\"fa arrow\"></span></a>
								<ul class=\"nav nav-second-level\">";
								echo "
								        <li><a href=\"override_all.php?lang=".$lang."&addr=all\"><span style=\"color:red;\">
										    ".get_lang($lang,'k128')."&nbsp;".get_lang($lang,'k10')."</span></a></li>";
	                            foreach ($buildings as $building) {
                                    echo "<li><a href=\"#\">".$building."&nbsp;<span class=\"fa arrow\"></span></a>";
                                    $query = "SELECT `addr` FROM `klimatiki` WHERE `router`='".$building."' GROUP BY `addr` ORDER BY `addr` ASC";
                                    $result = mysql_query($query);
                                    confirm_query($result);
                                    if (mysql_num_rows($result) != 0) {
                            	        echo "<ul class=\"nav nav-third-level\">";
						                while($addrs = mysql_fetch_array($result)) {
									        echo "
                                        <li><a href=\"override.php?lang=".$lang."&addr=".$addrs['addr']."\">
										    ".get_lang($lang,'k10')."&nbsp;".$addrs['addr']."</a></li>";
					                    }
					                    echo "</ul>";
					                }
                                    echo "</li>";
	                            }
								echo "</ul></li>";
							}
						}
						?>
                        <li>
                            <a href="vrf_plan.php?lang=<?=$lang?>">
							    <i class="fa fa-location-arrow fa-fw fa-3x"></i> <?php echo get_lang($lang,'k130'); ?></a>
                        </li>
                        <?php if ($user_settings['level'] > 10): ?>
                        <li>
                            <a href="repairs.php?lang=<?=$lang?>">
							    <i class="fa fa-wrench fa-fw fa-3x"></i> <?php echo get_lang($lang,'k284'); ?></a>
                        </li>
                        <?php endif; ?>
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
                                <li>
                                    <a href="logs.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k13'); ?></a>
                                </li>
								<?php if ($user_settings['level'] > 20): ?>
                                <li>
                                    <a href="settings.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k11'); ?></a>
                                </li>
                                <li>
                                    <a href="license.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k209'); ?></a>
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
                        <h3 class="page-header text-asbestos">
						    <i class="fa fa-square"></i> <?php echo $r." \ ".$k_settings['building']." \ ".$k_settings['floor']." \ ".$k; ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
                <?php if ($user_settings['level'] > 5): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <?php echo get_lang($lang,'k141'); ?>
                            </div>
							<form method="POST" action="klimatiki_sche_update.php?lang=<?=$lang?>&klima=<?=$k?>&user=<?=$u?>&r=<?=$r?>" id="forms">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k27'); ?>:</label>
                                    <input class="form-control" type="text" name="k_id" value="<?php echo $k_settings['id']; ?>" readonly="readonly" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k51'); ?>:</label>
                                    <input class="form-control validate[required,custom[onlyNnumbers]]" maxlength="6" type="text" name="inv" value="<?php echo $k_settings['inv']; ?>" readonly="readonly" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k132'); ?>:</label>
                                    <select class="form-control validate[required]" id="prog" name="prog">
									    <option value="<?php echo $k_settings['prog']; ?>"><?php echo get_lang($lang,lcfirst($k_settings['prog'])); ?></option>
									    <option></option>
                                        <option value="Off"><?php echo get_lang($lang, 'off'); ?></option>
                                        <option value="On"><?php echo get_lang($lang, 'on'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k133'); ?>:</label>
									<table class="table">
									    <thead>
											<tr>
												<th colspan="2"><?php echo get_lang($lang,'k137'); ?>:&nbsp;&nbsp;<span id="time_status_w"></span></th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											    <td class="fr"><label><?php echo get_lang($lang,'k133'); ?>:</label>&nbsp;</td>
												<td>
                                    <select class="form-control validate[required]" id="time_start_w" name="start_w">
									    <option value="<?php echo $k_settings['start_w']; ?>"><?php echo $k_settings['start_w']; ?></option>
									    <option></option>
                                        <option value="05:30">05:30</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>														
                                    </select>
												</td>
												<td class="fr"><label><?php echo get_lang($lang, 'k134'); ?>:</label>&nbsp;</td>
                                                <td>
                                    <select class="form-control validate[required]" id="time_stop_w" name="stop_w">
									    <option value="<?php echo $k_settings['stop_w']; ?>"><?php echo $k_settings['stop_w']; ?></option>
									    <option></option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:30">23:30</option>
										<option value="23:45">23:45</option>															
                                    </select>
												</td>
											</tr>
										</tbody>
									</table>
									<table class="table">
									    <thead>
											<tr>
												<th colspan="2"><?php echo get_lang($lang, 'k138'); ?>:&nbsp;&nbsp;<span id="time_status_s"></span></th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											    <td class="fr"><label><?php echo get_lang($lang, 'k133'); ?>:</label>&nbsp;</td>
												<td>
                                    <select class="form-control validate[required]" id="time_start_s" name="start_s">
									    <option value="<?php echo $k_settings['start_s']; ?>"><?php echo $k_settings['start_s']; ?></option>
									    <option></option>
                                        <option value="05:30">05:30</option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>													
                                    </select>
												</td>
												<td class="fr"><label><?php echo get_lang($lang, 'k134'); ?>:</label>&nbsp;</td>
                                                <td>
                                    <select class="form-control validate[required]" id="time_stop_s" name="stop_s">
									    <option value="<?php echo $k_settings['stop_s']; ?>"><?php echo $k_settings['stop_s']; ?></option>
									    <option></option>
                                        <option value="06:00">06:00</option>
                                        <option value="06:30">06:30</option>
                                        <option value="07:00">07:00</option>
                                        <option value="07:30">07:30</option>
                                        <option value="08:00">08:00</option>
                                        <option value="08:30">08:30</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:30">23:30</option>
										<option value="23:45">23:45</option>															
                                    </select>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

                            </div>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-primary btn-lg" onClick="javascript: history.go(-1); return false;">
								    <i class="fa fa-times"></i>&nbsp;<?php echo get_lang($lang, 'k28'); ?></button>
								<button type="submit" name="submit" class="btn btn-warning btn-lg">
								    <i class="fa fa-save"></i>&nbsp;<?php echo get_lang($lang, 'k29'); ?></button>
                            </div>
							</form>
                        </div>
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
                                <button type="button" class="btn btn-primary btn-lg" onClick="javascript: history.go(-1); return false;">
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
		<?php if ($user_settings['level'] > 5): ?>
		<script type="text/javascript">
$(function () {
                if($("select#prog").val().length > 0 && $("select#prog").val() == 'On') {
		                $("select#time_start_w").removeAttr("readonly");
						$("select#time_stop_w").removeAttr("readonly");
		                $("select#time_start_s").removeAttr("readonly");
						$("select#time_stop_s").removeAttr("readonly");
                    } else {
                        $("select#time_start_w").attr("readonly", true);
                        $("select#time_stop_w").attr("readonly", true);
                        $("select#time_start_s").attr("readonly", true);
                        $("select#time_stop_s").attr("readonly", true);				
                    }
                $("select#prog").change(function() {
                    if($("select#prog").val().length > 0 && $("select#prog").val() == 'On') {
		                $("select#time_start_w").removeAttr("readonly");
						$("select#time_stop_w").removeAttr("readonly");
		                $("select#time_start_s").removeAttr("readonly");
						$("select#time_stop_s").removeAttr("readonly");
                    } else {
                        $("select#time_start_w").attr("readonly", true);
                        $("select#time_stop_w").attr("readonly", true);
                        $("select#time_start_s").attr("readonly", true);
                        $("select#time_stop_s").attr("readonly", true);					
                    }
                });
$("#time_start_w").change(function() { 
	var time_start_w = $("#time_start_w").val();
	var time_stop_w = $("#time_stop_w").val();	
    if (time_stop_w > time_start_w) {
        $("span#time_status_w").html("<font color='green'><?php echo get_lang($lang,'k135'); ?></font>");
    } else {
		$("span#time_status_w").html("<font color='red'><?php echo get_lang($lang,'k136'); ?></font>");
	}
});
$("#time_stop_w").change(function() { 
	var time_start_w = $('#time_start_w').val();
	var time_stop_w = $('#time_stop_w').val();	
    if (time_stop_w > time_start_w) {
        $("span#time_status_w").html("<font color='green'><?php echo get_lang($lang,'k135'); ?></font>");
    } else {
		$("span#time_status_w").html("<font color='red'><?php echo get_lang($lang,'k136'); ?></font>");
	}
});
$("#time_start_s").change(function() { 
	var time_start_s = $("#time_start_s").val();
	var time_stop_s = $("#time_stop_s").val();	
    if (time_stop_s > time_start_s) {
        $("span#time_status_s").html("<font color='green'><?php echo get_lang($lang,'k135'); ?></font>");
    } else {
		$("span#time_status_s").html("<font color='red'><?php echo get_lang($lang,'k136'); ?></font>");
	}
});
$("#time_stop_s").change(function() { 
	var time_start_s = $('#time_start_s').val();
	var time_stop_s = $('#time_stop_s').val();	
    if (time_stop_s > time_start_s) {
        $("span#time_status_s").html("<font color='green'><?php echo get_lang($lang,'k135'); ?></font>");
    } else {
		$("span#time_status_s").html("<font color='red'><?php echo get_lang($lang,'k136'); ?></font>");
	}
});
});
</script>
    <?php endif; ?>
    </body>
</html>