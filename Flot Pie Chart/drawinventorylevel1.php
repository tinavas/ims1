
<?php
include("../config.php");

set_time_limit(0);
ini_set("memory_limit","-1");

if($_GET['cat']<>"")
{
$cat=$_GET['cat'];
$cond="and cat='$cat'";
}
else
{
$cat='';
$cond='';
}


$q1="select date(now()),date_sub(date(now()),interval 1 month),date_sub(date(now()),interval 2 month),date_sub(date(now()),interval 3 month),date_sub(date(now()),
interval 4 month),date_sub(date(now()),interval 5 month),date_sub(date(now()),interval 6 month),date_sub(date(now()),interval 7 month),date_sub(date(now()),interval
 8 month),date_sub(date(now()),interval 9 month),date_sub(date(now()),interval 10 month),date_sub(date(now()),interval 11 month)";
 $q2=mysql_query($q1) or die(mysql_error());
 $r1=mysql_fetch_row($q2);
 
 //echo $r1[0],$r1[1],$r1[2],$r1[3],$r1[4],$r1[5],$r1[6],$r1[7],$r1[8],$r1[9];
 
 $montharray=array("January","February","March","April","May","June","July","August","September","October","November","December");
 
 
$exp=explode("-",$r1[0]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[1]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[2]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[3]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[4]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[5]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[6]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[7]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[8]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[9]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[10]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";
$exp=explode("-",$r1[11]);$startdate[]=$exp[0]."-".$exp[1]."-01";$enddate[]=$exp[0]."-".$exp[1]."-31";


//$allcatsum=0;
 
//print_r($startdate);
//print_r($enddate);

$q1=mysql_query("set group_concat_max_len=10000000000") or die(mysql_error());

$sql="select cat,group_concat(concat(\"'\",code,\"'\")) as code,group_concat(concat(\"'\",iac,\"'\")) as iac from ims_itemcodes where 1 $cond group by cat";
$sql=mysql_query($sql) or die(mysql_error());
while($r1=mysql_fetch_assoc($sql))
{

//$allcatsum[$r1['cat']]=0;

//echo $allcatsum[$r1['cat']];
$catval=array();

for($i=0;$i<count($startdate);$i++)
{

$monthyear=explode("-",$startdate[$i]);
$q2="select sum(amount) as amount from ac_financialpostings where coacode in ($r1[iac]) and itemcode in ($r1[code]) and crdr='Dr' and date between '$startdate[$i]' and '$enddate[$i]'";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
$dramount=$r2['amount'];

$q2="select sum(amount) as amount from ac_financialpostings where coacode in ($r1[iac]) and itemcode in ($r1[code]) and crdr='Cr' and date between '$startdate[$i]' and '$enddate[$i]'";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
$cramount=$r2['amount'];

$val=$dramount-$cramount;

if($val>0)
{

//echo $amount=$r1['cat']."-".$r2['amount'],"<br/>";
$allcatsum[$r1['cat']][$monthyear[0]][$monthyear[1]]=$allcatsum[$r1['cat']][$monthyear[0]][$monthyear[1]]+$val;

$allcatsums[$monthyear[1]]=$allcatsums[$monthyear[1]]+$val;

$catval[]=$val/1000000;


}
else
{
//echo $amount=$r1['cat']."-"."0","<br/>";
$allcatsum[$r1['cat']][$monthyear[0]][$monthyear[1]]=$allcatsum[$r1['cat']][$monthyear[0]][$monthyear[1]]+0;
$allcatsums[$monthyear[1]]=$allcatsums[$monthyear[1]]+0;
$catval[]=0;
}




$monthyear=explode("-",$startdate[$i]);
if($monthyear[1]<10)
{
$monthyear1=str_replace("0","",$monthyear[1]);
}
else
{
$monthyear1=$monthyear[1];
}

$xaxis[$i]=$montharray[$monthyear1-1]."-".$monthyear[0];



}
}

/*for($i=count($xaxis)-1;$i>=0;$i++)
{
$xaxis1[]=$xaxis[$i];
}*/
//print_r($allcatsum);
//print_r($allcatsums);
$allcatsumsr=array_reverse($allcatsums,true);
//print_r($allcatsumsr);

//print_r($xaxis);
//echo count($xaxis);

for($k=count($xaxis)-1;$k>=0;$k--)
{
$xaxis1[]=$xaxis[$k];
}

//print_r($montharray);

//echo json_encode($catval);
//echo json_encode($allcatsum);

$preserved = array_reverse($catval);
//$preserved = ($catval);
for($i=0;$i<count($preserved);$i++)
{
//echo $preserved[$i];

$catval1[]=$preserved[$i];
}



foreach($allcatsumsr as $k=>$v)
{
$allcatsum1[]=$v/1000000;
}

//print_r($catval1);

//echo json_encode($catval1);

//echo json_encode($allcatsum1);


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
		   
		   
        $('#container').highcharts({
            chart: 
			{
               zoomType: 'x'
            },
            title: {
                text: ''
            },
            
            xAxis: {
			
			 title: {
                    text: '<?php echo "<p style=\"color:red\"><b>Months</b></p>";?>'
                },
                categories: <?php echo json_encode($xaxis1);?>
            },
            yAxis: {
			//min:0,
                title: {
                    text: '<?php echo "<p style=\"color:red\"><b>Value in amounts(millions)</b></p>";?>'
                }
            },
			
			   tooltip: {
               formatter: function () {
        return 'Month And Year: <b>' + this.x + '</b><br> Value: <b>' + intToFormat(this.y*1000000) + '</b>';
    }
            },
			
			
            legend: {
                enabled: true
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
    
            series: [
			
			<?php
			if($_GET['cat']<>"")
			{
			?>
			{   type: 'areaspline',
              
                //pointInterval: 24 * 3600 * 1000,
                //pointStart: Date.UTC(2006, 0, 01),
                name: '<?php echo $cat;?>',
                data: <?php echo json_encode($catval1);?>
            }
			
			<?php }else
			
			{
			?>
			{
			    type: 'areaspline',
                name: 'All Categories',
                //pointInterval: 24 * 3600 * 1000,
                //pointStart: Date.UTC(2006, 0, 01),
                
                data: <?php echo json_encode($allcatsum1);?>
            }
			
			<?php }?>
			/*{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 11.5]
            }*/
			
			
			]
         
        });
    });
    

		</script>
	</head>
	<body>
<script src="include/js/highcharts.js"></script>
<!--<script src="include/js/modules/exporting.js"></script>-->
<br/><br/><br/><br/>


<div align="center" style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; ">Select Category:<select name="cat" id="cat" onChange="reloadpage(this.value)" style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; "><option value="">-All-</option>
<?php
$q1="select distinct cat from ims_itemcodes order by cat";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['cat'];?>" title="<?php echo $r1['cat'];?>" <?php if($r1['cat']==$_GET['cat']){?>selected="selected" <?php }?> ><?php echo $r1['cat'];?></option>

<?php }?>
</select>
</div>
<br/><br/>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
<script type="text/javascript">
function reloadpage(cat)
{
document.location='drawinventorylevel1.php?cat='+cat;
}


</script>