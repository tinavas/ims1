<?php
include("../config.php");
$q1 = "SELECT max(fdate) as fdate from ac_definefy ";

$result = mysql_query($q1,$conn) or die(mysql_error());

while($row1 = mysql_fetch_assoc($result))

 {

 $fromdate = $row1['fdate'];

 $fromdate = date("Y-m-d",strtotime($fromdate));

 }
 $todate=date("Y-m-d");
 

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

	

  $query1 = "select * from ac_coa where schedule in (select schedule from ac_schedule where (type = 'Revenue') and ptype = 'Direct') order by type,code   ";

      $result1 = mysql_query($query1,$conn) or die(mysql_error());

	   while($row2 = mysql_fetch_assoc($result1))

      {

	  $code = $row2['code']; 

	   $cramount = 0;

	   $dramount = 0;

	   $bal = 0;

	   $mbal = 0;

	    $cramount = $crarray[$code];
	    $dramount = $drarray[$code];
	  
	  $mbal = $cramount - $dramount;
	  if($mbal>0)
	  {
//$leftarray3[$row2['description']] = $mbal;
$expensearray[]=array("code"=>$row2['description'],"bal"=>$mbal);
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

    $query1 = "select * from ac_coa where (type = 'Revenue') and schedule in (select schedule from ac_schedule where (type = 'Revenue') and ptype <> 'Direct' ) order by description  ";

      $result1 = mysql_query($query1,$conn) or die(mysql_error());

	   while($row2 = mysql_fetch_assoc($result1))

      {

	  $code = $row2['code']; 

	   $cramount = 0;

	   $dramount = 0;

	   $bal = 0;

	   $mbal = 0;

	  
	   $cramount = $crarray[$code];
	   $dramount = $drarray[$code];
	 
 $mbal = $cramount - $dramount;
 if($mbal>0)
 {

//$leftarray3[$row2['description']] = $mbal;
//$expensearray[]=array("code"=>$row2['description'],"bal"=>$mbal);
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
		<script type="text/javascript">
$(function () {

function intToFormat(nStr) {
<?php if($_SESSION['millionformate']) { ?>


        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
		

<?php } else

{
?>
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    var z = 0;
    var len = String(x1).length;
    var num = parseInt((len / 2) - 1, 10);

    while (rgx.test(x1)) {
        if (z > 0) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        } else {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
            rgx = /(\d+)(\d{2})/;
        }
        z++;
        num--;
        if (num === 0) {
            break;
        }
    }
    return x1 + x2;
	<?php }?>
}


/**
 * Sand-Signika theme for Highcharts JS
 * @author Torstein Honsi
 */

// Load the fonts
Highcharts.createElement('link', {
   href: 'http://fonts.googleapis.com/css?family=Signika:400,700',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

// Add the background image to the container
Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
   proceed.call(this);
   this.container.style.background = 'url(http://www.highcharts.com/samples/graphics/sand.png)';
});


Highcharts.theme = {
   colors: ["#f45b5b", "#8085e9", "#8d4654", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: null,
      style: {
         fontFamily: "Signika, serif"
      }
   },
   title: {
      style: {
         color: 'black',
         fontSize: '16px',
         fontWeight: 'bold'
      }
   },
   subtitle: {
      style: {
         color: 'black'
      }
   },
   tooltip: {
      borderWidth: 0
   },
   legend: {
      itemStyle: {
         fontWeight: 'bold',
         fontSize: '13px'
      }
   },
   xAxis: {
      labels: {
         style: {
            color: '#6e6e70'
         }
      }
   },
   yAxis: {
      labels: {
         style: {
            color: '#6e6e70'
         }
      }
   },
   plotOptions: {
      series: {
         shadow: true
      },
      candlestick: {
         lineColor: '#404048'
      },
      map: {
         shadow: false
      }
   },

   // Highstock specific
   navigator: {
      xAxis: {
         gridLineColor: '#D0D0D8'
      }
   },
   rangeSelector: {
      buttonTheme: {
         fill: 'white',
         stroke: '#C0C0C8',
         'stroke-width': 1,
         states: {
            select: {
               fill: '#D0D0D8'
            }
         }
      }
   },
   scrollbar: {
      trackBorderColor: '#C0C0C8'
   },

   // General
   background2: '#E0E0E8'
   
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);


    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Revenue'
        },
        subtitle: {
            text: '<?php //echo "<b>Revenue</b>";?>'
        },
        plotOptions: {
		  series: {
                allowPointSelect: true,
				//startAngle: 90,
				
            },
            pie: {
			
                innerSize: 100,
                depth: 45,
				 dataLabels: {
				 enabled: false,
					 
					   borderRadius: 5,
                       backgroundColor: 'rgba(252, 255, 197, 0.7)',
                       borderWidth: 1,
                       borderColor: '#AAA',
					   },
            }
        },
		tooltip: {
        formatter: function () 
              {
            return '<b>'+this.point.name+':'+intToFormat(this.y)+'</b>';
              }
			  },
		
        series: [{
            name: 'Amount',
            data: [
			<?php 
			for($i=0;$i<count($expensearray1);$i++)
			{
			?>
			['<?php echo $expensearray1[$i]['code'];?>', <?php echo round($expensearray1[$i]['bal'],2);?>],
			
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
<script type="text/javascript"  src="include/js/highcharts.js"></script>
<!--<script type="text/javascript" src="include/js/modules/exporting.js"></script>-->
<script type="text/javascript" src="include/js/highcharts-3d.js"></script>
<!--<br/><br/><br/><br/><br/><br/><br/>-->
<div id="container" style="height: 400px"></div>
	</body>
</html>
