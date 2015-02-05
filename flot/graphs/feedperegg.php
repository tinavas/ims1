<?php include "config.php";
/*$c = $flockget = $_GET['flock']; */
$c = $flockget = "3-GG-16-3";
$unit = $_GET['unit']; 
session_start();
$db = $_SESSION['db'];
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
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	 <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">

 </head>
    <body>
      
      <center>
	 
    <table border="0">
     <tr>
       <td colspan="3">
         Feed Per Egg<?php echo $c; ?>
       </td>
     </tr>
 
     <tr>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:400px;height:270px;"></div>
      </td>
      <td width="5px"></td>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Feed in Grams (grm)</span></span>
      </td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">

$(function () {
var feed = [
        <?php 
           
		   $query = "select age,ffeedqty,eggs from breeder_initial where flock = '$c' order by age";
		  
		   $result = mysql_query($query,$conn1);
		   $num=mysql_num_rows($result);
			
		   while($res = mysql_fetch_assoc($result))
		   { 
		   
		   $teggs=0;
		  $eggs=explode(",",$res["eggs"]);
		  foreach($eggs as $val)
			{$egg=explode(":",$val);
			$teggs=$teggs+$egg[1];
			}
		  
			if($teggs>0)
			{
		   ?> 
                     [<?php echo $res['age']; ?>,<?php echo (($res['ffeedqty']/7)/($teggs))*1000; ?>],                             
      <?php }}
			
		    $w = 0;$wi = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
			   {
				 $age = $row1a['age']; 
				 $date = date('Y-m-d',strtotime($row1a['startdate']));
			   }
           $odate = $date;
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 1)
              {
                 $odate =date('Y-m-d',strtotime($row12['date2']));   
              } 
              if ($nrDaysPassed == 0)
              {
                 include "config.php"; 
 				  $date1=date('Y-m-d',strtotime($row12['date2']));
                  $query12a = "SELECT sum(ffeed+cfeed+mfeed) as `fm` FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$date1' ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
				 $query2 = "select sum(quantity) as 'quantity' from breeder_production where flock = '$c' and date1 >= '$odate' and date1 <= '$date1' "; 
  		$result2 = mysql_query($query2,$conn1) or die(mysql_error());
		 $rows=mysql_fetch_assoc($result2);
		  $toteggs = $rows['quantity'];
		  		if($toteggs=="")
				$toteggs=0;
				  $inc = 0;
				  $queryi = "SELECT distinct(date2) FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$date1'";
                  $resulti = mysql_query($queryi,$conn1);  
				  $inc = mysql_num_rows($resulti);
                  				  
				     $oldw = $w; 
					 if($toteggs>0)
					 $w = (($row12a['fm']/$inc) / $toteggs) * 1000;
					 else
					 $w=0;
					 $feedar[$wi] = $w;$wi++;

                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              } 
			  $age = $age +1; 
           } 
     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];
 
            var plot =   $.plot($("#placeholder"),
           [ 
		   
			
             { data: feed, label: "F15 Feed Consumed Actual", color:'#9999FF', yaxis: 2 }
			 ],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 20,
                      tickSize: 2, max: 50, 
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 10, tickSize: 20, max:300 },
             legend: { margin: [660,280] } 
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
        $("#y2").text(pos.y2.toFixed(2));

        if (1) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label +" for " + x + " Weeks " + " is " + y);
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

