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
        <link type="text/css" rel="stylesheet" href="css/entypo.css" />
        <link type="text/css" rel="stylesheet" href="css/mint-admin.css" />
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/plugins/moment/moment.min.js"></script>
		<link type="text/css" rel="stylesheet" href="js/plugins/datepicker/css/bootstrap-datetimepicker.min.css" />
		<script type="text/javascript" src="js/plugins/moment/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="js/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
        <!-- datatables -->
        <link type="text/css" rel="stylesheet" href="js/datatables/css/jquery.dataTables.css" />
        <link type="text/css" rel="stylesheet" href="js/datatables/extensions/Buttons/css/buttons.dataTables.css" />
        <script type="text/javascript" src="js/datatables/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/datatables/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="js/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="js/datatables/js/jszip.min.js"></script>
        <script type="text/javascript" src="js/datatables/js/pdfmake.min.js"></script>
        <script type="text/javascript" src="js/datatables/js/vfs_fonts.js"></script>
        <script type="text/javascript" src="js/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="js/datatables/extensions/Buttons/js/buttons.print.min.js"></script>
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
                                <li><a href="tempo.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k319'); ?></a></li>
                                <!--<li><a href="tempo_all.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k128'); ?></a></li>-->
                                <li class="active"><a class="active" href="tempo_filter.php?lang=<?=$lang?>"><?php echo get_lang($lang,'k328'); ?></a></li>
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
                        <h3 class="page-header text-asbestos"><i class="fa fa-filter"></i>&nbsp;<?php echo get_lang($lang,'k328'); ?></h3>
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
                        while($routers = mysql_fetch_array($result)) {
                            echo "
                        <div class=\"col-lg-12\">
                            <div class=\"panel panel-primary\">
                                <div class=\"panel-heading\">
                                    ".$routers['router_name']."
                                </div>
                                <div class=\"panel-body\">
                                    <div class=\"router-".$i."\" id=\"r".$i."\">";
                                    $query1 = "SELECT `inv`,`floor`,`last_cleaned` FROM `klimatiki` WHERE `router`='".$routers['router_name']."' ORDER BY `inv` ASC";
                                    $result1 = mysql_query($query1);
                                    confirm_query($result1);
                                    if (mysql_num_rows($result1) != 0) {
                                        echo "
                                        <div class=\"table-responsive\" id=\"res\">
                                        <table class=\"table table-striped table-bordered table-hover\" id=\"filter-".$i."\">
                                            <thead>
                                                <tr style=\"text-transform:uppercase;\"><th>".get_lang($lang,'k49')."</th><th>".get_lang($lang,'k44')."</th><th>".get_lang($lang,'k323')."</th><th>".get_lang($lang,'k330')."</th><th>".get_lang($lang,'k329')."</th><th>SET new date</th></tr>
                                            </thead>
                                            <tbody>
                                        ";
                                        while($row1 = mysql_fetch_array($result1)) {
                                            if (empty($row1['last_cleaned'])) {
                                                $last_cleaned = "N/A";
                                                $since = get_lang($lang,'k302');
                                            } else {
                                                $datex = new DateTime($row1['last_cleaned']);
                                                $last_cleaned = $datex->format('Y-m-d');
                                                $since = $last_cleaned;
                                            }
                                            $t = get_filter_hours($routers['router_name'],$row1['inv'],$last_cleaned);
                                            if (empty($t)) {
                                                $total = 0;
                                            } else {
                                                $total = convertToHoursMins($t,"%02d ".get_lang($lang,'k309')." %02d ".get_lang($lang,'k197'));
                                            }
                                            echo "
                                                <tr><td>".$row1['inv']."</td><td>".$row1['floor']."</td><td>".$since."</td><td>".$t."</td><td>".$total."</td><td><input type=\"text\" name=\"date\" data-inv=\"".$row1['inv']."\" value=\"".$today_e."\" id=\"datetimepicker-".$i."\" />&nbsp;&nbsp;";
                                                if ($user_settings['level'] > 20) {
                                                    echo "
                                                  <button type=\"button\" class=\"btn btn-danger btn-sm set_clean-".$i."\" id=\"set_clean-".$i."\">
                                                    <i class=\"fa fa-save\"></i>&nbsp;".get_lang($lang,'k306')."&nbsp;</button>";
                                                } else {
                                                    echo "
                                                  <button type=\"button\" class=\"btn btn-danger btn-sm\" disabled=\"disabled\">
                                                    <i class=\"fa fa-save\"></i>&nbsp;".get_lang($lang,'k306')."&nbsp;</button>";
                                                }
                                            echo "
                                                  <span class=\"resp-".$i."\">Z</span>
                                                </td></tr>
                                            ";
                                        }
                                        echo "
                                            </tbody>
                                        </table>
                                        <script type=\"text/javascript\">
                                        $(function () {
                                            //table
                                            if(jQuery().dataTable) {
                                                $.extend(true,$.fn.dataTable.defaults, {
                                                    \"language\": {
                                                        \"buttons\": {
                                                            copyTitle: 'Копиране в клипборда',
                                                            copySuccess: {
                                                                _: '%d копирани редове',
                                                                1: '1 ред копиран'
                                                            }
                                                        }
                                                    }           
                                                });
                                                if($(\"#filter-".$i."\").length > 0) { 
                                                    $(\"#filter-".$i."\").DataTable({
                                                        dom: '<\"html5buttons\" B>lTfgitp',
                                                        buttons: [
                                                        {
                                                            extend: 'copyHtml5',
                                                            text: 'Копи',
                                                            exportOptions: {
                                                                columns: [ 0, 1, 2, 3, 4 ]
                                                            },
                                                            title: \"".$routers['router_name']." - ".get_lang($lang,'k328')."\"
                                                        },
                                                        {
                                                            extend: 'excelHtml5',
                                                            exportOptions: {
                                                                columns: [ 0, 1, 2, 3, 4 ]
                                                            },
                                                            title: \"".$routers['router_name']." - ".get_lang($lang,'k328')."\"
                                                        },
                                                        {
                                                            extend: 'pdfHtml5',
                                                            exportOptions: {
                                                                columns: [ 0, 1, 2, 3, 4 ]
                                                            },
                                                            customize: function(doc) {
                                                                doc.defaultStyle.fontSize = 8;
                                                            },
                                                            title: \"".$routers['router_name']." - ".get_lang($lang,'k328')."\"
                                                        },
                                                        {    
                                                            extend: 'print',
                                                            orientation: 'portrait',
                                                            text: 'Печат',
                                                            exportOptions: {
                                                                columns: [ 0, 1, 2, 3, 4 ]
                                                            }
                                                        }
                                                        ],
                                                        \"aoColumns\": [
                                                            { \"bSearchable\": true, \"bSortable\": true },
                                                            { \"bSearchable\": false, \"bSortable\": false },
                                                            { \"bSearchable\": false, \"bSortable\": false },
                                                            { \"bSearchable\": false, \"bSortable\": true },
                                                            { \"bSearchable\": false, \"bSortable\": false },
                                                            { \"bSearchable\": false, \"bSortable\": false }
                                                        ],
                                                        \"aaSorting\": [[ 0, \"asc\" ]],
                                                        \"iDisplayLength\": -1,
                                                        \"aLengthMenu\": [[-1], [\"Всички\"]],
                                                        \"bLengthChange\" : false,
                                                        \"bInfo\" : false, 
                                                        \"oLanguage\": {
                                                            \"sLengthMenu\": \"Показване на _MENU_ резултата.\",
                                                            \"sSearch\": \"Търсене: \",
                                                            \"sZeroRecords\": \"Няма намерени резултати.\",
                                                            \"sInfo\": \"Показване на резултати _START_ от _END_ до _TOTAL_ общо записи.\",
                                                            \"sInfoEmpty\": \"Показване на резултати 0 от 0 общо записи.\",
                                                            \"sInfoFiltered\": \"(филтрира от _MAX_ общо записи)\",
                                                            \"oPaginate\": {
                                                                \"sFirst\":    \"Първа\",
                                                                \"sPrevious\": \"Предишна\",
                                                                \"sNext\":     \"Следваща\",
                                                                \"sLast\":     \"Последна\"
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                            //table end
                                            //datetimepicker test
                                            $('input#datetimepicker-".$i."').datetimepicker({
                                                locale: 'bg',
                                                format: 'YYYY-MM-DD',
                                                ignoreReadonly: true,
                                                maxDate : 'now',
                                                minDate : '".$month_ago."'
                                            });
                                            var question = \"".get_lang($lang,'k305')."\";
                                            var r = \"".$routers['router_name']."\";
                                            //button actions here
                                            //$(\".set_clean-".$i."\").each(function(index) {
                                                $(\".set_clean-".$i."\").on(\"click\", function(){
                                                    //var idx = $(this).attr('id');
                                                    //var date = $(this).closest(\"tr\").find(\"input#datetimepicker-".$i."\").val();
                                                    //var inv = $(this).closest(\"tr\").find(\"input#datetimepicker-".$i."\").data(\"inv\");
                                                    var date = $(this).parent().find(\"input#datetimepicker-".$i."\").val();
                                                    var inv = $(this).parent().find(\"input#datetimepicker-".$i."\").data(\"inv\");
                                                    var ele = $(this).parent().find(\"span#resp-".$i."\");
                                                    console.log(r);
                                                    console.log(date);
                                                    console.log(inv);
                                                    if (confirm(question)) {
                                                        datastr = { 'lang':'".$lang."', 'r': r, 'i': inv, 'd': date };
                                                        console.log(datastr);
                                                        $.ajax({
                                                            url: 'update_clean_filter.php',
                                                            dataType: 'json',
                                                            type: 'GET',
                                                            contentType: 'application/json',
                                                            data: datastr,
                                                            success: function(data,textStatus,jQxhr){
                                                                if(data===\"OK\") {
                                                                    console.log(data);
                                                                    infoModal(\"".get_lang($lang,'k328')."\",\"".get_lang($lang,'k307')."\",\"#5CB85C\");
                                                                } else {
                                                                    infoModal(\"".get_lang($lang,'k328')."\",\"".get_lang($lang,'1000')."\",\"#d9534f\");
                                                                }
                                                            },
                                                            error: function(jqXhr,textStatus,errorThrown){
                                                                console.log(errorThrown);
                                                                infoModal(\"".get_lang($lang,'k328')."\",\"".get_lang($lang,'1000')."\",\"#d9534f\");
                                                            },
                                                            timeout: 3000
                                                        });
                                                        setTimeout(function(){
                                                            jQuery(\"#infoModal\").modal(\"hide\");
                                                        },3000);
                                                    }
                                                });
                                            //});
                                        });
                                        </script>
                                        </div>
                                        ";
                                    }
                            echo "
                                    </div>
                                </div>
                            </div>
                        </div>
                        ";
                        $i++;
                        }                        
                    }
                    ?>
                </div>
				<!--end row-->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- Modal small -->
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLongTitle">Modal title</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- Modals end -->
        <!-- /#wrapper -->
		<a href="#" id="toTop"><i class="fa fa-arrow-up"></i></a>
    </body>
</html>