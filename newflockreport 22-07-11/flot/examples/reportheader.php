<style type="text/css">
p { margin:0 0 0 0; }
</style>

<?php include "../../config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}?>
<table align="center" border="0">
<tr>
<td style="vertical-align:middle"><img src="../../../logo/thumbnails/<?php echo $image; ?>" border="0px" /></td>
<td style="vertical-align:middle"><?php echo html_entity_decode($address); ?></td>
</tr>
</table>