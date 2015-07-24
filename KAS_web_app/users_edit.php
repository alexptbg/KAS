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
$user = mysql_prep($_GET['user']);
$uid = mysql_prep($_GET['uid']);
$usere = get_usere_settings($user,$uid);
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
		
		<link rel="stylesheet" type="text/css" href="js/plugins/icheck/minimal/blue.css" />
		<script type="text/javascript" src="js/plugins/icheck/icheck.min.js"></script>
		<script type="text/javascript" src="js/plugins/icheck/icheck.init.js"></script>
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
											          ".$routerx['router_name']."&nbsp;&nbsp;<span class=\"kcount\">".count_klimas($routerx['router_name'])."</span></a></li>";
											}
											echo "</ul>";
										} else {
													//do nothing
										}
									?>
                                </li>
								<?php endif; ?>
                                <li class="active">
                                    <a class="active" href="users.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k12'); ?></a>
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
                        <h3 class="page-header text-asbestos"><i class="fa fa-users"></i> <?php echo get_lang($lang, 'k12'); ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
                <?php if ($user_settings['level'] > 10): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <?php echo get_lang($lang, 'k106'); ?>
                            </div>
							<form method="POST" action="users_update.php?lang=<?=$lang?>" id="forms">
							<div class="panel-body">
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k27'); ?>:</label>
                                    <input class="form-control" type="text" name="uid" value="<?php echo $usere['id']; ?>" readonly="readonly" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k05'); ?>:</label>
                                    <input class="form-control validate[required,minSize[4]],custom[onlyLetterNumber]" maxlength="32" type="text" name="user_name" value="<?php echo $usere['user_name']; ?>" readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k86'); ?>:</label>
                                    <input class="form-control validate[required]" maxlength="32" type="text" name="first_name" value="<?php echo $usere['first_name']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k87'); ?>:</label>
                                    <input class="form-control validate[required]" maxlength="32" type="text" name="last_name" value="<?php echo $usere['last_name']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k91'); ?>:</label>
                                    <input class="form-control" maxlength="64" type="text" name="email" value="<?php echo $usere['email']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k92'); ?>:</label>
                                    <input class="form-control" maxlength="32" type="text" name="phone" value="<?php echo $usere['phone']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k265'); ?>:</label>
                                    <select class="form-control validate[required]" name="access">
                                        <?php
                                        if ($usere['access'] == 0) {
											echo "<option value=\"".$usere['access']."\">".get_lang($lang,'k266')."</option>";
										}
                                        if ($usere['access'] == 1) {
											echo "<option value=\"".$usere['access']."\">".get_lang($lang,'k267')."</option>";
										}
                                        ?>
									    <option></option>
                                        <option value="0"><?php echo get_lang($lang,'k266'); ?></option>
                                        <option value="1"><?php echo get_lang($lang,'k267'); ?></option>						
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k89'); ?>:</label>
                                    <select class="form-control validate[required]" name="level">
									    <option value="<?php echo $usere['level']; ?>"><?php echo $usere['level']; ?></option>
									    <option></option>
                                        <option value="1">1</option>
                                        <option value="3">3</option>
										<option value="5">5</option>
										<option value="10">10</option>
										<?php if ($user_settings['level'] > 20): ?>
										<option value="20">20</option>
										<option value="50">50</option>
										<?php endif; ?>								
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k90'); ?>:</label>
                                    <select class="form-control validate[required]" name="status">
									    <?php if ($usere['status'] == "Active"): ?>
									    <option value="<?php echo $usere['status']; ?>"><?php echo get_lang($lang,'k93'); ?></option>
										<?php elseif ($usere['status'] == "Pending"): ?>
										<option value="<?php echo $usere['status']; ?>"><?php echo get_lang($lang,'k94'); ?></option>
										<?php elseif ($usere['status'] == "Deactivated"): ?>
										<option value="<?php echo $usere['status']; ?>"><?php echo get_lang($lang,'k95'); ?></option>
										<?php endif; ?>	
									    <option></option>
                                        <option value="Pending"><?php echo get_lang($lang, 'k94'); ?></option>
                                        <option value="Deactivated"><?php echo get_lang($lang, 'k95'); ?></option>
										<option value="Active"><?php echo get_lang($lang, 'k93'); ?></option>									
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label><?php echo get_lang($lang,'k240'); ?>:</label>
                                    <select class="form-control validate[required]" name="init_lang">
									    <?php if ($usere['init_lang'] == "bg"): ?>
									    <option value="<?php echo $usere['init_lang']; ?>"><?php echo get_lang("bg","msg_001"); ?></option>
										<?php elseif ($usere['init_lang'] == "en"): ?>
										<option value="<?php echo $usere['init_lang']; ?>"><?php echo get_lang("en","msg_001"); ?></option>
										<?php endif; ?>	
									    <option></option>
                                        <option value="bg"><?php echo get_lang("bg","msg_001"); ?></option>
										<option value="en"><?php echo get_lang("en","msg_001"); ?></option>									
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k99'); ?>:</label>
                                    <input class="form-control" maxlength="64" type="text" name="info" value="<?php echo $usere['info']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label><?php echo get_lang($lang, 'k120'); ?>:</label>
                                    <input class="form-control" maxlength="17" type="text" name="device" value="<?php echo $usere['device']; ?>" />
                                </div>
                <?php
				if ($user_settings['level'] > 10) {
                    //buildings by user
                    $query2 = "SELECT `buildings` FROM `users` WHERE `user_name`='$user'";
                    $result2 = mysql_query($query2);
                    confirm_query($result2);
                    if (mysql_num_rows($result2) != 0) {
                        while($buildings_by_u = mysql_fetch_array($result2)) {
                            $buildings_by_u_list = $buildings_by_u['buildings'];
                        }
						$buildings_by_u_all = explode(', ',$buildings_by_u_list);
					}		
					//all buildings	
                    $query3 = "SELECT `router_name` FROM `routers` ORDER BY `router_name` ASC";
                    $result3 = mysql_query($query3);
                    confirm_query($result3);
                    if (mysql_num_rows($result3) != 0) {
						while($buildings_by_all = mysql_fetch_array($result3)) {
							$buildings_by_all_list[] = $buildings_by_all['router_name'];
					    }
					}
					//generate form
					if (!empty($buildings_by_all_list)) {
						echo "<div class=\"form-group\">
                                  <label>".get_lang($lang, 'k43').":</label><br/>";
						foreach ($buildings_by_all_list as $building_b) {
							if (in_array($building_b,$buildings_by_u_all)) {
							echo "<div class=\"checkbox-icheck\">
                                      <label class=\"checkbox-inline\">
                                          <span class=\"input\">
										      <input type=\"checkbox\" value=\"".$building_b."\" name=\"buildings[]\" checked />&nbsp;".$building_b."</span>
                                      </label>
							      </div>";
							} else {
							echo "<div class=\"checkbox-icheck\">
                                      <label class=\"checkbox-inline\">
                                          <span class=\"input\">
										      <input type=\"checkbox\" value=\"".$building_b."\" name=\"buildings[]\" />&nbsp;".$building_b."</span>
                                      </label>
							      </div>";
							}
						}
						echo "</div>";
					}
					
					//klimas by user
                    $query1 = "SELECT `klimas` FROM `users` WHERE `user_name`='".$user."'";
                    $result1 = mysql_query($query1);
                    confirm_query($result1);
                    if (mysql_num_rows($result1) != 0) {
                        while($klimas_by_u = mysql_fetch_array($result1)) {
                            $klimas_by_u_list = $klimas_by_u['klimas'];
                        }
						$klimas_by_u_all = explode(',',$klimas_by_u_list);
					}
					if (!empty($buildings_by_all_list)) {
						foreach ($buildings_by_all_list as $building_b) {
							//if (in_array($building_b,$buildings_by_all_list)) {
	                            $klimas_by_all_list="";
					            //all kilmas
                                $query = "SELECT * FROM `klimatiki` WHERE `router`='".$building_b."' ORDER BY `inv` ASC";
                                $result = mysql_query($query);
                                confirm_query($result);
                                if (mysql_num_rows($result) != 0) {
						            while($klimas_by_all = mysql_fetch_array($result)) {
							            $klimas_by_all_list[] = $klimas_by_all['inv'];
					                }
					                if (!empty($klimas_by_all_list)) {
						                echo "<div class=\"form-group\">
                                              <label>".get_lang($lang, 'k10')." ".$building_b.":</label><br/>";
						                foreach ($klimas_by_all_list as $klima_b) {
							                if (in_array($klima_b,$klimas_by_u_all)) {
							                    echo "<div class=\"checkbox-icheck\">
                                                          <label class=\"checkbox-inline\">
                                                              <span class=\"input\">
										                          <input type=\"checkbox\" value=\"".$klima_b."\" name=\"klimas[]\" checked />&nbsp;".$klima_b."</span>
                                                          </label>
							                          </div>";
							                } else {
							                    echo "<div class=\"checkbox-icheck\">
                                                          <label class=\"checkbox-inline\">
                                                              <span class=\"input\">
										                          <input type=\"checkbox\" value=\"".$klima_b."\" name=\"klimas[]\" />&nbsp;".$klima_b."</span>
                                                          </label>
							                          </div>";
							                }
						                }
						                echo "</div>";
					                }
					            }
                            //}
						}
					}
				}
				?>
							</div>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-primary btn-lg" onClick="document.location.href = 'users.php?lang=<?=$lang?>'; return false;">
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
                                <button type="button" class="btn btn-primary btn-lg" onClick="document.location.href = 'index.php?lang=<?=$lang?>'; return false;">
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