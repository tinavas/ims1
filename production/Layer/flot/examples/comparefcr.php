
<?php 
$supervisor =  $_GET['supervisor'];
$cullflag = $_GET['cull'];
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
    <title>FCR & B.Weight Comparision Graph</title>
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
    <table >
     <tr>
      <td colspan="3"><b>FCR & B.Weight Comparison of <?php echo $culltype; ?> flocks of Supervisor:<?php echo $supervisor; ?></b></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">FCR/Avg Body Wt(Kgs)</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
	 <?php 
	 
	 $query3 = "SELECT distinct place FROM broiler_daily_entry where supervisior = '$supervisor' order by place ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 0;
		   $placecnt = mysql_num_rows($result3);
	 ?>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:110px"><font color="red" ><?php if($placecnt > 1 ) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Place&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Farmer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flock&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wt(Kgs.)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FCR
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Latest EntyDate</font>
        <?php
           include "config.php";
           $query3 = "SELECT distinct place FROM broiler_daily_entry where supervisior = '$supervisor' order by place ASC ";
           $result3 = mysql_query($query3,$conn1); 
           $i = 0;
		   $placecnt = mysql_num_rows($result3);
           while($row3 = mysql_fetch_assoc($result3))
           {
		   if($cullflag == 0)
		   {  
		   $queryplhead = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' group by flock having max(cullflag) = 0 order by max(age) DESC ";
		   }
		   else
		   {
		     $queryplhead = "select  farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' group by flock having max(cullflag) = 1 order by max(age) DESC ";
		   }
		   $resultplhead = mysql_query($queryplhead,$conn1);
		   
		   
		   while ( $rowplhead = mysql_fetch_assoc($resultplhead) )
		   { 
		    if ( $cullflag == 0)
			{ 
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and flock not in (select distinct(flock) from broiler_transferrate)  group by flock order by max(age) DESC ";
			}
			else
			{
			$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' and flock in (select distinct(flock) from broiler_transferrate) group by flock order by max(age) DESC ";
			}
		   //$queryfrmhead = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' AND place = '$row3[place]' AND farm = '$rowplhead[farm]' order by flock ASC ";
		   $resultfrmhead = mysql_query($queryfrmhead,$conn1);
		   ?>
		   <table>
		   <?php
		   while ( $rowfrmhead = mysql_fetch_assoc($resultfrmhead) )
		   { 
		   $b = 0;
		   $bodywt = 0;
		   $age = 0;
		   $fcons = 0;
		   $salewt = 0;
		      $query5 = "select MAX(birds) as OB,max(average_weight) as avgwt,max(age) as AGE,max(cullflag) as cflag,sum(feedconsumed) as fcons,max(entrydate) as maxdate from broiler_daily_entry WHERE place = '$row3[place]' AND farm = '$rowplhead[farm]' AND supervisior = '$supervisor' AND flock = '$rowfrmhead[flock]'  ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				     // $b = $rowm['OB'];
					  $bodywt = round(($rowm['avgwt']/1000),2);
					  $age = $rowm['AGE'];
					  $cflag = $rowm['cflag'];
					  $fcons = $rowm['fcons'];
					  $maxdate = date("d.m.Y",strtotime($rowm['maxdate']));
				   }
				    
				      $query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$rowfrmhead[flock]' and towarehouse = '$rowplhead[farm]' and cat = 'Broiler Chicks'  "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $b = $b + $row111['chicks']; } }
 
 $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$rowfrmhead[flock]' and warehouse = '$rowplhead[farm]'  and category = 'Broiler Chicks'  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $b = $b + $row111['chicks'];  } }
				   
				   if ( $cflag == "0")
				   {
				      if ( ($b > 0) and ($bodywt > 0)){
					   $fcr = round(($fcons/($b*$bodywt)),2);
					  } else { 
					   $fcr = 0;
					  }
					 
				   } 
				   else
				   {
				      $querytrans = "select SUM(weight) as wt from oc_cobi where flock ='$rowfrmhead[flock]' AND warehouse = '$rowplhead[farm]' ";
					  $resulttrans = mysql_query($querytrans,$conn1);
					  while( $rowtrans = mysql_fetch_assoc($resulttrans))
					  {
					     $salewt = $rowtrans['wt'];
					  }
					  if ( ($b > 0) and ($bodywt > 0)){
					   $fcr = round(($fcons/($salewt)),2);
					  } else { 
					   $fcr = 0;
					  }
				   
				   }
         ?> 
		 <tr>
		 <td colspan="3" style="text-align:left;" width="50"><?php echo $i + 1; ?></td>
		 <?php if($placecnt > 1) { ?>
		<td colspan="3" style="text-align:left;" width="200"> <?php echo $row3['place'];?></td>
		<?php } ?>
		<td colspan="3" style="text-align:left;" width="200"> <?php echo $rowplhead['farm']; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $rowfrmhead['flock']; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $age; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $bodywt; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $fcr; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $maxdate; ?></td>
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
                     if($cullflag == 0)
		   {  
		   $queryfrm = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' group by flock having max(cullflag) = 0 order by max(age) DESC ";
		   }
		   else
		   {
		     $queryfrm = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' group by flock having max(cullflag) = 1 order by max(age) DESC ";
		   }
	                 $resultfrm = mysql_query($queryfrm,$conn1);
	                 while ( $rowfrm = mysql_fetch_assoc($resultfrm))
	                {
	                  if ( $cullflag == 0)
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and flock not in (select distinct(flock) from broiler_transferrate) group by flock order by max(age) DESC ";
					  }
					  else
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and flock in (select distinct(flock) from broiler_transferrate) group by flock order by max(age) DESC ";
					  }
					  //$queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' order by flock ";
		              $resultflk = mysql_query($queryflk,$conn1);
		            while ( $rowflk = mysql_fetch_assoc($resultflk))
		             {  $b = 0;
					  $bodywt = 0;
		   $age = 0;
		   $fcons = 0;
		   $salewt = 0;
		            
		 $query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$rowflk[flock]' and towarehouse = '$rowfrm[farm]' and cat = 'Broiler Chicks'  "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $b = $b + $row111['chicks']; } }
 
 $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$rowflk[flock]' and warehouse = '$rowfrm[farm]'  and category = 'Broiler Chicks'  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $b = $b + $row111['chicks'];  } }
		
		           include "config.php";
           $query3 = "SELECT sum(feedconsumed) as feed,max(average_weight) as avw FROM broiler_daily_entry  WHERE place = '$rowplc[place]' AND farm = '$rowfrm[farm]' AND supervisior = '$supervisor' AND flock = '$rowflk[flock]'   ";
           $result3 = mysql_query($query3,$conn1); 
           
           while($row3 = mysql_fetch_assoc($result3))
           { 
		    if ( $cullflag == 0)
			{
			 if ( $row3['avw'] == "")
			 {
			   $bwt = 0;
			 }
			 else
			 {
			   $bwt = $row3['avw'];
			 }
			 //echo $bwt;
                   //echo $b;
			 if ( ($b == 0) or ($bwt == 0))
			 {
			 $fcr = 0;
			 }
			 else
			 {
			 $feed = $row3['feed'];
			  $fcr = round(($row3['feed']/(($bwt * $b)/1000)),2);
			  
			 }			
			}
			else
			{
			 $query5 = "SELECT sum(weight) as `wt` from oc_cobi where warehouse = '$rowfrm[farm]' AND flock = '$rowflk[flock]' ";
			 $result5 = mysql_query($query5,$conn1);
			 while($row5 = mysql_fetch_assoc($result5))
			 {
			   $wt = $row5['wt'];
			 }
			 $feed = $wt;
			 $fcr = round(($row3['feed']/$wt),2);
			}
            
			  
       ?>
             [<?php echo $i; ?>,<?php echo $fcr; ?>],
         <?php $i = $i + 1;  }
		 }
		 }
		 } ?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
			 
 var d3 = [
        <?php        $i = 1;
		             $queryplc = "select distinct place from broiler_daily_entry where supervisior = '$supervisor' order by place";
                     $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
                     if($cullflag == 0)
		   {  
		   $queryfrm = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' group by flock having max(cullflag) = 0 order by max(age) DESC ";
		   }
		   else
		   {
		     $queryfrm = "select distinct farm From broiler_daily_entry where supervisior = '$supervisor' AND place = '$rowplc[place]' group by flock having max(cullflag) = 1 order by max(age) DESC ";
		   }
	                 $resultfrm = mysql_query($queryfrm,$conn1);
	                 while ( $rowfrm = mysql_fetch_assoc($resultfrm))
	                {
	                  if ( $cullflag == 0)
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and cullflag = '0'  group by flock order by max(age) DESC ";
					  }
					  else
					  {
					  $queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' and cullflag = '1' group by flock  order by max(age) DESC ";
					  }
					  //$queryflk = "select distinct flock from broiler_daily_entry where supervisior = '$supervisor' and place = '$rowplc[place]'  and farm = '$rowfrm[farm]' order by flock ";
		              $resultflk = mysql_query($queryflk,$conn1);
		            while ( $rowflk = mysql_fetch_assoc($resultflk))
		             {  $b = 0;
		            				 
		
		
           include "config.php";
           $query3 = "SELECT max(average_weight) as avw FROM broiler_daily_entry  WHERE place = '$rowplc[place]' AND farm = '$rowfrm[farm]' AND supervisior = '$supervisor' AND flock = '$rowflk[flock]'   ";
           $result3 = mysql_query($query3,$conn1); 
           
           while($row3 = mysql_fetch_assoc($result3))
           { 
		    
			$b = round(($row3['avw']/1000),2);
			  
       ?>
             [<?php echo $i; ?>,<?php echo $b; ?>],
         <?php $i = $i + 1;  }
		 }
		 }
		 $main = 15;
		 if ( $i > 15)
		 {
		    $main = $i;
		  }
		 } ?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
			 
   


  
    

   



  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "FCR ",color:"#00ff00" },
		     { data: d3, label: "Avg Body Wt ",color:"#ff9999" }
             ],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: <?php echo $main; ?>, 
                      tickSize: 1,
					  label: "test"
                    },
             yaxis: { min: 0, max: 3, tickSize: 1 },
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


