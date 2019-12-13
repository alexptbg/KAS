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
if(date('d')==="01") {
    $month_ini = new DateTime("first day of last month");
    $month_ago = $month_ini->format('Y-m-d');
} else {
    $month_ini = new DateTime("first day of this month");
    $month_ago = $month_ini->format('Y-m-d');
}
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
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/plugins/moment/moment.min.js"></script>
		<link type="text/css" rel="stylesheet" href="js/plugins/datepicker/css/bootstrap-datetimepicker.min.css" />
		<script type="text/javascript" src="js/plugins/moment/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="js/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
		<link type="text/css" rel="stylesheet" href="js/plugins/dataTables/dataTables.bootstrap.css" />
        <script type="text/javascript" src="js/plugins/dataTables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="js/plugins/dataTables/jquery.dataTables.columnFilter.js"></script>
		<link type="text/css" rel="stylesheet" href="js/plugins/dataTables/plugins/TableTools/css/dataTables.tableTools.min.css" />
		<script type="text/javascript" src="js/plugins/dataTables/plugins/TableTools/js/dataTables.tableTools.min.js"></script>
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
                        <li class="active">
                            <a href="#" class="active"><i class="fa fa-clock-o fa-fw fa-3x"></i> <?php echo get_lang($lang,'k327'); ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li class="active"><a class="active" href="tempo.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k319'); ?></a></li>
                                <!--<li><a href="tempo_all.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k128'); ?></a></li>-->
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
                        <h3 class="page-header text-asbestos"><i class="fa fa-line-chart"></i>&nbsp;<?php echo get_lang($lang,'k320'); ?></h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
				<!--start row-->
                <div class="row">
                    <?php
                    $query = "SELECT `router_name` FROM `routers` ORDER BY `router_name` ASC";
                    $result = mysql_query($query);
                    confirm_query($result);
                    if (mysql_num_rows($result) != 0) {
                        $i=1;
                        $z=1;
                        while($routers = mysql_fetch_array($result)) {
                            $mindate = get_first_entry_for_tempo($routers['router_name']);
                            echo "
                        <div class=\"col-lg-12\">
                            <div class=\"panel panel-primary\">
                                <div class=\"panel-heading\">
                                    ".$routers['router_name']."
                                </div>
                                <div class=\"panel-body\">
                                    <div class=\"router-".$i."\" id=\"r".$i."\">
                                    <div class=\"col-lg-3 col-sm-6\">
                                        <div class=\"form-group\">
                                            <div class=\"input-group date\" id=\"datetimepicker".$z."\">
                                                <input type=\"text\" class=\"form-control\" value=\"".$month_ago."\" readonly=\"readonly\" />
                                                <span class=\"input-group-addon\">
                                                    <span class=\"glyphicon glyphicon-calendar\"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <script type=\"text/javascript\">
                                    $(function () {
                                        $('#datetimepicker".$z."').datetimepicker({
                                            locale: 'bg',
                                            format: 'YYYY-MM-DD',
                                            ignoreReadonly: true,
                                            maxDate : 'now',
                                            minDate : '".$mindate."'
                                        });
                                        $('#datetimepicker".$z."').on('dp.change', function (e) {
                                            $('#datetimepicker".($z+1)."').data('DateTimePicker').minDate(e.date);
                                        });
                                    });
                                    </script>
                                    ";
                            $z++;
                            echo "
                                    <div class=\"col-lg-3 col-sm-6\">
                                        <div class=\"form-group\">
                                            <div class=\"input-group date\" id=\"datetimepicker".$z."\">
                                                <input type=\"text\" class=\"form-control\" value=\"".$today_e."\" readonly=\"readonly\" />
                                                <span class=\"input-group-addon\">
                                                    <span class=\"glyphicon glyphicon-calendar\"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <script type=\"text/javascript\">
                                    $(function () {
                                        $('#datetimepicker".$z."').datetimepicker({
                                            locale: 'pt',
                                            format: 'YYYY-MM-DD',
                                            ignoreReadonly: true,
                                            maxDate : 'now',
                                            minDate : '".$mindate."',
                                            useCurrent: false
                                        });
                                        $('#datetimepicker".$z."').on('dp.change', function (e) {
                                            $('#datetimepicker".($z-1)."').data('DateTimePicker').maxDate(e.date);
                                        });
                                    });
                                    </script>
                                    </div>
                                    <div class=\"col-lg-4 col-sm-6\">
                                        <label>".get_lang($lang,"k325").":</label>
                                        <select name=\"filter\" class=\"form-control\" style=\"width:45% !important;display:inline-block;\">
                                            <option value=\"480\">8 ".get_lang($lang,"k309")."</option>
                                            <option value=\"960\">16 ".get_lang($lang,"k309")."</option>
                                            <option value=\"1440\">24 ".get_lang($lang,"k309")."</option>
                                            <option value=\"1920\">32 ".get_lang($lang,"k309")."</option>
                                            <option value=\"2400\">40 ".get_lang($lang,"k309")."</option>
                                        </select>
                                        <button type=\"button\" class=\"btn btn-success\" id=\"top-$i\"><i class=\"fa fa-filter\" aria-hidden=\"true\"></i>&nbsp;".get_lang($lang,'k319')."&nbsp;</button>
                                    </div>
                                    <script type=\"text/javascript\">
                                    $(function () {
                                        var r = '".$routers['router_name']."';
                                        $(\"button#get-".$i."\").on('click', function(e, data) {
                                            $(\"div.resp".$i."\").html(\"\");
                                            var month_ini = $(\"#datetimepicker".($z-1)." input\").val();
                                            var month_end = $(\"#datetimepicker".$z." input\").val();
                                            $(\"div.resp".$i."\").html(\"".get_lang($lang,"k308")."\");
                                            datastr = { 'lang':'".$lang."', 'r': r, 'month_ini': month_ini, 'month_end': month_end };
                                            $.ajax({
                                                url: 'tempo_ajax.php',
                                                //dataType: 'json',
                                                type: 'GET',
                                                contentType: 'application/json',
                                                data: datastr,
                                                success: function(data,textStatus,jQxhr){
                                                    //console.log(data);
                                                    $(\"div.resp".$i."\").html(data);
                                                },
                                                error: function(jqXhr,textStatus,errorThrown){
                                                    console.log(errorThrown);
                                                    $(\"div.resp".$i."\").html('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;".get_lang($lang,'1000')."</div>');
                                                },
                                                timeout: 15000
                                            });

                                        });
                                        //TOP
                                        $(\"button#top-".$i."\").on('click', function(e, data) {
                                            $(\"div.resp".$i."\").html(\"\");
                                            var month_ini = $(\"#datetimepicker".($z-1)." input\").val();
                                            var month_end = $(\"#datetimepicker".$z." input\").val();
                                            var filter = $(\"select[name='filter']\").val();
                                            $(\"div.resp".$i."\").html(\"".get_lang($lang,"k308")."\");
                                            datastr = { 'lang':'".$lang."', 'r': r, 'month_ini': month_ini, 'month_end': month_end, 'filter': filter };
                                            $.ajax({
                                                url: 'tempo_top.php',
                                                //dataType: 'json',
                                                type: 'GET',
                                                contentType: 'application/json',
                                                data: datastr,
                                                success: function(data,textStatus,jQxhr){
                                                    //console.log(data);
                                                    $(\"div.resp".$i."\").html(data);
                                                },
                                                error: function(jqXhr,textStatus,errorThrown){
                                                    console.log(errorThrown);
                                                    $(\"div.resp".$i."\").html('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;".get_lang($lang,'1000')."</div>');
                                                },
                                                timeout: 15000
                                            });
                                        });
                                        $(\"button#top-".$i."\").click();
                                    });
                                    </script>
                                </div>
                                <div style=\"margin:0px 30px 30px 30px;\" class=\"resp".$i."\" id=\"resp".$i."\"></div>
                                <script type=\"text/javascript\"> 
                                function printDiv".substr($routers['router_name'],0,4)."() { 
                                    var divContents = document.getElementById(\"resp".$i."\").innerHTML; 
                                    var a = window.open('', '', 'height=800, width=800'); 
                                    a.document.write('<html>');
                                    a.document.write('<style>table{width:100%;border:1px solid #000000;}table tr th{border:1px solid #000000 !important;}table tr td{border:1px solid #000000 !important;}button{display:none !important;}</style>');
                                    a.document.write('<body>'); 
                                    a.document.write(divContents); 
                                    a.document.write('</body></html>'); 
                                    a.document.close(); 
                                    a.print(); 
                                } 
                            </script>
                            </div>
                        </div>
                            ";
                            $i++;
                            $z++;
                        }
                        
                    }
                    ?>
                </div>
				<!--end row-->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>