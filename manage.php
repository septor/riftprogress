<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."riftprogress/languages/".e_LANGUAGE.".php");

if(check_class($pref['riftprogress_manageclass'])){
	if(isset($_POST['update'])){
		extract($_POST);
		while (list($key, $id) = each($_POST['status']))
		{
			$tmp = explode(".", $id);
			$sql->db_Update("riftprogress_bosses", "status=".intval($tmp[0])." WHERE id=".intval($tmp[1]));
		}
		$message = RPMANAGE_LAN001;
	}
	if (isset($message)) {
		$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
	}

	$text = "<div style='text-align:center'>";

	$sql->db_Select("riftprogress_instances", "*") or die(mysql_error());

	while($row = $sql->db_Fetch()){

		$text .= "<form method='post' name='instance' action='".e_SELF."'>
		<table style='width:75%' class='fborder'>
		<tr>
		<td colspan='2' class='fcaption' style='text-align:center;'><b><u>".$row['zonename']."</u></b></td>
		</tr>
		<tr>
		<td class='forumheader3' style='width:70%'><b>".RPMANAGE_LAN002."</b></td>
		<td class='forumheader3' style='text-align:center;'><b>".RPMANAGE_LAN003."</b></td>
		</tr>";

		$sql2->db_Select("riftprogress_bosses", "*", "instance='".$tp->toDB($row['zonename'])."'") or die(mysql_error());

		while($row2 = $sql2->db_Fetch()){
			$text .= "<tr>
			<td class='forumheader3'><a href='http://rift.zam.com/en/".$row2['npctype']."/".$row2['npcid']."/'>".$row2['bossname']."</a></td>
			<td class='forumheader3' style='text-align:center;'>
			<select name='status[]' class='tbox'>
			<option value='0.".$row2['id']."'".($row2['status'] == "0" ? " selected" : "").">".RPMANAGE_LAN005."</option>
			<option value='1.".$row2['id']."'".($row2['status'] == "1" ? " selected" : "").">".RPMANAGE_LAN006."</option>
			<option value='2.".$row2['id']."'".($row2['status'] == "2" ? " selected" : "").">".RPMANAGE_LAN007."</option>
			</select>
			</td>
			</tr>";
		}

		$text .= "
		<tr>
		<td colspan=2' class='fcaption' style='text-align:center;'>
		<input type='submit' class='button' name='update[]' value=\"".RPMANAGE_LAN008.$row['zonename']."\">
		<input type='reset' class='button' value='".RPMANAGE_LAN009."'>
		</td>
		</tr></table>
		</form>
		<br /><br />";

	}

	$text .= "</div>";

	$ns->tablerender(RPMANAGE_LAN010, $text);
}else{
	$ns->tablerender(RPMANAGE_LAN011, RPMANAGE_LAN012);
}
require_once(e_ADMIN."footer.php");
?>