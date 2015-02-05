<?php
include("../config.php");

set_time_limit(0);
ini_set("memory_limit","-1");

$q1 = "SELECT max(fdate) as fdate from ac_definefy ";

$result = mysql_query($q1,$conn) or die(mysql_error());

while($row1 = mysql_fetch_assoc($result))

 {

 $fromdate = $row1['fdate'];

 $fromdate = date("Y-m-d",strtotime($fromdate));

 }
$tdate=date("Y-m-d");
 
 
$query = "SELECT sum(amount) as cramount,coacode FROM ac_financialpostings WHERE crdr = 'Cr' AND date<='$tdate' GROUP BY coacode";

$result = mysql_query($query,$conn) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

 $crarray[$rows['coacode']] = $rows['cramount'];	



$query = "SELECT sum(amount) as dramount,coacode FROM ac_financialpostings WHERE crdr = 'Dr' AND date<='$tdate' GROUP BY coacode";

$result = mysql_query($query,$conn) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

 $drarray[$rows['coacode']] = $rows['dramount'];	
 
 
$rightcount = 0;

	$quer11 = "select distinct(schedule),type from ac_schedule where  schedule in ( select distinct(schedule) from ac_coa where type = 'Asset' ) order by schedule  ";

	   $quers11 = mysql_query($quer11,$conn) or die(mysql_error());

	   while($row111 = mysql_fetch_assoc($quers11))

	   { 
		$righttot[$row111['schedule']]=0;
	     $coacount = 0;

		 $coacodes = "'dummy',";

		 $q1 = "SELECT code FROM ac_coa WHERE schedule = '$row111[schedule]'";

		 $r1 = mysql_query($q1,$conn) or die(mysql_error());

		 while($rr1 = mysql_fetch_assoc($r1))

		  $coacodes .= "'".$rr1[code]."',";

		 $coacodes = substr($coacodes,0,-1); 

		 

	      $quer = "select id from ac_financialpostings where coacode in ($coacodes) and date <= '$tdate' LIMIT 1 ";

	      $quers = mysql_query($quer,$conn) or die(mysql_error());

		  $coacount = mysql_num_rows($quers);

		  if ( $coacount > 0)

		  {

		      $rightarray1[$rightcount] = "";

			  $rightarray2[$rightcount] = $row111['schedule'];

			  $rightarray3[$rightcount] = "";

			  $rightcount = $rightcount + 1;

		      $quer = "select distinct(code),description from ac_coa where schedule = '$row111[schedule]' and ( type = 'Asset') order by code ";

	          $quers = mysql_query($quer,$conn) or die(mysql_error());

		       while($row1 = mysql_fetch_assoc($quers))

			   {

			     $code = $row1['code'];
				 $mbal = $drarray[$code] - $crarray[$code];

				if ( $mbal <> 0 )

				{

				  $rightarray1[$rightcount] = $row1['code'];

				  $rightarray2[$rightcount] = $row1['description'];

				 $rightarray3[$rightcount] = $mbal;
				 $righttot[$row111['schedule']]=$righttot[$row111['schedule']]+$mbal;

				  $rightcount = $rightcount + 1;

				}
 
			   }

		  }
$rightarray3[$rightcount] = $righttot[$row111['schedule']];
 $rightcount = $rightcount + 1;
	   }


	
	foreach($righttot as $schedule=>$value)
	{
if($value>0)
{
$schedulesa[]=$schedule;
$arrayvala[$schedule]=$value;
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

//code to set the theme
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

//--------


    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Assets'
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
			for($i=0;$i<count($schedulesa);$i++)
			{
			?>
			['<?php echo $schedulesa[$i];?>', <?php echo round($arrayvala[$schedulesa[$i]],2);?>],
			
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
