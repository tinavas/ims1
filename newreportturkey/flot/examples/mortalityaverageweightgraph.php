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
$(function () {


var currentweight = [
     <?php include "config.php";
	   $query2 = "SELECT SUM(mortality) as mort, SUM(feedconsumed) as feed FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	   $result2 = mysql_query($query2,$conn1);
	   while($row2 = mysql_fetch_assoc($result2))
	   {
	     $mort = $row2['mort'];
		 $feed = $row2['feed'];
	   }
	   
	   $query3 = "SELECT COUNT(*) as c FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' AND average_weight != '' ORDER BY entrydate ASC ";
	   $result3 = mysql_query($query3,$conn1);
	   while($row3 = mysql_fetch_assoc($result3))
	   {
	     $c = $row3['c'];
	   }
	   
	   $query4 = "SELECT SUM(average_weight) as avgweight FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	   $result4 = mysql_query($query4,$conn1);
	   while($row4 = mysql_fetch_assoc($result4))
	   {
	     $avgweight = $row4['avgweight'];
	   }
	   
	   $query5 = "SELECT * FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate DESC ";
	   $result5 = mysql_query($query5,$conn1);
	   while($row5 = mysql_fetch_assoc($result5))
	   {
	     $b = $row5['birds'];
	   }
	   
	   $remainingbirds = $b - $mort;
	   $avgw = $avgweight/$c;
	   
	   $fcr = ($feed/($remainingbirds * $avgw)) * 1000;
	   
       $query1 = "SELECT * FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $mortality = $row1['mortality'];
     ?>
       [<?php echo $age; ?>,<?php echo $mortality; ?>],
     <?php  } ?>
 [<?php echo $age; ?>,<?php echo $mortality; ?>]];



var standardweight = [
     <?php include "config.php";
       $query1 = "SELECT * FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' AND average_weight != '' ORDER BY entrydate ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         //$flock = $row1['flock'];
		 $age = $row1['age'];
         $average_weight = $row1['average_weight'];
		 //$average_weight = $row1['average_weight'];
		 
		 
     ?>
       [<?php echo $age; ?>,<?php echo $average_weight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $average_weight; ?>]];


  var plot =   $.plot($("#placeholder"),
           [ { data: currentweight, label: "Mortality " },
             { data: standardweight, label: "Average Weight ", yaxis: 2 }],
           { 
		     series: {
                       lines: { show: true },
					   bars: { show: false, barWidth: 0.25, align: "center" } },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0, max:25,
                      tickSize: 1
                    },
			 x2axis: { autoscaleMargin: 0.2 },
             yaxis: { min: 0, max: 40, tickSize: 5 },
             y2axis: { min : 0, max: 1000, tickSize: 100 },
             legend: { margin: [710,425] } 
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
                                item.series.label +" for  flock on " + x + "th day  is " + y);
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

<?php
# echo $remainingbirds;
?>
 </body>
</html>
