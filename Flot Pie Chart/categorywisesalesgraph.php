<!DOCTYPE HTML>

<?php
$starttime=microtime();
//$conn=mysql_connect("localhost","root","") or die(mysql_error());
//$db=mysql_select_db("ims");

//procudure to create and call
/*
delimiter $$
create procedure getpastthreemonthsales(out saleamount varchar(100))
begin
declare b int(100);
declare k int(100);
declare allamount varchar(100);
declare code1,coa1 varchar(100);
declare amount1 varchar(100);
declare c1 cursor for select `code`,sac from ims_itemcodes where iusage in ('Produced or Sale','Sale');
select count(code) into b  from ims_itemcodes where iusage in ('Produced or Sale','Sale');
set allamount=0;
set k=0;
OPEN c1;
REPEAT
FETCH c1 INTO code1,coa1;
select sum(amount) into amount1 from ac_financialpostings where coacode=coa1 and crdr='Cr' and itemcode=code1 and date>DATE_SUB(date(now()),INTERVAL 5 month);
if amount1 is null then
set amount1=0;
end if;
set allamount=allamount+amount1;
set k=k+1;
UNTIL b = k
END REPEAT;
set saleamount=allamount;
end
$$
delimiter;
*/
include ("../config.php");

$q10=mysql_query("set group_concat_max_len=1000000000");
$q1="select distinct cat,code,sac from ims_itemcodes where iusage in ('Produced or Sale','Sale') order by cat";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
//echo "sdfds";
$q3="select sum(amount) as amount1 from ac_financialpostings where coacode='$r1[sac]' and crdr='Cr' and itemcode='$r1[code]'  and date>DATE_SUB(date(now()),INTERVAL 5 month) ";
$q3=mysql_query($q3) or die(mysql_error());
$r3=mysql_fetch_assoc($q3);

//$catall[$r1['cat']][$r1['code']]=$r3['amount1'];
$catall[$r1['cat']]=$catall[$r1['cat']]+$r3['amount1'];
}
//print_r($catall);
//array_sum($catall);
arsort($catall);
foreach($catall as $k=>$val)
{
$catcode[]=$k;
}

$totsum=0;
//$q1=mysql_query("call getallsalesamount(@val)") or die(mysql_error());
$q1=mysql_query("call getpastthreemonthsales(@val)") or die(mysql_error());
$q1=mysql_query("select @val as value") or die(mysql_error());
$r1=mysql_fetch_row($q1);
 $totsum=$r1[0];

for($i=0;$i<9;$i++)
{
$per=(round(($catall[$catcode[$i]]/$totsum)*100,6));
if($per>0)
{
$first[]=array("code"=>$catcode[$i],"per"=>$per,"amount"=>$catall[$catcode[$i]]);
}
}

for($i=count($catcode);$i>=9;$i--)
{
//$per=(round(($catall[$catcode[$i]]/$totsum)*100,6));
//$second[]=array("code"=>$catcode[$i],"per"=>$per,"amount"=>$catall[$catcode[$i]]);
$otherssum=$otherssum+$catall[$catcode[$i]];
}

$othersper=(round(($otherssum/$totsum)*100,6));

//print_r($first);
//echo $othersper;







?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
        <!--<script type="text/javascript" src="../jquery.min.js"></script>-->
        <script type="text/javascript" src="include/jquery.min.js"></script>
        
		<script type="text/javascript">$(function () {
		//to set the desired colors
		
		  /*Highcharts.setOptions({
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
    });*/
    $('#container').highcharts({
	
 chart: {
            type: 'pie',
            options3d: {
				enabled: true,
                alpha: 35,
                beta: 0,
				
				
            },           
			 //borderColor: '#EBBA95',
            //borderWidth: 2,
           // type: 'line',
			//zoomType:'xy',
			//shadow:true
        },
		
		
        title: {
            text: 'Sales of Top 9 Categories(Last 5 months)'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 50,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
					
					
                },
				
				 animation:true
				
				//showInLegend: true
            }
        },
        series: [{
            type: 'pie',
            name: 'Item share',
            data: [
              
				 <?php
				for($i=0;$i<count($first);$i++)
{
//echo $item[$i]['code'],"-",(round(($item[$i]['amount']/$totsum)*100,2)),"<br/>";
//$persum=$persum+(round(($item[$i]['amount']/$totsum)*100,3));
?>
				{
                    name: '<?php echo $first[$i]['code'];?> ',
                    y: <?php echo $first[$i]['per'];?> ,
                    sliced: true,
                    selected: true
                },
				<?php
				
				//$persum=$persum+(round(($item[$i]['amount']/$totsum)*100,3));
				
				 }
				 ?>
			  <?php if(count($catcode)>0 )
			  {?>
				
				{
                    name: 'Other Sales ',
                    y: <?php echo $othersper?> ,
                    sliced: true,
                    selected: true
                }
				<?php }?>
				
				
            ]
        }]
    });
});
		</script>
	</head>
  <?php 
  
 //echo $persum,"<br/>";
//echo $others=round(100-$persum,2),"<br/>";
?>

    
	<body >
<!--<script src="../../js/highcharts.js"></script>
<script src="../../js/modules/exporting.js"></script>-->
<script type="text/javascript"  src="include/js/highcharts.js"></script>
<!--<script type="text/javascript" src="include/js/modules/exporting.js"></script>-->
<script type="text/javascript" src="include/js/highcharts-3d.js"></script>
<link href="layout.css" rel="stylesheet" type="text/css"></link>
        <link href="css/common.css" rel="stylesheet" type="text/css">
	    <link href="css/standard.css" rel="stylesheet" type="text/css">

 
<div id="container" style="min-width: 310px; height: 450px; max-width: 600px; margin: 0 auto; style="background-color:#70828f; ></div>

	</body>
</html>
<script type="text/javascript">
function getcat(val)
{
document.location='example1.php?cat='+val;
}
</script>
<?php
//$endtime=microtime();
//echo $tottime=($endtime-$starttime);

?>