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


var hatchper = [
     <?php include "config.php";
       $query1 = "SELECT * FROM hatchrecord WHERE flock = 'S51' ORDER BY flock ASC ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $hatchdate = $row1['hatchdate'];
         $hatchper = $row1['hatchper'];
     ?>
       [<?php echo $hatchdate; ?>,<?php echo $hatchper; ?>],
     <?php  } ?>
 [<?php echo $hatchdate; ?>,<?php echo $hatchper; ?>]];



//var sc = [
    // <?php include "config.php";
      // $query1 = "SELECT * FROM hatchrecord WHERE flock = 'S51' ORDER BY flock ASC ";
      // $result1 = mysql_query($query1,$conn);
      // while($row1 = mysql_fetch_assoc($result1))
      // {
      //   $hatchdate = $row1['hatchdate'];
       //  $sc = $row1['saleablechicks'];
    // ?>
      // [<?php echo $hatchdate; ?>,<?php echo $sc; ?>],
     //<?php  } ?>
 //[<?php echo $hatchdate; ?>,<?php echo $sc; ?>]];


  var plot =   $.plot($("#placeholder"),
           [ { data: hatchper, label: "Current Value " }],
             //{ data: sc, label: "Standard Value ", yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
			 xaxis: { mode: "date" },
             yaxis: { min: 0, max:100, tickSize: 10 },
             //y2axis: { min : 0, tickSize: 5000 },
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
                                item.series.label +" for " + x + " Days " + " is " + y);
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
