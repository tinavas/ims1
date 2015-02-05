<?php
include("../config.php");
 $todate = date("Y-m-d",strtotime($_GET['tdate']));
$fromdate=date("Y-m-d",strtotime($_GET['fdate']));

	$query = "SELECT sum(amount) as cramount,coacode FROM ac_financialpostings WHERE crdr = 'Cr' AND date BETWEEN '$fromdate' AND '$todate'  GROUP BY coacode";

$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $crarray[$rows['coacode']] = $rows['cramount'];	

$query = "SELECT sum(amount) as dramount,coacode FROM ac_financialpostings WHERE crdr = 'Dr' AND date BETWEEN '$fromdate' AND 	'$todate'  GROUP BY coacode";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $drarray[$rows['coacode']] = $rows['dramount'];	
 
 
 
	$drtotal = 0;

  $crtotal = 0;

  $nexpsum = 0;

  $nrevsum = 0;

  $ecount = 0;

  $rcount = 0;

	

  $query1 = "select * from ac_coa where schedule in (select schedule from ac_schedule where (type = 'Expense') and ptype = 'Direct') order by type,code   ";

      $result1 = mysql_query($query1,$conn);

	   while($row2 = mysql_fetch_assoc($result1))

      {

	  $code = $row2['code']; 

	   $cramount = 0;

	   $dramount = 0;

	   $bal = 0;

	   $mbal = 0;

	    $cramount = $crarray[$code];
	    $dramount = $drarray[$code];
	  
	  $mbal = $dramount - $cramount;
	  if($mbal>0)
	  {
//$leftarray3[$row2['description']] = $mbal;
//$expensearray[]=array("code"=>$row2['description'],"bal"=>$mbal);
$finalval[$row2['description']]=$mbal;
}

		
}

	?>

	
	

	<?php

	$drtotal = 0;

    $crtotal = 0;

 

  $ecount = 0;

  $rcount = 0;

	 include "config.php";

    $query1 = "select * from ac_coa where (type = 'Expense') and schedule in (select schedule from ac_schedule where (type = 'Expense') and ptype <> 'Direct' ) order by description  ";

      $result1 = mysql_query($query1,$conn);

	   while($row2 = mysql_fetch_assoc($result1))

      {

	  $code = $row2['code']; 

	   $cramount = 0;

	   $dramount = 0;

	   $bal = 0;

	   $mbal = 0;

	  
	   $cramount = $crarray[$code];
	   $dramount = $drarray[$code];
	 
 $mbal = $dramount - $cramount;
 if($mbal>0)
 {

//$leftarray3[$row2['description']] = $mbal;
//$expensearray[]=$row2['description'],"bal"=>$mbal);
$finalval[$row2['description']]=$mbal;

}

		} // End detail records loop

	
//echo json_encode($expensearray);
//echo count($expensearray);




arsort($finalval);
foreach($finalval as $k=>$val)
{
$expensearray[]=$k;
}


//print_r($finalval);

if(count($finalval)>9)
{
$othersum=0;
for($i=0;$i<9;$i++)
{
 $expensearray1[]=array("code"=>$expensearray[$i],"bal"=>$finalval[$expensearray[$i]]);
}

for($i=count($expensearray);$i>=9;$i--)
{
$othersum=$othersum+$finalval[$expensearray[$i]];
}

 $expensearray1[]=array("code"=>"Others","bal"=>$othersum);

}

else
{

for($i=0;$i<count($finalval);$i++)
{
 $expensearray1[]=array("code"=>$expensearray[$i],"bal"=>$finalval[$expensearray[$i]]);
}

}



?>

 
 
 
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="include/jquery.min.js"></script>
        <script type="text/javascript"  src="include/js/highcharts.js"></script>
<!--<script type="text/javascript" src="include/js/modules/exporting.js"></script>-->
<script type="text/javascript" src="include/js/highcharts-3d.js"></script>
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
            text: 'Expenses'
        },
        subtitle: {
            text: ''
        },
  plotOptions: {
		
		 cursor: 'pointer',
		 
		    dataLabels: {
			
               
					
					
                   // color: '#000000',
                   // connectorColor: '#000000',
                    
                },
		minSize:100,
		series: {
		
                allowPointSelect: true,
				startAngle: 90,
				 /* dataLabels:{   
				    crop:false,
					overflow:'none'
					}*/
            },
            pie: {
			
			 dataLabels: {
			      enabled: false,
			         // crop:false,
					// overflow:"none",
					   //zIndex:6,
					   //borderRadius: 5,
                       //backgroundColor: 'rgba(252, 255, 197, 0.7)',
                       //borderWidth: 1,
                      // borderColor: '#AAA',
					   },
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Amount',
            data: [
			<?php 
			for($i=0;$i<count($expensearray1);$i++)
			{
			?>
			['<?php echo $expensearray1[$i]['code'];?>', <?php echo $expensearray1[$i]['bal'];?>],
			
			<?php 
			} ?>
			
               /* ['Bananas(cr)', 18],
                ['Kiwi', 3],
                ['Mixed nuts', 1],
                ['Oranges', 6],
                ['Apples', 8],
                ['Pears', 4], 
                ['Clementines', 4],
                ['Reddish (bag)', 1],
                ['Grapes (bunch)', 1]*/
            ]
        }]
    });
});
		</script>
	</head>
	<body>


<div id="container" style="height:400px; "></div>

	</body>
</html>
