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
$ad = $_GET['addr'];
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

                        //by addr
						if ($user_settings['level'] > 10) {
							if (!empty($buildings)) {
								echo "
								<li class=\"active\">
                            <a href=\"override.php?lang=".$lang."\" class=\"active\">
							    <i class=\"fa fa-legal fa-fw fa-3x\"></i>&nbsp;".get_lang($lang,'k126')."<span class=\"fa arrow\"></span></a>
								<ul class=\"nav nav-second-level\">";
								echo "
								        <li><a href=\"override_all.php?lang=".$lang."&addr=all\" class=\"active\"><span style=\"color:red;\">
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
                            <a href="#"><i class="fa fa-clock-o fa-fw fa-3x"></i> <?php echo get_lang($lang,'k327'); ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="tempo.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k319'); ?></a></li>
                                <li><a href="tempo_filter.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k328'); ?></a></li>
                            </ul>
                        </li>
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
                        <h3 class="page-header text-asbestos"><i class="fa fa-legal"></i>&nbsp;<?php echo get_lang($lang,'k126'); ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
				<?php if ($user_settings['level'] > 10): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading"><?php echo get_lang($lang,'k152'); ?></div>
                            <div class="panel-body">
                                <div class="alert alert-danger">Security alert. This area is sensible...</div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                <?php
			        //get all routers
                    $query = "SELECT * FROM `routers` ORDER BY `router_name` ASC";
                    $result = mysql_query($query);
                    confirm_query($result);
                    if (mysql_num_rows($result) != 0) {
                        while($routers = mysql_fetch_array($result)) {
		                    $routers_list[] = $routers['router_name'];
	                    }
                    }
                    if (!empty($routers_list)) {
                    	$x=0;
                        foreach($routers_list as $router) {
                        	$r_settings = get_rout_settings($router);
							echo "
                    <div class=\"col-lg-6\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".$router."</div>
                            <div class=\"panel-body\">
                                <div class=\"divb\">
                                    <h5>".get_lang($lang,'k128')."&nbsp;".get_lang($lang,'k10')."</h5>
                                	<center>
                                    <div class=\"btn-group btn-group-lg\" id=\"mode\">
                                        <button type=\"button\" class=\"btn btn-danger\" id=\"off-".$x."\">".get_lang($lang,'off')."</button>
                                        <button type=\"button\" class=\"btn btn-default active\" id=\"med\" disabled=\"disabled\">".get_lang($lang,'k90')."</button>
                                        <button type=\"button\" class=\"btn btn-success\" id=\"on-".$x."\">".get_lang($lang,'on')."</button>
                                    </div>
                                    <script type=\"text/javascript\">
                                        var addr = '".$ad."';
                                        var ru_".$x." = '".$router."';
                                        $(function() {
                                            $(\"#off-".$x."\").on(\"click\", function (e) {
			                                    s_addr_".$x."(ru_".$x.",addr,'OFF');
                                            });
                                            $(\"#on-".$x."\").on(\"click\", function (e) {
			                                    s_addr_".$x."(ru_".$x.",addr,'ON');
                                            });
                                        });
                                        function s_addr_".$x."(r,addr,status) {
                                            var postData = { 'router' : r, 'action' : 'ADDR', 'addr' : addr, 'status' : status }; 
                                            $.ajax({
                                                url: 'k_handle_all.php',
                                                type: 'post',
                                                data: postData,
                                                success: function(result) {
			                                        $(\"#off-".$x."\").attr(\"disabled\", true);
                                                    $(\"#on-".$x."\").attr(\"disabled\", true);
		                                        },
                                                error: function(xhr, status, error) {
		                                            alert('error with s_addr');
                                                }
                                            });
                                        }
                                    </script>
						            </center>
                                </div>
                            </div>
                            <div class=\"panel-body\">
                                <div class=\"divb\">
                                    <h5>".get_lang($lang,'k132')."</h5>
                                    <center>
                                    <div class=\"btn-group btn-group-lg\" id=\"prog\">";
                                    //echo $r_settings['router_name'];
                                    /*
								    if ($r_settings['work_sche'] == "Off") {
									    echo "<button type=\"button\" class=\"btn btn-danger\" id=\"pg-off-".$x."\" disabled=\"disabled\">".get_lang($lang,'off')."</button>";
								    } else {
									    echo "<button type=\"button\" class=\"btn btn-danger\" id=\"pg-off-".$x."\">".get_lang($lang,'off')."</button>";
								    }
								    echo "<button type=\"button\" class=\"btn btn-default active\" disabled=\"disabled\">".get_lang($lang,'k90')."</button>";
								    if ($r_settings['work_sche'] == "On") {
									    echo "<button type=\"button\" class=\"btn btn-success\" id=\"pg-on-".$x."\" disabled=\"disabled\">".get_lang($lang,'on')."</button>";
								    } else {
									    echo "<button type=\"button\" class=\"btn btn-success\" id=\"pg-on-".$x."\">".get_lang($lang,'on')."</button>";
								    }
								    */ /* NEW 2016-08-08 */
								    echo "<button type=\"button\" class=\"btn btn-danger\" id=\"pg-off-".$x."\">".get_lang($lang,'off')."</button>";
								    echo "<button type=\"button\" class=\"btn btn-default active\" disabled=\"disabled\">".get_lang($lang,'k90')."</button>";
								    echo "<button type=\"button\" class=\"btn btn-success\" id=\"pg-on-".$x."\">".get_lang($lang,'on')."</button>";
								    /* END OF NEW */
							        echo "</div>
                                    <script type=\"text/javascript\">
                                        var pg = 'all';
	                                    var r_".$x." = '".$router."';
                                        $(function() {
                                            $(\"#pg-on-".$x."\").on(\"click\", function (e) {
			                                    s_prog_all_".$x."(r_".$x.",pg,'On');
                                            });
                                            $(\"#pg-off-".$x."\").on(\"click\", function (e) {
			                                    s_prog_all_".$x."(r_".$x.",pg,'Off');
                                            });
                                        });
                                        function s_prog_all_".$x."(r,pg,status) {
                                            var postData = { 'r': r, 'pg' : pg, 'status' : status }; 
                                            $.ajax({
                                                url: 'k_handle_prog_all.php',
                                                type: 'post',
                                                data: postData,
                                                success: function(result) {
			                                        $(\"#pg-on-".$x."\").attr(\"disabled\", true);
			                                        $(\"#pg-off-".$x."\").attr(\"disabled\", true);
		                                        },
                                                error: function(xhr, status, error) {
		                                            alert('error with s_prog_all');
                                                }
                                            });
                                        }
                                    </script>
						            </center>
                                    <div class=\"wo\">
                                        <script type=\"text/javascript\">
                                            $(function() {
 	                                            $('#wprog-".$x."').load('live_work_sche.php?lang=".$lang."&router=".$router."&x=');
                                                var refreshId = setInterval(function() {
                                                    $('#wprog-".$x."').load('live_work_sche.php?lang=".$lang."&router=".$router."&x='+ Math.random()); 
                                                },1000);
                                            });
                                        </script>
								        <div id=\"wprog-".$x."\"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
							$x++;
						}	
                    }
                ?>
				</div>
				<!-- /.row -->

				<?php else: ?>		
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <?php echo get_lang($lang,'Error'); ?>
                            </div>
                            <div class="panel-body">
							    <div class="alert alert-warning">
                                    <?php echo get_lang($lang,'k30'); ?>
								</div>
                            </div>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-primary btn-lg" onClick="document.location.href = 'index.php?lang=<?=$lang?>'; return false;">
								    <i class="fa fa-times"></i>&nbsp;<?php echo get_lang($lang,'k28'); ?></button>
                            </div>
                        </div>
                    </div>
				</div>
				<?php endif; ?>
				<!--end row-->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>

		<script type="text/javascript">

			var x1 = setTimeout(function(){ 
				//var k1 = '1001';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1001&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 1300);
			
			</script>
			
		<script type="text/javascript">

			var x2 = setTimeout(function(){ 
				//var k2 = '1501';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1501&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 2600);
			
			</script>
			
		<script type="text/javascript">

			var x3 = setTimeout(function(){ 
				//var k3 = '1601';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1601&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 3900);
			
			</script>
			
		<script type="text/javascript">

			var x4 = setTimeout(function(){ 
				//var k4 = '1602';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1602&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 5200);
			
			</script>
			
		<script type="text/javascript">

			var x5 = setTimeout(function(){ 
				//var k5 = '1603';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1603&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 6500);
			
			</script>
			
		<script type="text/javascript">

			var x6 = setTimeout(function(){ 
				//var k6 = '1604';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1604&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 7800);
			
			</script>
			
		<script type="text/javascript">

			var x7 = setTimeout(function(){ 
				//var k7 = '1605';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1605&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 9100);
			
			</script>
			
		<script type="text/javascript">

			var x8 = setTimeout(function(){ 
				//var k8 = '1606';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1606&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 10400);
			
			</script>
			
		<script type="text/javascript">

			var x9 = setTimeout(function(){ 
				//var k9 = '1607';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1607&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 11700);
			
			</script>
			
		<script type="text/javascript">

			var x10 = setTimeout(function(){ 
				//var k10 = '1608';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1608&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 13000);
			
			</script>
			
		<script type="text/javascript">

			var x11 = setTimeout(function(){ 
				//var k11 = '1609';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1609&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 14300);
			
			</script>
			
		<script type="text/javascript">

			var x12 = setTimeout(function(){ 
				//var k12 = '1610';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1610&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 15600);
			
			</script>
			
		<script type="text/javascript">

			var x13 = setTimeout(function(){ 
				//var k13 = '1611';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1611&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 16900);
			
			</script>
			
		<script type="text/javascript">

			var x14 = setTimeout(function(){ 
				//var k14 = '1612';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1612&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 18200);
			
			</script>
			
		<script type="text/javascript">

			var x15 = setTimeout(function(){ 
				//var k15 = '1613';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1613&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 19500);
			
			</script>
			
		<script type="text/javascript">

			var x16 = setTimeout(function(){ 
				//var k16 = '1701';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1701&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 20800);
			
			</script>
			
		<script type="text/javascript">

			var x17 = setTimeout(function(){ 
				//var k17 = '1702';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1702&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 22100);
			
			</script>
			
		<script type="text/javascript">

			var x18 = setTimeout(function(){ 
				//var k18 = '1703';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1703&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 23400);
			
			</script>
			
		<script type="text/javascript">

			var x19 = setTimeout(function(){ 
				//var k19 = '1704';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1704&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 24700);
			
			</script>
			
		<script type="text/javascript">

			var x20 = setTimeout(function(){ 
				//var k20 = '1705';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1705&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 26000);
			
			</script>
			
		<script type="text/javascript">

			var x21 = setTimeout(function(){ 
				//var k21 = '1706';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1706&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 27300);
			
			</script>
			
		<script type="text/javascript">

			var x22 = setTimeout(function(){ 
				//var k22 = '1707';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1707&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 28600);
			
			</script>
			
		<script type="text/javascript">

			var x23 = setTimeout(function(){ 
				//var k23 = '1708';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1708&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 29900);
			
			</script>
			
		<script type="text/javascript">

			var x24 = setTimeout(function(){ 
				//var k24 = '1709';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1709&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 31200);
			
			</script>
			
		<script type="text/javascript">

			var x25 = setTimeout(function(){ 
				//var k25 = '1801';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1801&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 32500);
			
			</script>
			
		<script type="text/javascript">

			var x26 = setTimeout(function(){ 
				//var k26 = '1802';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1802&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 33800);
			
			</script>
			
		<script type="text/javascript">

			var x27 = setTimeout(function(){ 
				//var k27 = '1803';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1803&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 35100);
			
			</script>
			
		<script type="text/javascript">

			var x28 = setTimeout(function(){ 
				//var k28 = '1804';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1804&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 36400);
			
			</script>
			
		<script type="text/javascript">

			var x29 = setTimeout(function(){ 
				//var k29 = '1805';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1805&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 37700);
			
			</script>
			
		<script type="text/javascript">

			var x30 = setTimeout(function(){ 
				//var k30 = '1806';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1806&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 39000);
			
			</script>
			
		<script type="text/javascript">

			var x31 = setTimeout(function(){ 
				//var k31 = '1807';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1807&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 40300);
			
			</script>
			
		<script type="text/javascript">

			var x32 = setTimeout(function(){ 
				//var k32 = '1808';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1808&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 41600);
			
			</script>
			
		<script type="text/javascript">

			var x33 = setTimeout(function(){ 
				//var k33 = '1809';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1809&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 42900);
			
			</script>
			
		<script type="text/javascript">

			var x34 = setTimeout(function(){ 
				//var k34 = '1810';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1810&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 44200);
			
			</script>
			
		<script type="text/javascript">

			var x35 = setTimeout(function(){ 
				//var k35 = '1811';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1811&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 45500);
			
			</script>
			
		<script type="text/javascript">

			var x36 = setTimeout(function(){ 
				//var k36 = '1901';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1901&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 46800);
			
			</script>
			
		<script type="text/javascript">

			var x37 = setTimeout(function(){ 
				//var k37 = '1902';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1902&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 48100);
			
			</script>
			
		<script type="text/javascript">

			var x38 = setTimeout(function(){ 
				//var k38 = '1903';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1903&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 49400);
			
			</script>
			
		<script type="text/javascript">

			var x39 = setTimeout(function(){ 
				//var k39 = '1904';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1904&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 50700);
			
			</script>
			
		<script type="text/javascript">

			var x40 = setTimeout(function(){ 
				//var k40 = '1905';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1905&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 52000);
			
			</script>
			
		<script type="text/javascript">

			var x41 = setTimeout(function(){ 
				//var k41 = '1906';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1906&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 53300);
			
			</script>
			
		<script type="text/javascript">

			var x42 = setTimeout(function(){ 
				//var k42 = '1907';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1907&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 54600);
			
			</script>
			
		<script type="text/javascript">

			var x43 = setTimeout(function(){ 
				//var k43 = '1908';


				$.ajax({
					url: 'k_handle_setpoint_fix2.php?router=Boss&kinv=1908&action=SP&first=1&second=24',
					//dataType: 'json',
					type: 'GET',
					contentType: 'application/json',
					success: function(data,textStatus,jQxhr){
					  console.log(data);
					  
					},
					error: function(jqXhr,textStatus,errorThrown){
					  console.log(errorThrown);
					},
					timeout: 3000
				  });

			}, 55900);
			
			</script>
			
    </body>
</html>