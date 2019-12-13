<?php
error_reporting(E_ALL);
define('start', TRUE);
include('inc/db.php');
include('inc/functions.php');
include('inc/init.php');
DataBase::getInstance()->connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
include('inc/config.php');
check_login($lang,$web_dir);
$r = $_GET['r'];
$b = $_GET['b'];
$f = $_GET['f'];
$i = $_GET['i'];
$r_settings = get_rout_settings($r);
$klima = get_klima_settings($i);
if($klima['type'] == "1") { $class="primary"; } else { $class="success"; }
//print_r(get_tempos_by_month($r,$i));
$last_cleaned = get_tempo_last_cleaned($r,$i);
if($last_cleaned === "N/A") {
    $cleaned = get_lang($lang,'k302');
    $since = "N/A";
} else {
    $cleaned = $last_cleaned;
    $since = $last_cleaned;
}
//echo $cleaned;
echo "
<div class=\"col-lg-12\">
    <div class=\"panel panel-".$class."\">
        <div class=\"panel-heading\">".get_lang($lang,'k301')."</div>
        <div class=\"panel-body\">";
    echo "
    <div class=\"table-responsive\">
    <table class=\"table table-striped\" style=\"margin-bottom:0;\">
        <tbody>
            <tr>
                <td>".get_lang($lang,'k303').":&nbsp;&nbsp;<span id=\"cleaned\">".$cleaned."</span></td>
                <td>
                    ".get_lang($lang,'k304').":&nbsp;&nbsp;<input type=\"text\" name=\"date\" value=\"".$today_e."\" readonly=\"readonly\" id=\"datetimepicker\" />&nbsp;&nbsp;";
                    if ($user_settings['level'] > 20) {
                        echo "
                      <button type=\"button\" class=\"btn btn-danger btn-sm\" id=\"set_clean\">
                        <i class=\"fa fa-save\"></i>&nbsp;".get_lang($lang,'k306')."&nbsp;</button>";
                    } else {
                        echo "
                      <button type=\"button\" class=\"btn btn-danger btn-sm\" disabled=\"disabled\" id=\"set_clean\">
                        <i class=\"fa fa-save\"></i>&nbsp;".get_lang($lang,'k306')."&nbsp;</button>";
                    }
                    echo "
                    <div class=\"resp\"></div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <HR>
    ";
    //continue
    echo "<div class=\"data\">".get_lang($lang,'k308')."</div>";
        echo "
        </div>
    </div>
</div>";
DataBase::getInstance()->disconnect();
$month_ini = new DateTime("first day of last month");
$month_ago = $month_ini->format('Y-m-d');
?>
<script type="text/javascript">
    $('div.data').load('k_t_extend.php?lang=<?=$lang?>&r=<?=$r?>&b=<?=$b?>&f=<?=$f?>&i=<?=$i?>&x=');
    var set_cleaned = $("#datetimepicker").val();
    $(function () {
        $('input#datetimepicker').datetimepicker({
            locale: 'bg',
            format: 'YYYY-MM-DD',
            ignoreReadonly: true,
            maxDate : 'now',
            minDate : '<?php echo $month_ago; ?>'
        });
    });
    var question = "<?php echo get_lang($lang,'k305'); ?>";
    var r = "<?php echo $r; ?>";
    var i = "<?php echo $i; ?>";
    $('#set_clean').on('click', function(e, data) {
        d = $("#datetimepicker").val();
        if (confirm(question)) {
            $("div.resp").html("");
            datastr = { 'lang':'<?=$lang?>', 'r': r, 'i': i, 'd': d };
            $.ajax({
                url: 'update_clean_filter.php',
                dataType: 'json',
                type: 'GET',
                contentType: 'application/json',
                data: datastr,
                success: function(data,textStatus,jQxhr){
                    $("div.resp").html("");
                    if(data==="OK") {
                        $("div.data").html("");
                        $("span#cleaned").text(d);
                        $("div.resp").html('<div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?php echo get_lang($lang,'k307'); ?></div>');
                        $('div.data').load('k_t_extend.php?lang=<?=$lang?>&r=<?=$r?>&b=<?=$b?>&f=<?=$f?>&i=<?=$i?>&x=');
                    } else {
                        $("div.resp").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;<?php echo get_lang($lang,'1000'); ?></div>');
                    }
                },
                error: function(jqXhr,textStatus,errorThrown){
                    console.log(errorThrown);
                    $("div.resp").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;<?php echo get_lang($lang,'1000'); ?></div>');
                },
                timeout: 3000
            });
            setTimeout(function(){ $("div.resp").html(""); }, 3000);
        }
    });
</script>