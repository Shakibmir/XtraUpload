<?
if($_SESSION['loggedin'])
{
$ds = "SELECT * FROM users WHERE uid='".$myuid."' ";
$re = $db->query($ds);
$s = $db->fetch($re);

$hs = "SELECT * FROM groups WHERE id = '".$s->group."' ";
$g = $db->fetch($db->query($hs));

//$mes = time();
if($_GET['extend'])
{
	if($can_extend)
	{
		if($s->expire != '0')
		{
			if($s->points > $g->points)
			{
				$sec = $g->days*24*60*60;
				$db->query("UPDATE users SET time = time+".$sec.", points = points-".$g->points." WHERE uid = '".$s->uid."'");
				
				$s = NULL;
				$ds = "SELECT * FROM users WHERE uid='$myuid' ";
				$re = $db->query($ds);
				$s = $db->fetch($re,"obj");
				$mes = $lang['points']['1'].''.$g->expire.''.$lang['points']['2'];
			}
			else
			{
				$mes = $lang['points']['3'];
			}
		}
		else
		{
			$mes = $lang['points']['16'];
		}
	}
	else
	{
		$mes = $lang['points']['4'];
	}
}
?>
<style type="text/css">
<!--
.style1
{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="130" class="style1"><center><font size="4" color="#FF0000"><b><?=$mes;?></b></font></center><p align="center">
	<?=$lang['points']['5']?><?=$s->username?><br>
	<?=$lang['points']['6']?><?=$g->name?><br />
      <br>
      <?=$lang['points']['7']?><? if((int)$s->expire != 0){echo 'Never Expires';}else if((string)$g->extend != '0'){ echo $lang['points']['8']."".date('F j, Y, g:i a', (int)$s->time);}else{echo $lang['points']['9']; }?><br>
      <br>
	  <? if($can_extend)
	  {?>
      <? if((int)$g->expire != 0){echo $lang['points']['10'].$g->expire.$lang['points']['11'].$g->points.$lang['points']['12'];}?><br>
	  <?=$lang['points']['13'].$s->points.$lang['points']['12']?><br>
      <? if((int)$g->expire != 0 && $g->extend_points < $s->points){?><a href="<?=makeXuLink('index.php', array('p' => 'points', 'extend' => '1'))?>"><?=$lang['points']['14']?></a>.<? }else{echo $lang['points']['17'].$g->points.' '.$lang['points']['18'];}?>
      <br>
	  <? }?>
      <br>
    </p>
    </td>
  </tr>
</table>
<?
}
else
{
	redirect_foot('<center><h4>'.$lang['points']['15'].'</h4></center>','login');
}
?>