<?php include "jquery.php"; include "getemployee.php"; session_start(); ?>

<?php

$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");

$id = $_GET['id'];

$mnt  = $_GET['mon'];

$month = $montharr[$mnt-1];

$year = $_GET['year'];

		$q = "select * from hr_working_days where id = '$id'";

		$qrs = mysql_query($q,$conn) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		  $date1 = $qr['date'];

		  $date = date("d.m.o",strtotime($date1));

		   $noofdays = $qr['noofdays'];

		   $sector = $qr['sector'];

		  }

		  

?>



<section class="grid_8">

  <div class="block-border">

     <form class="block-content form" style="height:600px" onsubmit="return validate()" id="complex_form" method="post" action="hr_updateworking_days.php" >

	  <h1 id="title1">Working Days</h1>

		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>

              <center>

			  

			 

<br/>

<br/>



<table id="paraID" >

<tr>

<td width="10">&nbsp;</td>

<th style="width:100px"><strong>Month</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th style="width:100px"><strong>Year</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th style="width:50px"><strong>Days</strong>&nbsp;&nbsp;&nbsp;</th>

</tr>







</table>

<table id="inputs">

<tr>



<td>

<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>

<input type="hidden" name="monthno" id="monthno" value="<?php echo $mnt;?>"/>

<input style="color:#FF0000" type="text" name="month" id="month" value="<?php echo $month;?>" size="15"  readonly /></td>



<td width="10px"></td>

<td>

<input style="color:#FF0000" type="text" name="year" id="year" value="<?php echo $year;?>" size="15"  readonly /></td>

<td width="10px"></td>

<td >

<input type="text" name="nodays" id="nodays" value="<?php echo $noofdays;?>" size="5" onkeypress="return num(event.keyCode)" onkeyup="checkdays(this.id,this.value)" />&nbsp;</td>

</tr>

</table>

<br/>

<br/>

<input type="submit" value="Update" id="Save"/>&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_working_days';">

</center>

</form>

 </div>

</section>



		



<br />







<div class="clear"></div>

<br />



<script type="text/javascript">


function num(b)
{

	if(b<48 || b>57)
	
	return false;

}

function validate()
{

		var c= document.getElementById("nodays").value;
		if(c=="" ||c==0)
		
		{
		
			return false;
		
		}
		
	
}


function checkdays(a,d)
{

	
	
	var b= document.getElementById("month").value;
	if(b=="Select")
	{
		alert("Select month");
		document.getElementById("nodays").value="";
		return false;
	
	
	}
	var c= document.getElementById("year").value;
	if(c=="Select")
	{
		alert("Select year");
		document.getElementById("nodays").value="";
		return false;
	
	
	}
	
	<?php if($mnt==1|| $mnt==3 ||$mnt==5 ||$mnt==7 ||$mnt==8 ||$mnt==10 ||$mnt==12)
		{?>
			
			if(Number(d)>31)
			{
				document.getElementById("nodays").value="";
				return false;
				
			
			}
			else
			return true;
		
		
		
	<?php	}
	
	
	if($mnt==4||$mnt==6|| $mnt==9 || $mnt==11 )
	
		{
		?>
			if(Number(d)>30)
			{
				document.getElementById("nodays").value="";
				return false;
				
			
			}
		
		else
			return true;
		
	<?php	
		}
		
		if($mnt==2 &&(($year%4==0 && $year%100!=0) ||($year%400)==0))
		{?>
			if(Number(d)>29)
			{
			
			document.getElementById("nodays").value="";
				return false;
			
			
			}
		else
			return true;
		
		
		<?php }
		if($mnt==2) 
		{
		?>if(Number(d)>28)
			{
			
			document.getElementById("nodays").value="";
				return false;
		
		}
	<?php	} ?>
	


}




function script1() {

window.open('HRHELP/hr_m_workingdays.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

}

</script>

	<footer>

		<div class="float-left">

			<a href="#" class="button" onClick="script1()">Help</a>

			<a href="javascript:void(0)" class="button">About</a>

		</div>





		

		<div class="float-right">

			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>

		</div>

		

	</footer>



<!--[if lt IE 8]></div><![endif]-->

<!--[if lt IE 9]></div><![endif]-->

</body>

</html>

