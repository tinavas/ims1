
<?php 
$supervisor =  $_GET['supervisor'];
$cullflag = $_GET['cull'];
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
      <td colspan="3">Comparison of different flocks</td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Mortality%</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:110px"><font color="red" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Place</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Farmer</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Flock</u></font>
        <?php
           include "config.php";
           $query3 = "SELECT distinct place FROM broiler_daily_entry where supervisior = '$supervisor' order by place ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 0;
           while($row3 = mysql_fetch_assoc($result3))
           {  
		   $queryplhead = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' order by farm ASC ";
		   $resultplhead = mysql_query($queryplhead,$conn1);
		   
		   while ( $rowplhead = mysql_fetch_assoc($resultplhead) )
		   { 
		    if ( $cullflag == 0)
			{ 
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and cullflag = '0' order by flock ASC ";
			}
			else
			{
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and cullflag = '1' order by flock ASC ";
			}
		   //$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' order by flock ASC ";
		   $resultfrmhead = mysql_query($queryfrmhead,$conn1);
		   ?>
		   <table>
		   <?php
		   while ( $rowfrmhead = mysql_fetch_assoc($resultfrmhead) )
		   { 
         ?> 
		 <tr>
		 <td colspan="3" style="text-align:left;" width="50"><?php echo $i + 1; ?></td>
		<td colspan="3" style="text-align:left;" width="200"> <?php echo $row3['place'];?></td>
		<td colspan="3" style="text-align:left;" width="200"> <?php echo $rowplhead['farm']; ?></td>
		<td colspan="3" style="text-align:left;" > <?php echo $rowfrmhead['flock']; ?></td>
		 </tr> 
           
           
       <?php
          $i = $i + 1; } ?> </table><?php } }
       ?>

     </td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {
 var d2 = [
        <?php        $i = 0;
		             $queryplc = "select distinct place from broiler_daily_entry where supervisior = '$supervisor' order by place";
                     $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
                     $queryfrm = "select distinct farm from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]' order by farm ";
	                 $resultfrm = mysql_query($queryfrm,$conn1);
	                 while ( $rowfrm = mysql_fetch_assoc($resultfrm))
	                {
	                  if ( $cullflag == 0)
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and cullflag = '0' order by flock ";
					  }
					  else
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and cullflag = '1' order by flock ";
					  }
					  //$queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' order by flock ";
		              $resultflk = mysql_query($queryflk,$conn1);
		            while ( $rowflk = mysql_fetch_assoc($resultflk))
		             {  $b = 0;
		             $query5 = "select MAX(birds) as OB from broiler_daily_entry WHERE place = '$rowplc[place]' AND farm = '$rowfrm[farm]' AND supervisior = '$supervisor' AND flock = '$rowflk[flock]'  ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $rowm['OB'];
				   }
				   if ( $b == 0)
				   {
				      $querytrans = "select SUM(chicks) as OB from transferchicks where farmer = '$rowfrm[farm]' AND newflock ='$rowflk[flock]' ";
					  $resulttrans = mysql_query($querytrans,$conn1);
					  while( $rowtrans = mysql_fetch_assoc($resulttrans))
					  {
					     $b = $rowtrans['OB'];
					  }
				   }
		
		
           include "config.php";
           $query3 = "SELECT sum(mortality) as morsum FROM broiler_daily_entry  WHERE place = '$rowplc[place]' AND farm = '$rowfrm[farm]' AND supervisior = '$supervisor' AND flock = '$rowflk[flock]'   ";
           $result3 = mysql_query($query3,$conn1); 
           
           while($row3 = mysql_fetch_assoc($result3))
           { 
		    
              $morper = round((($row3['morsum']/$b)*100),2);
			  
       ?>
             [<?php echo $i; ?>,<?php echo $morper; ?>],
         <?php $i = $i + 1;  }
		 }
		 }
		 } ?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
			 

   


  
    

   



  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Mortality% " }
             ],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: 30,
                      tickSize: 1,
					  label: "test"
                    },
             yaxis: { min: 0, max: 25, tickSize: 1 },
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

