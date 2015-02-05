<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1256"> 
<META HTTP-EQUIV="Content-language" CONTENT="ar"> 

<title>B.I.M.S</title>
<!-- calender -->
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="reports.js"></script>
<style type="text/css">
body
{
font-family:Arial,Helvetica,sans-serif;
font-size:12px;
font-weight:bold;
}
td
{
font-size:12px;
font-weight:bold;
}
</style>
</head>
<body bgcolor="#ECF1F5">
<?php
           include "config.php";
		   $sector = $_GET['sector'];
		   $name = $_GET['empname'];
		   $month = $_GET['month'];
		   $year = $_GET['year'];
		   
?>

<fieldset style="height:440px;padding-left:10px">
<center>
<h4 style="color:red;font-weight:bold;padding-top:10px"><u>Employee Report</u></h2>
<br />
<table border="1">
 <tr>
   <td width="425px" valign="top">
      <table>
        <tr height="5px"><td></td></tr>
		<?php 
			include "config.php";
			$q = "select * from hr_employee where sector = '$sector' and name = '$name'";
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
			?>
        <tr><td width="150px" ><font color="#19708C">Employee ID</font></td><td width="100px"><?php echo $qr['employeeid']; ?></td><td width="100px"><?php echo $openingmale; ?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Employee Name</font></td><td width="100px"><?php echo $qr['name'];?></td><td width="100px"><?php echo $mortalitymale; ?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Sector</font></td><td width="100px"><?php echo $qr['sector'];?></td><td width="100px"><?php echo $cullsmale; ?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Designation</font></td><td width="100px"><?php echo $qr['designation']; ?></td><td width="100px"><?php echo $mortalitymale; ?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Qualification</font></td><td width="100px"><?php echo $qr['qualification']; ?></td><td width="100px"><?php echo $mortalitymale; ?></td></tr>
        <tr height="5px"><td></td></tr>

        <tr><td width="150px"><font color="#19708C">D.O.B</font></td><td width="100px"><?php 
		
		
		$d = explode("-",$qr['dob']);
		echo ($d[2] . "." . $d[1] . "." . $d[0]);
		
		?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Gender</font></td><td width="100px"><?php echo $qr['sex']; ?></td><td width="100px"><?php echo $cullsmale; ?>				</td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Salary</font></td><td width="100px"><?php echo $qr['salary']; ?></td><td width="100px"><?php echo $transfermale; ?></td></tr>
        <tr height="5px"><td></td></tr>
		<tr><td width="150px"><font color="#19708C">Blood Group</font></td><td width="100px"><?php echo $qr['bloodgroup']; ?></td><td width="100px"><?php echo $transfermale; ?></td></tr>
        <tr height="5px"><td></td></tr>
		<tr><td width="150px"><font color="#19708C">Address</font></td><td width="100px"><?php echo $qr['address']; ?></td><td width="100px"><?php echo $transfermale; ?></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Driving License</font></td><td width="100px">
		<?php echo $qr['drivinglicense'];  ?>				
    	</td></tr>
       <tr height="5px"><td></td></tr>
  
        <tr><td width="150px"><font color="#19708C">Exp. of Driving License</font></td><td width="100px">
		<?php 
		$expd = explode("-",$qr['expdlicense']);
		echo $expd[2] . ".". $expd[1] . "." . $expd[0];
		?>				
    	</td></tr>
       <tr height="5px"><td></td></tr>

		<?php } ?>


      </table>
   </td>
   <td width="425px">
      <table>
	  		        <tr><td width="150px"><font color="#19708C">PAN Card No.</font></td><td width="100px">
							<?php echo $qr['pancard'];  ?>				
      				</td></tr>
                    <tr height="5px"><td></td></tr>
	  		    
				    <tr><td width="150px"><font color="#19708C">Vehicle No.</font></td><td width="100px">
							<?php echo $qr['vehicleno'];  ?>				
      				</td></tr>
                    <tr height="5px"><td></td></tr>

	  		        <tr><td width="150px"><font color="#19708C">Vehicle Insurance.</font></td><td width="100px">
							<?php echo $qr['vinsurance'];  ?>				
      				</td></tr>
                    <tr height="5px"><td></td></tr>

	  		        <tr><td width="150px"><font color="#19708C">Exp. of Vehicle Insurance.</font></td><td width="100px">
							<?php 
										$expv = explode("-",$qr['expvinsurance']);
										echo $expv[2] . ".". $expv[1] . "." . $expv[0];

							?>				
      				</td></tr>
                    <tr height="5px"><td></td></tr>

			  	<tr><td width="150px"><font color="#19708C">Attendance</font></td><td width="100px">
				<?php 
				include "config.php";
				$att = 0;
				$qatt = "select * from hr_attendance where place = '$sector' and name = '$name' and month1 = '$month' and year1 = '$year'";
				$qattrs = mysql_query($qatt,$conn1) or die(mysql_error());
				while($qattr = mysql_fetch_assoc($qattrs))
				{
					if($qattr['daytype'] == "Full")
					$att++;
					else
					$att+=0.5;
				}
				echo $att;
				
				?>
				</td></tr>
        <tr height="5px"><td></td></tr>
		        <tr><td width="150px"><font color="#19708C">No. of Leaves</font></td><td width="100px">
				<?php 
				include "config.php";
				$leav = 0;
				$qleav = "select fromdate,sum(diff) as leav from hr_leaves where empid = '$qr[employeeid]'";
				$qleavrs = mysql_query($qleav,$conn1) or die(mysql_error());
				while($qleavr = mysql_fetch_assoc($qleavrs))
				{
					$fromdate = $qleavr['fromdate'];
					$fd = explode("-",$fromdate);
					if(($fd[1] == $month) && $fd[0] == $year )
					$leav+= $qleavr['leav'];
				}
				echo $leav;
			   ?>
			   </td></tr>
        <tr height="5px"><td></td></tr>

		        <tr><td width="150px"><font color="#19708C">Advance</font></td><td width="100px">0
				<?php 
				/*include "config.php";
			$q2 = "select sum(amount) as adv from expenses where eid = '$qr[employeeid]' and month1 = '$month' and year1 = '$year' and exp = 'Advance' ";
			$q2rs = mysql_query($q2,$conn1) or die(mysql_error());
			if($q2r = mysql_fetch_assoc($q2rs))
			{
				if($q2r['adv'] == 0)
				$adv = 0;
				else
				$adv = $q2r['adv'];
				echo $adv;
			}*/
				?>
				</td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Expenses</font></td><td width="100px">0
		<?php 
			/*include "config.php";
			$qexp = "select sum(amount) as exp1 from expenses where eid = '$qr[employeeid]' and month1 = '$month' and year1 = '$year' and exp <> 'Advance' ";
			$qexprs = mysql_query($qexp,$conn1) or die(mysql_error());
			if($qexpr = mysql_fetch_assoc($qexprs))
			{
				if($qexpr['exp1']	 == 0)
				$exp1 = 0;
				else
				$exp1 = $qexpr['exp1'];
				echo $exp1;
			}*/
		?>
		</td>
		<td width="100px"></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">P.T</font></td><td width="100px">
		<?php 
			include "config.php";
			$qpt = "select  ptaxfix from hr_salaryparameters where eid = '$qr[employeeid]' ";
			$qptrs = mysql_query($qpt,$conn1) or die(mysql_error());
			if($qptr = mysql_fetch_assoc($qptrs))
			{
				echo $qptr['ptaxfix'];
			}
			
		?>
		</td><td width="100px"></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">P.F</font></td><td width="100px">
				<?php 
			include "config.php";
			$qpt = "select  pffix from hr_salaryparameters where eid = '$qr[employeeid]' ";
			$qptrs = mysql_query($qpt,$conn1) or die(mysql_error());
			if($qptr = mysql_fetch_assoc($qptrs))
			{
				echo $qptr['pffix'];
			}
			
		?>

		</td><td width="100px"></td></tr>
        <tr height="5px"><td></td></tr>
        <tr><td width="150px"><font color="#19708C">Mess</font></td><td width="100px">0
				<?php 
			/*include "config.php";
			$qexp = "select sum(amount) as exp1 from expenses where eid = '$qr[employeeid]' and month1 = '$month' and year1 = '$year' and exp <> 'Advance' ";
			$qexprs = mysql_query($qexp,$conn1) or die(mysql_error());
			if($qexpr = mysql_fetch_assoc($qexprs))
			{
				if($qexpr['exp1']	 == 0)
				$exp1 = 0;
				else
				$exp1 = $qexpr['exp1'];
				echo $exp1;
			}*/
		?>

		</td><td width="100px"></td></tr>
        <tr height="5px"><td></td></tr>
		<?php 
				if(($sector == "Integration") || ($sector == "Hatchery") || ($sector == "Breeding Farm") )
		{
		?>
        <tr><td width="150px"><font color="#19708C">Culls</font></td><td width="100px">
		<?php 
		$culls = 0;
		if(($sector == "Integration") || ($sector == "Hatchery") || ($sector == "Breeding Farm") )
		{
			$q4 = "select * from broiler_birdsale where type = 'employee' and farm = '$name'";
			$q4rs = mysql_query($q4,$conn1) or die(mysql_error());
			while($q4r = mysql_fetch_assoc($q4rs))
			{
				if(( $q4r['date'] <= $td ) && ( $q4r['date'] >= $fd ))
				$culls+= $q4r['birds'];
			}
		
			$q5 = "select * from pp_cobi where party = '$name'";
			$q5rs = mysql_query($q5,$conn1) or die(mysql_error());
			while($q5r = mysql_fetch_assoc($q5rs))
			{
				if(( $q5r['date'] <= $td ) && ( $q5r['date'] >= $fd ))
				$culls+= ($q5r['fbirds'] + $q5r['mbirds']);
			}
			
		}
		echo $culls;
		?>
		<?php } ?>
		</td><td width="100px"></td></tr>

      </table>
   </td>
 </tr>
</table>
</center>
</fieldset>
</body>
</html>