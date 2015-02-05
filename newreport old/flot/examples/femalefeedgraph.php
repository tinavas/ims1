<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>B.I.M.S Graphs</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
	

 </head>
    <body>
    <div id="placeholder" style="width:900px;height:500px;"></div>
<script id="source" language="javascript" type="text/javascript">
$(function () 
{
  var fm = [
     <?php include "config.php";
       $query1 = "SELECT * FROM mastersheet WHERE shed = 'L1' AND flock = 'S51'  AND penno = '1' ORDER BY date ASC ";
       $result1 = mysql_query($query1,$conn);
	   $num1 = mysql_num_rows($result1);
	   for($i=0;$i<$num1;$i++)
	   {
	   while($row1 = mysql_fetch_assoc($result1))
       {
         echo $date1 = $row1['date'];
         $fm = $row1['fm'];
	 ?>
	 [<?php echo $date1; ?>,<?php echo $fm; ?>],
       <?php } ?>  <?php } ?>
     [<?php echo $date1; ?>,<?php echo $fm; ?>]];

  var plot =   $.plot($("#placeholder"),
           [ { data: fm, label: "Current Value " }],
             //{ data: sc, label: "Standard Value ", yaxis: 2 }],
           { 
			 xaxis: { mode: "date", tickSize: 200, },
             yaxis: { min: 0, max:200, tickSize: 20 },
             legend: { margin: [710,425] } 
     });
});
 
</script>
 </body>
</html>
