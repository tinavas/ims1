
<?php  echo "<script> var sec=0;var msec=".'0; </script>' ;
 list($time_start_msec, $time_start_sec) = explode(" ", microtime());?>
<div id="time" align="center">
<!--<img src="../images/mask-loader.gif" align="bottom"/>&nbsp;Please wait,while page is loading . . . . -->
</div>
<?php include "config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}?>
<?php 
if($_SESSION['db'] == "feedatives")
{ ?>
<table align="center" border="0" width="80%">
<tr>
<td width="60%" style="vertical-align:middle" align="left"  ><img src="../../logo/thumbnails/<?php echo $image; ?>" border="0px" /></td>
<td width="40%" style="vertical-align:middle; font-family:Georgia, 'Times New Roman', Times, serif; font-size:16px; text-align:left"  align="right" ><?php echo html_entity_decode($address); ?></td>
</tr>
</table>
<?php } else {?>
<table align="center" border="0">
<tr>
<td style="vertical-align:middle"><img src="../../logo/thumbnails/<?php echo $image; ?>" border="0px" /></td>
<td style="vertical-align:middle; font-family:Verdana;"><?php echo html_entity_decode($address); ?></td>
</tr>
</table>
<?php }?>