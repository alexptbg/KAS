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
		<link type="text/css" rel="stylesheet" href="js/plugins/dataTables/dataTables.bootstrap.css" />
        <script type="text/javascript" src="js/plugins/dataTables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
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
                                <li>
                                    <a href="users.php?lang=<?=$lang?>"><?php echo get_lang($lang, 'k12'); ?></a>
                                </li>
                                <li class="active">
                                    <a class="active" href="logs.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k13'); ?></a>
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
                        <h3 class="page-header text-asbestos"><i class="fa fa-align-left"></i> <?php echo get_lang($lang, 'k13'); ?></h3>
                    </div>
                </div>
				
                <?php
                $m_ago = date("Y-m-d",strtotime("first day of previous month"));
				if ($user_settings['level'] > 10) {
                    $query = "SELECT * FROM `users` WHERE `user_name`='".$user."'";
                    $result = mysql_query($query);
                    confirm_query($result);
                    if (mysql_num_rows($result) != 0) {
		                while($users = mysql_fetch_array($result)) {
							if ($users['user_name'] != 'Alex') {
                            //while
						echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">".$users['user_name']."</div>
                            <div class=\"panel-body\">
                                <div class=\"table-responsive\">
                                    <table class=\"table table-striped table-bordered table-hover\">
                                        <tbody>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k05').":</td>
												<td>".$users['user_name']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k88').":</td>
												<td>".$users['first_name']." ".$users['last_name']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k91').":</td>
												<td>".$users['email']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k92').":</td>
												<td>".$users['phone']."</td>
											</tr>
											<tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k89').":</td>";
									if ($users['level'] < 3) {
										echo "<td><span class=\"label label-danger\">".$users['level']."</span></td>";
									}
									elseif (($users['level'] < 5) && ($users['level'] > 2)) {
										echo "<td><span class=\"label label-warning\">".$users['level']."</span></td>";
									}
									elseif (($users['level'] < 10) && ($users['level'] > 4)) {
										echo "<td><span class=\"label label-success\">".$users['level']."</span></td>";
									}
									elseif (($users['level'] < 100) && ($users['level'] > 9)) {
										echo "<td><span class=\"label label-info\">".$users['level']."</span></td>";
									}
									elseif ($users['level'] > 50) {
										echo "<td><span class=\"label label-primary\">".$users['level']."</span></td>";
									}
					                else {
						                echo "<td><span class=\"label label-default\">".$users['level']."</span></td>";
					                }
									echo "</tr>
											<tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k90').":</td>";
									//status
					                if ($users['status'] == "Active") {
						                echo "<td><span class=\"label label-success\">".get_lang($lang, 'k93')."</span></td>";
					                }
					                elseif ($users['status'] == "Pending") {
						                echo "<td><span class=\"label label-warning\">".get_lang($lang, 'k94')."</span></td>";
					                }
					                elseif ($users['status'] == "Deactivated") {
						                echo "<td><span class=\"label label-danger\">".get_lang($lang, 'k95')."</span></td>";
					                }
					                else {
						                echo "<td>".$users['status']."</td>";
					                }
									echo "</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k116').":</td>
												<td>".$users['last_login']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k120').":</td>
												<td>".$users['device']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k99').":</td>
												<td>".$users['info']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k43').":</td>
												<td>".$users['buildings']."</td>
											</tr>
                                            <tr>
                                                <td style=\"text-align: right; width: 50%;\">".get_lang($lang, 'k10').":</td>
												<td>".$users['klimas']."</td>
											</tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>";
							}
						}
                    $query = "SELECT * FROM `logs` WHERE `user`='".$user."' AND `date` > '".$m_ago."' ORDER BY `id` DESC";
                    $result = mysql_query($query);
                    confirm_query($result);
                    if (mysql_num_rows($result) != 0) {
								echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">".get_lang($lang, 'k13')."</div>
                            <div class=\"panel-body\">
								<div class=\"table-responsive\">
                                    <table class=\"table table-striped table-bordered table-hover\" id=\"logs_user\">
                                        <thead>
                                            <tr>
                                                <th>".get_lang($lang, 'k27')."</th>
                                                <th>".get_lang($lang, 'k117')."</th>
                                                <th>".get_lang($lang, 'k118')."</th>
                                                <th>".get_lang($lang, 'k120')."</th>
                                                <th>".get_lang($lang, 'k119')."</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
		                while($logs = mysql_fetch_array($result)) {
							if ($user != 'Alex') {
								echo "<tr>
								        <td>".$logs['id']."</td>";
								if (date('Y-m-d') == date('Y-m-d', strtotime($logs['date']))) {
									echo "<td class=\"log\"><span class=\"success\">".$logs['date']."</span></td>";
								} else {
									echo "<td>".$logs['date']."</td>";
								}	
								echo   "<td>".$logs['time']."</td>
										<td>".$logs['device']."</td>
										<td class=\"log\">
										    <span class=\"primary\">".$logs['user']."</span>&nbsp;
											<span class=\"".$logs['filter']."\">".get_lang($lang,$logs['action'])." (".$logs['obs'].")</span></td>
									</tr>";
							}
						}
					    echo "
	                                    </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class=\"panel-footer\">";
                            if ($user_settings['level'] > 20) {
                                echo "<button type=\"button\" class=\"btn btn-danger btn-lg\" onClick=\"document.location.href = 'logs_user_del.php?lang=".$lang."&user=".$user."'\"><i class=\"fa fa-trash-o\"></i>&nbsp;".get_lang($lang, 'k170')." ".$user."</button>";
							} else {
								echo "<button type=\"button\" class=\"btn btn-danger btn-lg\" onClick=\"document.location.href = 'logs_user_del.php?lang=".$lang."&user=".$user."'\" disabled=\"disabled\"><i class=\"fa fa-trash-o\"></i>&nbsp;".get_lang($lang, 'k170')." ".$user."</button>";
							}
							echo "
                            </div>
                        </div>
                    </div>
				</div>";
                    } else {
						//echo no logs for this user
			        echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-primary\">
                            <div class=\"panel-heading\">".get_lang($lang, 'k13')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-info\">".get_lang($lang, 'k121')."</div>
                            </div>
                        </div>
                    </div>
				</div>";
					}
			    } else {
			        echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang, 'Error')."</div>
                            <div class=\"panel-body\">
                                <div class=\"alert alert-warning\">
                                    ".get_lang($lang, 'k96')."
                                </div>
                            </div>
                            <div class=\"panel-footer\">
                              <button type=\"button\" class=\"btn btn-primary btn-lg\" onClick=\"document.location.href = 'users_add.php?lang=".$lang."'\">
							    <i class=\"fa fa-plus\"></i>&nbsp;".get_lang($lang, 'k97')."</button>
                            </div>
                        </div>
                    </div>
				</div>";
				}
			} else {
				echo "
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-danger\">
                            <div class=\"panel-heading\">".get_lang($lang, 'Error')."</div>
                            <div class=\"panel-body\">
							    <div class=\"alert alert-warning\">
                                    ".get_lang($lang, 'k30')."
								</div>
                            </div>
                            <div class=\"panel-footer\">
                                <button type=\"button\" class=\"btn btn-primary btn-lg\" onClick=\"document.location.href = 'index.php?lang=".$lang."'; return false;\">
								    <i class=\"fa fa-times\"></i>&nbsp;".get_lang($lang, 'k28')."</button>
                            </div>
                        </div>
                    </div>
				</div>";
			}
			?>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
        <script type="text/javascript">
        $(function () {
            if(jQuery().dataTable) {
         if($("#logs_user").length > 0) { 
             $('#logs_user').dataTable({
			     "aaSorting": [[ 0, "desc" ]],
				 "iDisplayLength": 50,
				 "aLengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Всички"]],
                 "aoColumns": [
				     { "bSearchable": false },
					 { "bSortable": false },
					 { "bSortable": false },
					 { "bSortable": false },
					 { "bSortable": false }					 
                 ],
		         "oLanguage": {
			         "sLengthMenu": "Показване _MENU_ на записи на страница.",
			         "sSearch": "Търсене: ",
			         "sZeroRecords": "Нищо не е намерено - Съжалявам",
			         "sInfo": "Показващ _START_ от _TOTAL_ общо записи",
			         "sInfoEmpty": "Показващ 0 от 0 общо записи",
			         "sInfoFiltered": "(филтрира от _MAX_ общо записи)",
                     "oPaginate": {
                         "sFirst":    "Първи",
                         "sPrevious": "Предишен",
                         "sNext":     "Напред",
                         "sLast":     "Последно"
                     }
                 }
		});
        }
			}
		});
        </script>
    </body>
</html>