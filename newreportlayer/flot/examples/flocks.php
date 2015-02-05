<?php 
$flock = $_GET['flock'];
function daysDifference($endDate, $beginDate)
{

//explode the date by "-" and storing to array
$date_parts1=explode("-", $beginDate);
$date_parts2=explode("-", $endDate);
//gregoriantojd() Converts a Gregorian date to Julian Day Count
$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
return $end_date - $start_date;
}

?>




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
    <center>
    <table border="0">
     <tr>
      <td colspan="3">Performance Report For Flock <?php echo $flock; ?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Hatchability &amp; Saleable Chicks %</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:500px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {


var currentweight = [
<?php
include "config.php"; 
$query = "SELECT age,date FROM mastersheet where flock = '$flock' ORDER BY date DESC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
   $age = $row1['age']; 
   $date = $row1['date'];
}
//echo $age;
//echo $date;

include "config.php"; 
$query = "SELECT * FROM hatchrecord where flock = '$flock' ORDER BY hatchdate DESC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
   $hatchdate = $row1['hatchdate'];
}
//echo $hatchdate;
//echo "<br />";
//echo $date = date("Y-m-j", strtotime($date));
//echo $date;
//echo "<br />";
//echo $hatchdate;
$days = daysDifference($date,$hatchdate);
if ($date < $hatchdate)
{
  $days;
}
else
{
  $days = 0 - $days;
}
//echo $days;
$firstdate = $age + $days;

$olddate1 = "0";
$olddate = $hatchdate;
$query = "SELECT * FROM hatchrecord where flock = '$flock' ORDER BY hatchdate ASC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
  $plus = daysDifference($olddate,$row1['hatchdate']);
  $olddate = $row1['hatchdate'];
  $firstdate = $firstdate - $plus;
  //echo $row1['hatchdate']; echo ","; echo $firstdate;
  //echo "<br />";
  $nrSeconds = $firstdate * 24 * 60 * 60;
  //echo $row1['hatchdate']; echo ","; echo 
  $nrWeeksPassed = floor($nrSeconds / 604800); 
  $nrDaysPassed = floor($nrSeconds / 86400) % 7; 

    $query3 = "SELECT * FROM hatchrecord where flock = '$flock' and hatchdate = '$row1[hatchdate]' ORDER BY hatchdate ASC ";
    $result3 = mysql_query($query3,$conn1); 
    while($row3 = mysql_fetch_assoc($result3))
    {
        //echo ",";
         $per = $row3['saleableper'];
    }
    //echo $per.",".$nrWeeksPassed;
    //if($olddate1 <> $nrWeeksPassed) {
   ?>    [<?php echo $nrWeeksPassed.".".$nrDaysPassed; ?>,<?php echo $per; ?>],
     <?php // } 
$olddate1 = $nrWeeksPassed;
 } ?>
 [<?php echo $nrWeeksPassed.".".$nrDaysPassed; ?>,<?php echo $per; ?>]];




var standardweight = [
<?php
include "config.php"; 
$query = "SELECT age,date FROM mastersheet where flock = '$flock' ORDER BY date DESC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
   $age = $row1['age']; 
   $date = $row1['date'];
}
//echo $age;
//echo $date;

include "config.php"; 
$query = "SELECT * FROM hatchrecord where flock = '$flock' ORDER BY hatchdate DESC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
   $hatchdate = $row1['hatchdate'];
}
//echo $hatchdate;
//echo "<br />";
//echo $date = date("Y-m-j", strtotime($date));
//echo $date;
//echo "<br />";
//echo $hatchdate;
$days = daysDifference($date,$hatchdate);
if ($date < $hatchdate)
{
  $days;
}
else
{
  $days = 0 - $days;
}
//echo $days;
$firstdate = $age + $days;

$olddate1 = "0";
$olddate = $hatchdate;
$query = "SELECT * FROM hatchrecord where flock = '$flock' ORDER BY hatchdate ASC ";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{
  $plus = daysDifference($olddate,$row1['hatchdate']);
  $olddate = $row1['hatchdate'];
  $firstdate = $firstdate - $plus;
  //echo $row1['hatchdate']; echo ","; echo $firstdate;
  //echo "<br />";
  $nrSeconds = $firstdate * 24 * 60 * 60;
  //echo $row1['hatchdate']; echo ","; echo 
  $nrWeeksPassed = floor($nrSeconds / 604800); 
  $nrDaysPassed = floor($nrSeconds / 86400) % 7; 

    $query3 = "SELECT * FROM hatchrecord where flock = '$flock' and hatchdate = '$row1[hatchdate]' ORDER BY hatchdate ASC ";
    $result3 = mysql_query($query3,$conn1); 
    while($row3 = mysql_fetch_assoc($result3))
    {
        //echo ",";
         $per = $row3['hatchper'];
    }
    //echo $per.",".$nrWeeksPassed;
    //if($olddate1 <> $nrWeeksPassed) {
   ?>    [<?php echo $nrWeeksPassed.".".$nrDaysPassed; ?>,<?php echo $per; ?>],
     <?php // } 
$olddate1 = $nrWeeksPassed;
 } ?>
 [<?php echo $nrWeeksPassed.".".$nrDaysPassed; ?>,<?php echo $per; ?>]];




  var plot =   $.plot($("#placeholder"),
           [ { data: currentweight, label: "Saleable Chicks % " },
             { data: standardweight, label: "Hatchability % ", yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 1,
                      tickSize: 1,
					  label: "test"
                    },
             yaxis: { min: 0, max: 100, tickSize: 10 },
             y2axis: { min : 0, max: 100, tickSize: 10 },
             legend: { margin: [690,425] } 
    });

    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (1) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label +" for " + x + " Week " + " is " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        }
    });

    $("#placeholder").bind("plotclick", function (event, pos, item) {
        if (item) {
            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
            plot.highlight(item.series, item.datapoint);
        }
    });
});
</script>
 </body>
</html>

