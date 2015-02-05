<?php
include "../config.php";
set_time_limit(0);
ini_set("memory_limit","-1");
ini_set("max_execution_time","0");

if($_GET['fromdate']<>"" && $_GET['todate']<>"")
{
$fromdate=date("Y-m-d",strtotime($_GET['fromdate']));
$todate=date("Y-m-d",strtotime($_GET['todate']));
}
else
{
$q1="SELECT min(fdate) as fdate FROM `ac_definefy`";
$q1=mysql_query($q1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
$fromdate=$r1['fdate'];
$todate=date("Y-m-d");
}
$q1=mysql_query("set group_concat_max_len=4294967295"); 
$l = $r = $s = -1; $totalcredit = $totaldebit = 0;
$query = "SELECT code FROM ac_coa WHERE controltype IN ('Cash','Bank') and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $coas .= "'$rows[code]',";
$coas = substr($coas,0,-1);


$obcredit = $obdebit = 0;
  $query1 = "SELECT SUM(amount) as amount,crdr FROM ac_financialpostings WHERE coacode in ($coas) AND client = '$client' AND date < '$fromdate' GROUP BY crdr ORDER BY crdr";
 $result1 = mysql_query($query1,$conn) or die(mysql_error());
 while($rows1 = mysql_fetch_assoc($result1))
 {
  if($rows1['crdr'] == 'Cr')
   $obcredit = $rows1['amount'];
  elseif($rows1['crdr'] == 'Dr')
    $obdebit = $rows1['amount'];
 }
 $ob = ($obcredit - $obdebit);
 $obcrdr = "Cr";
 if($ob < 0)
 { $obcrdr = "Dr"; $ob = -$ob; }
 
$opinoutflow=array($obcredit,$obdebit);
$openingbalance=array("crdr"=>$obcrdr,"value"=>$ob);


$q1="select group_concat(distinct trnum) trnum from ac_financialpostings where coacode in ($coas) and date between '$fromdate' and '$todate' ";
$q1=mysql_query($q1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
$alltrnum=$r1['trnum'];
$alltrnums="'".str_replace(",","','",$alltrnum)."'";

//-----------------------------------------------------------------------
// if the group_concat does nto work use below method to fetch the all trnums which has all bank and cash transactions


/*$q1="select distinct trnum from ac_financialpostings where coacode in ($coas) ";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$trnumarray[]=$r1['trnum'];
}
 $alltrnums="'".implode("','",$trnumarray)."'";*/
//$alltrnum="'".str_replace(",","','",$trnumimplode)."'";

//---------------------------------------------------------

$query1 = "SELECT distinct(schedule) FROM ac_coa WHERE client = '$client' ORDER BY schedule";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
$q1="select group_concat(concat(\"'\",code,\"'\")) as shedulecode from ac_coa where schedule='$rows1[schedule]'";
$q1=mysql_query($q1) or die(mysql_error());
$r1=mysql_fetch_assoc($q1);
 $shedulecode=$r1['shedulecode'];

$cramount = $dramount = 0; $displaycrdr = "";
  $query2 = "SELECT SUM(amount) as amount,crdr FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' and trnum in ($alltrnums) AND coacode in($shedulecode) AND coacode NOT IN ($coas) and crdr='Cr' ";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 if($rows2['amount']!="")
 {
 $crarray[]=array("schedule"=>$rows1[schedule],"val"=>$rows2['amount']);
 }
 }
 
 
 $cramount = $dramount = 0; $displaycrdr = "";
  $query2 = "SELECT SUM(amount) as amount,crdr FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' and trnum in ($alltrnums) AND coacode in($shedulecode) AND coacode NOT IN ($coas) and crdr='Dr' ";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  if($rows2['amount']!="")
 {
 $drarray[]=array("schedule"=>$rows1[schedule],"val"=>$rows2['amount']);
 }
 }
 
 
} 

//print_r($crarray);
//print_r($drarray);

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Cash Flow statement</title>
        <link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<script type="text/javascript" src="jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"fromdate",
			dateFormat:"%d.%m.%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
		new JsDatePick({
			useMode:2,
			target:"todate",
			dateFormat:"%d.%m.%Y"
			/*selectedDate:{				This is an example of what the full configuration offers.
				day:5,						For full documentation about these settings please see the full version of the code.
				month:9,
				year:2006
			},
			yearsRange:[1978,2020],
			limitToToday:false,
			cellColorScheme:"beige",
			dateFormat:"%m-%d-%Y",
			imgPath:"img/",
			weekStartDay:1*/
		});
	};
	function reloadpage()
{

var fromdate=document.getElementById("fromdate").value;
var todate=document.getElementById("todate").value;
document.location="cashflowgraph1.php?fromdate="+fromdate+"&todate="+todate;


}
</script>

		<script type="text/javascript" src="include/jquery.min.js"></script>
		<script type="text/javascript">
$(function () 
{

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


 
    $('#container1').highcharts({
	chart: {
          
          
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
       
           type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Out Flow'
        },
        subtitle: {
            text: '<?php echo "";?>'
        },
  plotOptions: {
		
		 cursor: 'pointer',
		 
		    dataLabels: {
			
                    enabled: true,
					crop:false,
					//overflow:"none",
					 distance: -30,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return this.point.name +': '+ this.percentage.toFixed(2);  
                    },
                    xformat: '<b>{point.name}</b>: {point.percentage:.1f} %'
                },
		minSize:100,
		series: {
		
                allowPointSelect: true,
				  dataLabels:{   
				    crop:false,
					overflow:'none'
					}
            },
            pie: {
			
			 dataLabels: {
					   zIndex:6,
					   borderRadius: 5,
                       backgroundColor: 'rgba(252, 255, 197, 0.7)',
                       borderWidth: 1,
                       borderColor: '#AAA',
					   },
                //innerSize: 100,
                depth: 45
            }
        },
		
		tooltip: {
        formatter: function () 
              {
            return '<b>'+this.point.name+':'+intToFormat(this.y)+'</b>';
              }
			  },
        series: [{
            name: 'Things',
            colorByPoint: true,
            data: [
			<?php
			for($i=0;$i<count($crarray);$i++)
			{
			?>
			{
                name: '<?php echo $crarray[$i]['schedule'];?>',
                y: <?php echo $crarray[$i]['val'];?>,
				sliced:true
                
            }, 
			<?php }?>
			
			]
        }]
		 
		
		
		
		
		
    });
});

$(function () 
{
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


 
    $('#container2').highcharts({
	chart: {
          
          
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
       
           type: 'pie',
            options3d: {
				enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'In Flow'
        },
        subtitle: {
            text: '<?php echo "";?>'
        },
  plotOptions: {
		
		 cursor: 'pointer',
		 
		    dataLabels: {
			
                    enabled: true,
					crop:false,
					//overflow:"none",
					 distance: -30,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return this.point.name +': '+ this.percentage.toFixed(2);  
                    },
                    xformat: '<b>{point.name}</b>: {point.percentage:.1f} %'
                },
		minSize:100,
		series: {
		
                allowPointSelect: true,
				  dataLabels:{   
				    crop:false,
					overflow:'none'
					}
            },
            pie: {
			
			 dataLabels: {
					   zIndex:6,
					   borderRadius: 5,
                       backgroundColor: 'rgba(252, 255, 197, 0.7)',
                       borderWidth: 1,
                       borderColor: '#AAA',
					   },
                //innerSize: 100,
                depth: 45
            }
        },
		tooltip: {
        formatter: function () 
              {
            return '<b>'+this.point.name+':'+intToFormat(this.y)+'</b>';
              }
			  },
		
        series: [{
            name: 'Things',
            colorByPoint: true,
            data: [
			<?php
			for($i=0;$i<count($drarray);$i++)
			{
			?>
			{
                name: '<?php echo $drarray[$i]['schedule'];?>',
                y: <?php echo $drarray[$i]['val'];?>,
				sliced:true
                
            }, 
			<?php }?>
			
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
<script  type="text/javascript"  src="include/js/drilldown.js"></script>
<table align="center">
<tr><td td colspan="2" style="text-align:center;font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif;">
<span>From Date:</span><input type="text" id="fromdate" value="<?php echo date("d.m.Y",strtotime($fromdate));?>" ><span>To Date:</span><input type="text" id="todate"value="<?php echo date("d.m.Y",strtotime($todate));?>" ><input type="button" value="Get Chart" onClick="reloadpage()" style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; "></td></tr>
<tr><td colspan="2" style="text-align:center"><span style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; ">Opening Balance(<?php echo $ob."(".$obcrdr.")";?>)</span></td></tr>
<tr>
<td style="width:700px" ><div id="container1" style="height: 600px"></div></td>
<td style="width:700px" ><div id="container2" style="height: 600px"></div></td>
</tr>
</table>
	</body>
</html>
