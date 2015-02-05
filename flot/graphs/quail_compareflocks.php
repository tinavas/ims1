
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>B.I.M.S Graphs</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
<?php session_start(); ?>	

 </head>
    <body>
    <center>
    <table border="0">
     <tr>
      <td colspan="3">Comparison of different flocks</td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Hatchability &amp; Saleable Chicks %</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr> <td colspan="3"><?php $i=3; ?>
	 		<table id="tab1" align="center" cellpadding="4">
			<tr>
			 <th><font color="red" > Number </font></th>
			 <th style="width:100px"><font color="red" > Flock Name </font></th>
			</tr>
			 
			  
			  
        <?php
           include "config.php";
           $query3 = "SELECT distinct(flock) FROM quail_hatchery_hatchrecord ORDER BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           while($row3 = mysql_fetch_assoc($result3))
           { ?>
		   <tr>
		    <td align="center"><?php echo $i; $i=$i+3; ?> </td>
		    <td align="center"><?php echo $row3['flock']; ?></td>
			</tr>
			
			<?php } ?>
		   </table>

     <!-- <td colspan="3" style="text-align:left;padding-left:110px">-->
        <?php
           /*include "config.php";
           $query3 = "SELECT distinct(flock) FROM quail_hatchery_hatchrecord ORDER BY flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 3;
           while($row3 = mysql_fetch_assoc($result3))
           {
		    
		   */
         ?>  
           <!--<font color="red" style="padding-right:65px">( <?php// echo $row3['flock']; ?> )</font>-->
  
       <?php
          //$i = $i + 3;}  
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
           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.hatch ) AS hatch FROM `quail_hatchery_traysetting` h1, quail_hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 2;
           while($row3 = mysql_fetch_assoc($result3))
           {
		    $hatchper = ( $row3['hatch'] / $row3['totaleggset'] ) * 100;
              //$hatchper = $row3['hatchper'];
       ?>
             [<?php echo $i; ?>, <?php echo $hatchper; ?>], 
         <?php $i = $i + 3; } ?>
             [, ]];
    

    var d1 = [
        <?php
           include "config.php";
           $query3 = "SELECT h1.flock, sum( h2.noofeggsset ) AS totaleggset, sum( h2.saleablechicks ) AS saleablechicks FROM `quail_hatchery_traysetting` h1, quail_hatchery_hatchrecord h2 WHERE h1.flock = h2.flock AND h1.hatchdate = h2.hatchdate GROUP BY h1.flock ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $j = 3;
           while($row3 = mysql_fetch_assoc($result3))
           {
              $saleper = ( $row3['saleablechicks'] / $row3['totaleggset'] ) * 100;
       ?>
             [<?php echo $j; ?>, <?php echo $saleper; ?>], 
         <?php $j = $j + 3; } ?>
             [, ]];




  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Hatchability % " },
             { data: d1, label: "Saleable Chicks % "}],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: 21,
                      tickSize: 3,
					  label: "test"
                    },
             yaxis: { min: 0, max: 100, tickSize: 10 },
             y2axis: { min : 0, max: 100, tickSize: 10 },
             legend: { margin: [690,375] } 
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






