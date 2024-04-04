<?php
$cur_dir = getcwd()."/domains/mrgrouptins.com/public_html/admin";
require $cur_dir.'/functions.php'; 

include_once($cur_dir.'/db_dump/Mysqldump/Mysqldump.php');

$dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname=u183509287_dbmrprashindu', 'u183509287_prashantmrindu', 'S*L7t[/8puiW56');
$f="MR - ".date('d-m-Y');
$dump->start("$cur_dir/db_dump/backups/$f.sql");
$a = $cur_dir.'/db_dump/backups/'.$f.'.sql';

if(smtp_mailer(GMAIL, "BACKUP", "Backup - $f",$a, 2)){
    
    echo $f."sent";
}
else{
    echo $f."no";
}


?>