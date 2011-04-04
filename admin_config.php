<?php

if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
require_once(e_HANDLER."userclass_class.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."riftprogress/languages/".e_LANGUAGE.".php");

	
if (isset($_POST['updatesettings'])) {
	$si = $_POST['showinstances'];
	$instances = "";
	if(!empty($si)){
		$n = count($si);
		for($i=0; $i < $n; $i++){
			$instances .= $si[$i]." ";
		}
	}
	$pref['riftprogress_showinstances'] = $instances;
	$pref['riftprogress_manageclass'] = $_POST['riftprogress_manageclass'];
	$pref['riftprogress_headerstyle'] = $_POST['headerstyle'];
	save_prefs();
	$message = RPCONFIG_LAN001;
}

if (isset($message)) {
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$text = "
<div style='text-align:center'>
<form method='post' action='".e_SELF."'>
<table style='width:75%' class='fborder'>
<tr>
<td style='width:50%' class='forumheader3'>".RPCONFIG_LAN002."</td>
<td style='width:50%; text-align:right' class='forumheader3'>
".r_userclass('riftprogress_manageclass', $pref['riftprogress_manageclass'], 'off', 'nobody,member,admin,classes')."
</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>".RPCONFIG_LAN003."</td>
<td style='width:50%; text-align:right' class='forumheader3'>";

$sql->db_Select("riftprogress_instances", "*");
$sitext = "";
while($row = $sql->db_Fetch()){
	$showinstances = explode(" ", $pref['riftprogress_showinstances']);
	if(in_array($row['id'], $showinstances)){
		$sitext .= $row['zonename']." <input type='checkbox' name='showinstances[]' value='".$row['id']."' checked /><br />";
	}else{
		$sitext .= $row['zonename']." <input type='checkbox' name='showinstances[]' value='".$row['id']."' /><br />";
	}
}

$text .= ($sitext != "" ? $sitext : "".RPCONFIG_LAN004." <a href='".e_PLUGIN."riftprogress/datapack.php'>".RPCONFIG_LAN005."</a>!");

$text .= "</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>".RPCONFIG_LAN011."</td>
<td style='width:50%; text-align:right' class='forumheader3'>
<select name='headerstyle' class='tbox'>
<option value='fcaption'".($pref['riftprogress_headerstyle'] == "fcaption" ? " selected" : "").">fcaption</option>
<option value='forumheader'".($pref['riftprogress_headerstyle'] == "forumheader" ? " selected" : "").">forumheader</option>
<option value='forumheader2'".($pref['riftprogress_headerstyle'] == "forumheader2" ? " selected" : "").">forumheader2</option>
<option value='forumheader3'".($pref['riftprogress_headerstyle'] == "forumheader3" ? " selected" : "").">forumheader3</option>
</select>
</td>
</tr>
<tr>
<td colspan='2' style='text-align:center' class='forumheader'>
<input class='button' type='submit' name='updatesettings' value='".RPCONFIG_LAN012."' />
</td>
</tr>
</table>
</form>
</div>
";

$ns->tablerender(RPCONFIG_LAN013, $text);
require_once(e_ADMIN."footer.php");
?>
