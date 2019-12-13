<?php
error_reporting(E_ALL);
define('start',TRUE);
include("../../../inc/db.php");
include("../../../inc/functions.php");
include("../../../inc/config.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
        <meta name="description" content="<?=$app?>" />
        <meta name="keywords" content="<?=$app?>" />
        <title><?=$app?></title>
        <meta name="AUTHOR" content="ALEX SOARES | Алекс Соарес" />
        <meta name="GENERATOR" content="POWERED BY KA-EX" />
        <meta name="VERSION" content="1.0" />
        <meta name="CREATED" content="2017-10-01" />
        <meta name="language" content="<?=$lang_name?>" />
        <meta name="hash" content="<?=$hash?>" />
        <!-- FEVICON AND TOUCH ICON -->
        <link rel="shortcut icon" type="image/x-icon" href="<?=$config['base_url']?>/assets/dist/img/ico/favicon.png" />
        <link rel="apple-touch-icon" type="image/x-icon" href="<?=$config['base_url']?>/assets/dist/img/ico/apple-touch-icon-57-precomposed.png" />
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?=$config['base_url']?>/assets/dist/img/ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?=$config['base_url']?>/assets/dist/img/ico/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?=$config['base_url']?>/assets/dist/img/ico/apple-touch-icon-144-precomposed.png" />
        <!-- STATRT GLOBAL MANDATORY STYLE -->
        <link rel="stylesheet" type="text/css" href="<?=$config['base_url']?>/assets/dist/css/base.css" />
        <!-- START PAGE LABEL PLUGINS --> 
        <!-- START THEME LAYOUT STYLE -->
        <link rel="stylesheet" type="text/css" href="<?=$config['base_url']?>/assets/dist/css/component_ui.css" />
        <link rel="stylesheet" type="text/css" href="<?=$config['base_url']?>/assets/dist/css/skins/black.css" />
        <link rel="stylesheet" type="text/css" href="<?=$config['base_url']?>/assets/dist/css/extend.css" />
        <link rel="stylesheet" type="text/css" href="<?=$config['base_url']?>/assets/dist/css/ka-ex.css" />
        <!--[if lt IE 9]>
            <script type="text/javascript" src="<?=$config['base_url']?>/assets/dist/js/html5shiv.js"></script>
            <script type="text/javascript" src="<?=$config['base_url']?>/assets/dist/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="has-particles">
        <!-- Particles -->
        <div id="particles-js"></div>
        <!-- /particles -->
        <div class="login-wrapper has-particles">
            <div class="middle-box2 text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="error-text2"><h1>403</h1></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="error-desc2">
                            <p><?=$k022?><br/><?=$k023?></p>
                            <a href="<?=$config['base_url']?>/index.php" class="btn btn-success btn-lg"><?=$k012?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="<?=$config['base_url']?>/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- bootstrap js-->
        <script src="<?=$config['base_url']?>/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!--Particles-->
        <script type="text/javascript" src="<?=$config['base_url']?>/assets/plugins/particles/js/particles.js"></script>
        <script type="text/javascript" src="<?=$config['base_url']?>/assets/plugins/particles/js/particles-script.js"></script>
    </body>
</html>