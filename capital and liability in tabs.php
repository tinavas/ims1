<?php

include "../../config.php";

//include "../../jquery.php";

 $q1 = "SELECT max(fdate) as fdate from ac_definefy ";

$result = mysql_query($q1,$conn);

while($row1 = mysql_fetch_assoc($result))

 {

 $fromdate = $row1['fdate'];

 $fromdate = date("d.m.Y",strtotime($fromdate));

 }


?>

<!DOCTYPE html>
<html lang="en-us">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" />
  <meta name="description" content="Liquid Slider : The Last Responsive Content Slider You'll Ever Need" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
     <link rel="stylesheet" type="text/css" media="all" href="../jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date2",
			dateFormat:"%d.%m.%Y"
		
		});
		new JsDatePick({
			useMode:2,
			target:"date3",
			dateFormat:"%d.%m.%Y"
			
		});
	};

</script>

  <!-- Optionally use Animate.css -->
  <link rel="stylesheet" href="animate.min.css">
  <link rel="stylesheet" href="./css/liquid-slider.css">

  <title></title>
   
</head>
<body class="no-js">
  <div id="main-slider" class="liquid-slider">
  
    <div style="background:white;">
      <h2 class="title" style="visibility:hidden; color:#000000" >Assets And Liabilities</h2>
      <p ><iframe src="../ac_assets.php" align="right" height="700" width="600"  frameborder="0"  ></iframe>
      <iframe src="../capital and liability.php" align="right" height="700" width="600"  frameborder="0"  ></iframe></p>
    </div>
    
     <div style="background:white;">
      <h2 class="title" style="visibility:hidden" >Expenses and Revenue</h2>
      
      <div align="center">
      
      
      <label style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; "><strong>From Date:</strong></label><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo $fromdate; ?>" onChange="datecomp();"  >
      
      
      
      <label style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; "><strong>To Date:</strong></label>
      <input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();" >
      
      
      <label style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; "><strong>Warehouses:</strong></label>
      <select id="costcenter" name="costcenter" multiple="multiple" size="4" onChange="cal_costcenter(this.value)">
	<option value="all">-All-</option>
		  <?php
  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
 $q1 ="SELECT DISTINCT (sector) as sector FROM tbl_sector order by sector";
 }
 else
 {
  $sectorlist = $_SESSION['sectorlist'];
 $q1 ="SELECT  DISTINCT (sector) as sector FROM tbl_sector WHERE sector in ($sectorlist) order by sector";
 }
  $result = mysql_query($q1,$conn) or dir(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['sector'];?>" selected="selected"><?php echo $rows['sector'];?></option>
  <?php
  }
  ?>
    </select>&nbsp;&nbsp;<input type="button" value="Get Chart" onClick="getchart()" style="font-family: 'Lucida Grande', 'Lucida Sans Unicode', Arial, Helvetica, sans-serif; ">
    
    
    
    
      </div>
      
      <p ><iframe src="../expenseandrevenue1.php?warehouse=all&fromdate=<?php echo $fromdate;?>&todate=<?php echo date("d.m.Y");?>" align="right" height="700" width="600"  frameborder="0"  id="revenue" ></iframe>
      <iframe src="../expenseandrevenue.php?warehouse=all&fromdate=<?php echo $fromdate;?>&todate=<?php echo date("d.m.Y");?>" align="right" height="700" width="600"  frameborder="0" id="exp"  ></iframe></p>
    </div>
    
    
    
      <div style="background:white;">
      <h2 class="title" style="visibility:hidden" >Cash Flow</h2>
      <p >
     <iframe src="../cashflowgraph1.php" align="right" height="700" width="1250"  frameborder="0"  ></iframe>
      </p>
    </div>
    
    
    
    
  
  </div>
<footer>
 <script src="jquery.min.js"></script>
  <script src="jquery.easing.min.js"></script>
  <script src="jquery.touchSwipe.min.js"></script>
  <script src="./js/jquery.liquid-slider.min.js"></script>  
  <script>
    /**
     * If you need to access the internal property or methods, use this:
     * var api = $.data( $('#main-slider')[0], 'liquidSlider');
     * console.log(api);
     */
    $('#main-slider').liquidSlider();
	
	
	function cal_costcenter(val)
{
s=0;

var cc=document.getElementById("costcenter");
if(val=="all")
{
s=1;
for(var i=0;i<cc.length;i++)
{
cc.options[i].selected=true;
}
}
cc.options[0].selected=false;
//alert(s);
}
	
	
	function getchart()
	{
		
	  if(document.getElementById("date2").value=="")
	  {
		  
		alert("Please Enter From Date");
		
		document.getElementById("date2").focus();
		
		return false;
		
		  
	  }
	  
	  if(document.getElementById("date3").value=="")
	  {
		  
		alert("Please Enter To Date");
		
		document.getElementById("date3").focus();
		
		return false;
		
		  
	  }
		
		 if(document.getElementById("costcenter").value=="")
	  {
		  
		alert("Please Enter Cost Center");
		
		document.getElementById("costcenter").focus();
		
		return false;
		
		  
	  }
		
		
		
		var fromdate=document.getElementById("date2").value;
		
		var todate=document.getElementById("date3").value;
		
		var allwarehouses=[];
		
		var k=0;
		
		for(i=0;i<document.getElementById("costcenter").options.length;i++)
		{
			
		   if(document.getElementById("costcenter").options[i].selected)
		   {
			   
			   allwarehouses[k++]=document.getElementById("costcenter").options[i].value;
			   
			   
			   
		   }
		  
			
			
			
		}
		
		var allwarehousesa=allwarehouses.join("/");
		
		
		
		
		
		document.getElementById("assets").src="../ac_assets.php?warehouse="+allwarehousesa+"&fromdate="+fromdate+"&todate="+todate;
		
		
			document.getElementById("capital").src="../capital and liability.php?warehouse="+allwarehousesa+"&fromdate="+fromdate+"&todate="+todate;
		
	
	}
	

  </script>
</footer>
</body>
</html>
