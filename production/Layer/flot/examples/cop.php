
<?php 
$supervisor =  $_GET['supervisor'];
$cullflag = $_GET['cull'];
$culltype =  "";
if($cullflag == 0)
{
 $culltype = "Live";
}
else
{
$culltype = "Culled";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Production Costs Graph</title>
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
      <td colspan="3">Production Costs of <?php echo $culltype; ?> flocks under Supervisor:<?php echo $supervisor; ?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Production Cost/Kg</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:110px"><font color="red" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Place</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Farmer</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Flock</u></font>
        <?php
		$i = 0;
           include "config.php";
           $query3 = "SELECT distinct(place) FROM broiler_daily_entry where supervisior = '$supervisor' order by place ASC ";
           $result3 = mysql_query($query3,$conn1); 

		  
           while($row3 = mysql_fetch_assoc($result3))
           {  
		   $queryplhead = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' order by farm ASC ";
		   $resultplhead = mysql_query($queryplhead,$conn1);
		   
		   while ( $rowplhead = mysql_fetch_assoc($resultplhead) )
		   { 
		    if ( $cullflag == 0)
			{ 
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and flock not in (select distinct(flock) from broiler_transferrate)  order by flock ASC ";
			}
			else
			{
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and flock in (select distinct(flock) from broiler_transferrate )  order by flock ASC ";
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
		 <td colspan="3" style="text-align:left;"  width="50"><?php echo $i + 1; ?></td>
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
        <?php        $i = 1;
		             $queryplc = "select distinct place from broiler_daily_entry where supervisior = '$supervisor' order by place";
                     $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     { 
                  $queryfrm = "select distinct farm from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]' order by farm ";
	                 $resultfrm = mysql_query($queryfrm,$conn1);
	                 while ( $rowfrm = mysql_fetch_assoc($resultfrm))
	                { 
					$trratein = 0;
					$trrateout = 0;
					$transcost = 0;
					$birds = 0;
					$transrate = 0;
	                  if ( $cullflag == 0)
					  {
				$queryflk =	"select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' AND farm = '$rowfrm[farm]' and flock not in (select distinct(flock) from broiler_transferrate )  order by flock ASC ";
					  }
					  else
					  {
				$queryflk =	 "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' AND farm = '$rowfrm[farm]' and flock in (select distinct(flock) from broiler_transferrate )  order by flock ASC ";
					  }
					  //$queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' order by flock ";
		              $resultflk = mysql_query($queryflk,$conn1);
		            while ( $rowflk = mysql_fetch_assoc($resultflk))
		             { 
					   //Transfer in
					  $query2 = "SELECT sum(quantity * price) as costin FROM ims_stocktransfer WHERE  towarehouse = '$rowfrm[farm]' and aflock = '$rowflk[flock]'  ";
                        $result2 = mysql_query($query2,$conn1);
                        while($row4 = mysql_fetch_assoc($result2))
                        {
                             $trratein = $row4['costin'];
                        }
						//Transfer Out
						//Transfer in
					   $query2 = "SELECT sum(quantity * price) as costout FROM ims_stocktransfer WHERE  fromwarehouse = '$rowfrm[farm]' and tflock = '$rowflk[flock]'  ";
                        $result2 = mysql_query($query2,$conn1);
                        while($row4 = mysql_fetch_assoc($result2))
                        {
                             $trrateout = $row4['costin'];
                        }
						
					
						$query2 = "SELECT sum(rate) FROM broiler_transferrate WHERE  farmer = '$rowfrm[farm]' and flock = '$rowflk[flock]'  ";
                        $result2 = mysql_query($query2,$conn1);
                        while($row4 = mysql_fetch_assoc($result2))
                        {
                             $transrate = $row4['sum(rate)'];
                        }
						
						 $prodcost = round(($trratein + $transrate - $trrateout),"0.00");
				       if ( $cullflag == 0)
					   { 
						 $query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$rowflk[flock]' and towarehouse = '$rowfrm[farm]' and cat = 'Broiler Chicks'  "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $birds = $birds + $row111['chicks']; } }
 
 $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$rowflk[flock]' and warehouse = '$rowfrm[farm]'  and category = 'Broiler Chicks'  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $birds = $birds + $row111['chicks'];  } }
                       
					    $query111 = "SELECT max(average_weight) as avw FROM broiler_daily_entry where flock = '$rowflk[flock]' and farm = '$rowfrm[farm]' and place = '$rowplc[place]' and supervisior = '$supervisor' "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $avw = $row111['avw']; } }
                 
				//echo $birds;
				//echo $avw;
				  $wt = round((($avw/1000) * $birds),2);
  
					   }
					   else
					   {
					     $query7 = "select SUM(weight) as sumwt from oc_cobi where  flock = '$rowflk[flock]' and warehouse = '$rowfrm[farm]'";
						 $result7 = mysql_query($query7,$conn1);
						 while($row7 = mysql_fetch_assoc($result7))
						 {
						  $wt = $row7['sumwt'];
						 }					   
					   }
		        //$prodcost = round(($prodcost / $wt),2);
				
				
		        if ( $wt == 0)
				{
				  $prodcost = 0;
				}
				else
				{
				$prodcost = round(($prodcost/$wt),2);
				}
                 
      
             
			  
       ?>
             [<?php echo $i; ?>,<?php echo $prodcost; ?>],
         <?php $i = $i + 1;  
		 }
		 }
		 } ?>
          //[<?php echo $i; ?>, <?php echo $prodcost; ?>] 
		    ];
			 

   


  
    

   



  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Production Cost/Kg"}
             ],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: 30,
                      tickSize: 1,
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

