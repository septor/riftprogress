<?php

$menutitle  = "Rift Progress Navigation";

$butname[]  = "Configuration";
$butlink[]  = "admin_config.php";
$butid[]    = "config";

$butname[]  = "Manage Progression";
$butlink[]  = "manage.php";
$butid[]    = "manage";

$butname[]  = "Process Datapack";
$butlink[]  = "datapack.php";
$butid[]    = "datapack";

global $pageid;
for ($i=0; $i<count($butname); $i++) {
	$var[$butid[$i]]['text'] = $butname[$i];
	$var[$butid[$i]]['link'] = $butlink[$i];
};

show_admin_menu($menutitle, $pageid, $var);

?>
