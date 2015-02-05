<?php include "config.php";
/*$c = $flockget = $_GET['flock']; */
$c = $flockget = "3-GG-16-3";
$unit = $_GET['unit']; 
session_start();
$db = $_SESSION['db'];
$clorarr = array("#9933FF","#999900","#33CC33","#663333","#FF9933","#669933","#CC6699","#FFFF00","#993333","#CC66FF","#333399","#FF9999","#0000FF","#33CCCC","#993399");
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
	 
    <table id="tab"  align="left" style="margin-top:-5px; margin-left:-50px;">
     <tr>
       <td colspan="3">
        <strong><font color="#3e3276">  Feed Per Egg</font></strong>
       </td>
     </tr>
 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Feed / Egg</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:270px;height:270px;text-align:left;" ></div>
      </td>
      <td width="5px"></td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">

$(function () {
<?php
$i=0;$k=0;
$q1 = "select flockcode  from breeder_flock  ";
$r1 = mysql_query($q1);
while($row = mysql_fetch_array($r1))
{
 $c = $row['flockcode'];
		   $flkarrn[$k] =  $row['flockcode'];
?>
var feed<?php echo $k;?> = [
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
					 $w = (($row12a['fm']) / $toteggs) * 1000;
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
			  if($tempage < $age)
			  $tempage = $age;
           } 
     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];
// alert("<?php echo $nrWeeksPassed.','.$w.'---'.$c ?>");
 //alert("<?php echo $query12a ?>");
  <?php  $k = $k +1;
} ?>
//alert("<?php echo $tempage ?>");
//alert("<?php echo $age ?>");
            var plot =   $.plot($("#placeholder"),
           [ 
		   <?php  for ($z=0;$z<$k;$z++)
		   {
		     if($z == $k-1){
		    ?>
             { data: feed<?php echo $z;?>, label: "<?php echo "Flock ".$flkarrn[$z];?>", color:'<?php echo $clorarr[$z];?>'  }
			 <?php } else { ?>
			 { data: feed<?php echo $z;?>, label: "<?php echo "Flock ".$flkarrn[$z];?>", color:'<?php echo $clorarr[$z];?>'  },
			 <?php } }?>
			 
			 ],
           { 
             grid: { hoverable: true, clickable: true  },
             xaxis: { min: 20,
                      tickSize: 5,max: <?php echo floor($tempage/7) ?>,
					  label: "test" 	
                    },
             yaxis: { min: 0, tickSize: 50, max:600 },
             y2axis: { min : 40, tickSize: 10, max:210 },
             legend: { margin: [-120,40] } 
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
        }).appendTo("tab").fadeIn(200);
    }

    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y2").text(pos.y.toFixed(2));

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

