<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."riftprogress/languages/".e_LANGUAGE.".php");

if(file_exists(e_PLUGIN."riftprogress/dataz.xml")){
	$dp = simplexml_load_file(e_PLUGIN."riftprogress/dataz.xml");

	// add the dataz!
	$iAdded = 0;
	$bAdded = 0;
	foreach($dp->instance as $instance){
		// if the instance isn't already in the database...
		if($sql->db_Count("riftprogress_instances", "(*)", "WHERE zonename='".addslashes($instance['name'])."'") == 0){
			// ... add it
			$sql->db_Insert("riftprogress_instances", "'', '".intval($instance['id'])."', '".$tp->toDB($instance['name'])."'") or die(mysql_error());
			$iAdded++;
		}

		// now the bosses!
		foreach($instance->boss as $boss){
			// if the boss isn't already in the database...
			if($sql->db_Count("riftprogress_bosses", "(*)", "WHERE bossname='".addslashes($boss['name'])."'") == 0){
				$sql->db_Insert("riftprogress_bosses", "'', '".intval($boss['id'])."', '".$tp->toDB($boss['type'])."', '".$tp->toDB($boss['name'])."', '".$tp->toDB($instance['name'])."', '0'") or die(mysql_error());
				$bAdded++;
			}
		}

	}

	$text = "<div style='text-align:center;'>
	".RPDPACK_LAN001.$iAdded.RPDPACK_LAN002.$bAdded.RPDPACK_LAN003."<br /><br />
	<a href='".e_PLUGIN."riftprogress/manage.php'>".RPDPACK_LAN004."</a>
	</div>";

	$ns->tablerender(RPDPACK_LAN005." v".$dp->version, $text);

	unset($iAdded, $bAdded);

}else{

	$ns->tablerender(RPDPACK_LAN006, RPDPACK_LAN007." <a href='https://github.com/septor/riftprogress/raw/master/dataz.xml'>".RPDPACK_LAN008."</a>");

}
require_once(e_ADMIN."footer.php");

?>