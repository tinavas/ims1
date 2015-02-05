<!DOCTYPE HTML>
<?php
//$conn=mysql_connect("localhost","root","") or die(mysql_error());
//$db=mysql_select_db("ims");

//procudure to create and call
/*
delimiter $$
create procedure getallsalesamount(out saleamount varchar(100))
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
select sum(amount) into amount1 from ac_financialpostings where coacode=coa1 and crdr='Cr' and itemcode=code1;
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

*/

$conn=mysql_connect("localhost","root","") or die(mysql_error());
$db=mysql_select_db("central");
$q1=mysql_query("select  * from ims_itemcodes where cat='$_GET[cat]' and iusage in ('Produced or Sale','Sale')") or die(mysql_error());
$totsum=0;
while($r1=mysql_fetch_assoc($q1))
{
$amount=0;
$code=$r1['code'];
$coacode=$r1['sac'];
$q2="select sum(amount) as amount from ac_financialpostings where coacode='$coacode' and crdr='Cr' and itemcode='$code'";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
if($r2['amount']>=0 && $r2['amount']!="")
{
//$item[]=array("code"=>$code,"amount"=>$r2['amount']);
$itemval[$code]=$r2['amount'];
}
$totsum=$totsum+$r2['amount'];
//echo $code,"-",$amount,"<br/>";
}

/*$persum=0;
$totsum=0;
$q1=mysql_query("call getallsalesamount(@val)") or die(mysql_error());
$q1=mysql_query("select @val as value") or die(mysql_error());
$r1=mysql_fetch_row($q1);
 $totsum=$r1[0];*/

arsort($itemval);

foreach($itemval as $k=>$val)
{
$itemcode[]=$k;
}


$otherssum=0;

if(count($itemcode)>10)
{
for($i=0;$i<9;$i++)
{
$per=(round(($itemval[$itemcode[$i]]/$totsum)*100,6));
if($per>0)
{
$first[]=array("code"=>$itemcode[$i],"per"=>$per,"amount"=>$itemval[$itemcode[$i]]);
}
}

for($i=count($itemcode);$i>=9;$i--)
{
//$per=(round(($itemval[$itemcode[$i]]/$totsum)*100,6));
//$second[]=array("code"=>$itemcode[$i],"per"=>$per,"amount"=>$itemval[$itemcode[$i]]);
$otherssum=$otherssum+$itemval[$itemcode[$i]];
}

$othersper=(round(($otherssum/$totsum)*100,6));

}
else
{
for($i=0;$i<count($itemcode);$i++)
{
$per=(round(($itemval[$itemcode[$i]]/$totsum)*100,6));
if($per>0)
{
$first[]=array("code"=>$itemcode[$i],"amount"=>$per,"per"=>$per);
}
}
$othersper=0;
}
//print_r($itemcode);echo "<br/>";
//print_r($first);echo "<br/>";
//print_r($second);




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
            text: 'Sales of Items'
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
			  <?php if(count($itemcode)>0 )
			  {?>
				
				{
                    name: 'Other Sales ',
                    y: <?php echo $othersper?> ,
                    sliced: true,
                    selected: true
                },
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

    
	<body>
<!--<script src="../../js/highcharts.js"></script>
<script src="../../js/modules/exporting.js"></script>-->
<script type="text/javascript"  src="include/js/highcharts.js"></script>
<script type="text/javascript" src="include/js/modules/exporting.js"></script>
<script type="text/javascript" src="include/js/highcharts-3d.js"></script>

  <div align="center">Category:<select name="cat" id="cat" onChange="getcat(this.value)" ><option value="">-All-</option>
    <?php
	$q1="select  distinct cat from ims_itemcodes where iusage in ('Produced or Sale','Sale') order by cat";
	$q1=mysql_query($q1) or die(mysql_error());
	while($r1=mysql_fetch_assoc($q1))
	{
	?>
    <option value="<?php echo $r1['cat'];?>" title="<?php echo $r1['cat'];?>" <?php if($_GET['cat']==$r1['cat']){?>selected="selected" <?php }?> ><?php echo $r1['cat'];?></option>
    <?php }?>
    </select>
    </div>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto;" ></div>

	</body>
</html>
<script type="text/javascript">
function getcat(val)
{
document.location='example1.php?cat='+val;
}
</script>