<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '11543395';
$dbname = 'db1';

function backup_tables($host,$user,$pass,$name,$tables = '*') {
    $link = mysql_connect($host,$user,$pass);
    mysql_select_db($name,$link);
    mysql_query("SET NAMES 'utf8'");
    //get all of the tables
    if($tables == '*') {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    $return='';
    //cycle through
    foreach($tables as $table) {
        $result = mysql_query('SELECT * FROM '.$table);
        $num_fields = mysql_num_fields($result);

        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while($row = mysql_fetch_row($result)) {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }
    //options
    $date = date("Y-m-d");
    $time = date("H-i-s");
    $folder = "DB_Backups";
    //path check
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
    //generate filename
    $filename = $folder.'/db-backup-'.$date.'_'.$time.'.sql';
    //save file
    $handle = fopen($filename,'w+');
    //write and close
    fwrite($handle,$return);
    fclose($handle);
}

backup_tables($dbhost,$dbuser,$dbpass,$dbname);
?>