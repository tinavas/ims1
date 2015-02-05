<?php
include("../config.php");

set_time_limit(0);
ini_set("memory_limit","-1");

/*$q1 = "SELECT max(fdate) as fdate from ac_definefy ";

$result = mysql_query($q1,$conn) or die(mysql_error());

while($row1 = mysql_fetch_assoc($result))

 {

 $fromdate = $row1['fdate'];

 $fromdate = date("Y-m-d",strtotime($fromdate));

 }
$tdate=date("Y-m-d");*/
 
 $tdate = date("Y-m-d",strtotime($_GET['tdate']));
$fromdate=date("Y-m-d",strtotime($_GET['fdate']));
$query = "SELECT sum(amount) as cramount,coacode FROM ac_financialpostings WHERE crdr = 'Cr' AND date<='$tdate' AND date>='$fromdate' GROUP BY coacode";

$result = mysql_query($query,$conn) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

 $crarray[$rows['coacode']] = $rows['cramount'];	



$query = "SELECT sum(amount) as dramount,coacode FROM ac_financialpostings WHERE crdr = 'Dr' AND date<='$tdate' AND date>='$fromdate' GROUP BY coacode";

$result = mysql_query($query,$conn) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

 $drarray[$rows['coacode']] = $rows['dramount'];	
 
 
 //print_r($crarray);
 //print_r($drarray);

	//Arrays starts here

	

	$leftcount = 0;
	$z=0;
	$y=0;
	$quer11 = "select distinct(schedule),type from ac_schedule where  schedule in ( select distinct(schedule) from ac_coa where type = 'Capital' or type = 'Liability' ) order by type, schedule  ";

	   $quers11 = mysql_query($quer11,$conn) or die(mysql_error());

	   while($row111 = mysql_fetch_assoc($quers11))

	   { 
	   if(($row111['type']=="Capital")&& ($y==0))
	   		{
				
				$ctotal=0;
				$leftarray2[$leftcount]=$row111['type'];
				$leftcount = $leftcount + 1;
		   $y=$y+1;
		   }
	   if(($row111['type']=="Liability")&& ($z==0))
	   		{
				$leftarray2[$leftcount]="Capital Total";
				$leftarray3[$leftcount]=$ctotal;
				$leftcount = $leftcount + 1;
				$leftarray2[$leftcount]=$row111['type'];
				$leftcount = $leftcount + 1;
		        $z=$z+1;
		   		$ltotal=0;
		   }
		$lefttot[$row111['schedule']]=0;
	     $coacount = 0;

		 $coacodes = "'dummy',";

		 $q1 = "SELECT code FROM ac_coa WHERE schedule = '$row111[schedule]'";

		 $r1 = mysql_query($q1,$conn) or die(mysql_error());

		 while($rr1 = mysql_fetch_assoc($r1))

		  $coacodes .= "'".$rr1[code]."',";

		 $coacodes = substr($coacodes,0,-1); 

		 

	      $quer = "select id from ac_financialpostings where coacode in ($coacodes)  and date <= '$tdate' AND date>='$fromdate' LIMIT 1 ";

	      $quers = mysql_query($quer,$conn) or die(mysql_error());

		  $coacount = mysql_num_rows($quers);

		 if ( $coacount > 0)

		  {

		      $leftarray1[$leftcount] = "";

			  $leftarray2[$leftcount] = $row111['schedule'];

			  $leftarray3[$leftcount] = "";

			  $leftcount = $leftcount + 1;

		      $quer = "select distinct(code),description from ac_coa where schedule = '$row111[schedule]' and ( type = 'Liability' or type = 'Capital') order by type, code ";

	          $quers = mysql_query($quer,$conn) or die(mysql_error());

		       while($row1 = mysql_fetch_assoc($quers))

			   {

			     $code = $row1['code']; 

	           

				$mbal = $crarray[$code] - $drarray[$code];

				if ( $mbal <> 0 )

				{

				  $leftarray1[$leftcount] = $row1['code'];

				  $leftarray2[$leftcount] = $row1['description'];

				    $leftarray3[$leftcount] = $mbal;
					$ctotal=$ctotal+$mbal;
					$ltotal=$ltotal+$mbal;
				    $leftcount = $leftcount + 1;
					$lefttot[$row111['schedule']]=$lefttot[$row111['schedule']]+$mbal;
				}
				
			   }

		  }
$leftarray3[$leftcount] = $lefttot[$row111['schedule']];
$leftcount = $leftcount + 1;
	   }
	
	foreach($lefttot as $schedule=>$value)
	{
if($value>0)
{
$schedules[]=$schedule;
$arrayval[$schedule]=$value;
}
}
?>


<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="include/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Liability/Capital'
        },
        subtitle: {
            text: ''
        },
		
		
		
        plotOptions: {
		
		series: {
                allowPointSelect: true
				//startAngle: 90,
				
            },
            pie: {
                innerSize: 100,
                depth: 45,
				 dataLabels: {
				 enabled: true,
					 
					   borderRadius: 5,
                       backgroundColor: 'rgba(252, 255, 197, 0.7)',
                       borderWidth: 1,
                       borderColor: '#AAA',
					   },
            }
        },
        series: [{
            name: 'Amount',
            data: [
			<?php
			for($i=0;$i<count($schedules);$i++)
			{
			?>
			['<?php echo $schedules[$i];?>', <?php echo $arrayval[$schedules[$i]];?>],
			
			<?php }?>
			]
        }]
    });
});
		</script>
	</head>
	<body>

<script src="include/js/highcharts.js"></script>
<script src="include/js/highcharts-3d.js"></script>


<div id="container" style="height: 400px"></div>
	</body>
</html>
