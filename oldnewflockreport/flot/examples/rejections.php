
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
      <td colspan="3">Rejections in different flocks</td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style=""></span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:140px">
        <?php
           include "config.php";
           $query3 = "SELECT flock FROM hatchrecord GROUP BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 3;
           while($row3 = mysql_fetch_assoc($result3))
           {
         ?>  
           <font color="red" style="padding-right:155px">( <?php echo $row3['flock']; ?> )</font>
  
       <?php
          $i = $i + 3;}  
       ?>

     </td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {


    var d2 = [
        <?php
           include "config.php";
           $query3 = "SELECT avg(disper) as `hatchper` FROM hatchrecord GROUP BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 2;
           while($row3 = mysql_fetch_assoc($result3))
           {
              $hatchper = $row3['hatchper'];
       ?>
             [<?php echo $i; ?>, <?php echo $hatchper; ?>], 
         <?php $i = $i + 5; } ?>
             [, ]];
    

    var d1 = [
        <?php
           include "config.php";
           $query3 = "SELECT avg(cullsper) as `saleper` FROM hatchrecord GROUP BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $j = 3;
           while($row3 = mysql_fetch_assoc($result3))
           {
              $saleper = $row3['saleper'];
       ?>
             [<?php echo $j; ?>, <?php echo $saleper; ?>], 
         <?php $j = $j + 5; } ?>
             [, ]];


    var d3 = [
        <?php
           include "config.php";
           $query3 = "SELECT avg(dihper) as `saleper` FROM hatchrecord GROUP BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $k = 4;
           while($row3 = mysql_fetch_assoc($result3))
           {
              $saleper = $row3['saleper'];
       ?>
             [<?php echo $k; ?>, <?php echo $saleper; ?>], 
         <?php $k = $k + 5; } ?>
             [, ]];


    var d4 = [
        <?php
           include "config.php";
           $query3 = "SELECT avg(infper) as `saleper` FROM hatchrecord GROUP BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $l = 5;
           while($row3 = mysql_fetch_assoc($result3))
           {
              $saleper = $row3['saleper'];
       ?>
             [<?php echo $l; ?>, <?php echo $saleper; ?>], 
         <?php $l = $l + 5; } ?>
             [, ]];


  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Dead in shell % " },
             { data: d4, label: "Infertile % "}, 
             { data: d3, label: "Dead in Hatch % "}, 
             { data: d1, label: "Culls % "}],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: 21,
                      tickSize: 4,
					  label: "test"
                    },
             yaxis: { min: 0, max: 50, tickSize: 10 },
             y2axis: { min : 0, max: 100, tickSize: 10 },
             legend: { margin: [710,325] } 
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
                                item.series.label + " is " + y);
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






