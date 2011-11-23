<?php

if (!defined('e107_INIT')) { exit; }


include_lan(e_PLUGIN."riftprogress/languages/".e_LANGUAGE.".php");
define("RIFTPROG", e_PLUGIN."riftprogress/");

$text = RPMENU_LAN001."<br /><br />";

$sql->db_Select("riftprogress_instances", "*") or die(mysql_error());

$notkilled_image = (file_exists(THEME."images/notkilled.png") ? THEME."images/notkilled.png" : RIFTPROG."images/notkilled.png");
$killed_image = (file_exists(THEME."images/killed.png") ? THEME."images/killed.png" : RIFTPROG."images/killed.png");
$attempting_image = (file_exists(THEME."images/attempting.png") ? THEME."images/attempting.png" : RIFTPROG."images/attempting.png");

$sql3 = new db();
$sql4 = new db();

while($row = $sql->db_Fetch()){
	$showinstances = explode(" ", $pref['riftprogress_showinstances']);
	if(in_array($row['id'], $showinstances)){
		$bosses = $sql3->db_Count("riftprogress_bosses", "(*)", "WHERE instance='".$row['zonename']."'");
		$killed = $sql3->db_Count("riftprogress_bosses", "(*)", "WHERE instance='".$row['zonename']."' AND status='2'");
		$killstyle = "(".$killed."/".$bosses.") ";

		$text .= "<div onclick='expandit(\"".$row['zoneid']."\");' class='".$pref['riftprogress_headerstyle']."' style='cursor: pointer;'>
		".$killstyle.$row['zonename']."
		</div>
		
		<table style='width:90%; display:none;' id='".$row['zoneid']."'>";

		$sql4->db_Select("riftprogress_bosses", "*", "instance='".$row['zonename']."'") or die(mysql_error());
		
		while($row2 = $sql4->db_Fetch()){
			if($row2['status'] == "0"){
				$status = "<img src='".$notkilled_image."' title='".RPMENU_LAN004."' />";
			}else if($row2['status'] == "1"){
				$status = "<img src='".$attempting_image."' title='".RPMENU_LAN005."' />";
			}else if($row2['status'] == "2"){
				$status = "<img src='".$killed_image."' title='".RPMENU_LAN006."' />";
			}

			if($row2['heroic'] == "0"){
				$heroic = "<img src='".$notkilled_image."' title='".RPMENU_LAN004."' />";
			}else if($row2['heroic'] == "1"){
				$heroic = "<img src='".$attempting_image."' title='".RPMENU_LAN005."' />";
			}else if($row2['heroic'] == "2"){
				$heroic = "<img src='".$killed_image."' title='".RPMENU_LAN006."' />";
			}

			$text .= "<tr>
			<td style='width: 70%;'><a href='http://rift.zam.com/en/".$row2['npctype'].".html?riftnpc=".$row2['npcid']."'>".$row2['bossname']."</a></td>
			<td style='text-align:center;'>".$status."</td>
			</tr>";
		}

		$text .= "<tr>
		<td style='width: 70%;'>&nbsp;</td>
		<td style='text-align:center;'>".$killstyle."</td>
		</tr>
		</table>";
	}
}

$ns->tablerender(RPMENU_LAN007, $text);

?>