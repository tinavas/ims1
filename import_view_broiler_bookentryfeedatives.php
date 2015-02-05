
 <?php include "config.php";
       include "jquery.php";


$farm = explode('@',$_GET['farmer']);
$place = $farm[1];
$farmer = $farm[0];

$query = "select max(entrydate) as date, max(age) as age from broiler_daily_entry where supervisior = '$_GET[supervisor]' and flock = '$_GET[flock]' and farm = '$farmer'";
$result = mysql_query($query,$conn) or die(mysql_error());
$res = mysql_fetch_assoc($result);
$displayflock = $_GET['flock'];
$displayage = $res['age']+1;
$displaydate =date("d.m.Y",strtotime($res['date'])+86400);
?>

<script type="text/javascript">
function getfarms(a) 
{
 removeAllOptions(document.getElementById("farmdup"));

		myselect1 = document.getElementById("farmdup");
            theOption1=document.createElement("OPTION");
            theText1=document.createTextNode("-Select Farm-");
            theOption1.appendChild(theText1);
            myselect1.appendChild(theOption1);
 <?php
    $q2=mysql_query("select distinct(supervisor) as supervisor from broiler_supervisor WHERE client = '$client' ORDER BY supervisor ASC ");
    while($nt2=mysql_fetch_array($q2)){
    echo "if(document.getElementById('supervisordup').value == '$nt2[supervisor]'){";
	if($_SESSION['client'] == 'FEEDATIVES')
	{
     $q3=mysql_query("select distinct(farm) as farm,place from broiler_farm where supervisor='$nt2[supervisor]' AND client = '$client' AND type <> 'rental' ORDER BY farm ASC ");
	 }
	else
	{
	$sectorlist = $_SESSION['sectorlist'];
	 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	  $q3=mysql_query("select distinct(farm) as farm,place from broiler_farm where supervisor='$nt2[supervisor]' AND client = '$client' ORDER BY farm ASC ");
	 else
	  $q3=mysql_query("select distinct(farm) as farm,place from broiler_farm where supervisor='$nt2[supervisor]' AND place IN ($sectorlist) AND client = '$client' ORDER BY farm ASC ");	  
	  }
    while($nt3=mysql_fetch_array($q3))
	 { ?>
           theOption1=document.createElement("OPTION");
 	     theText1=document.createTextNode("<?php echo $nt3['farm']; ?>");
	     theOption1.value = "<?php echo $nt3['farm'].'@'.$nt3['place']; ?>";
	     theOption1.appendChild(theText1);
	     myselect1.appendChild(theOption1);

    <?php   } // end of while loop
      echo "}"; // end of JS if condition
     }
  ?>
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function loaddata()
{
 document.getElementById("supervisor").value = document.getElementById('supervisordup').value;
 var temp = document.getElementById('farmdup').value.split('@');
 document.getElementById("farmer").value = temp[0];
 document.getElementById('place').value = temp[1];
}

function checkform()
{
 if(document.getElementById('farmer').value == "")
 {
  alert('Please select farm');
  return false;
 }
 return true;
}
</script>

<br /><br />

<center>
<h1>Broiler Book Entry</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>
</head>
<body bgcolor="#ECF1F5">
<br />
<form id="form1" name="form1" method="post" onsubmit = "return checkform(this)" action="broiler_savebookentryfeedatives.php" >
<br />
<center>
<strong>Supervisor:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" name="supervisor" id="supervisor" value="" size="12" readonly />
<select name="supervisordup" id="supervisordup" tabindex="1" onchange="getfarms(this.value);">
      <option value="">-Select-</option>
       <?php 
		   	$query = "SELECT distinct(supervisor) FROM broiler_supervisor WHERE releaved = '0' and client = '$client' ORDER BY supervisor ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['supervisor']; ?>"><?php echo $row1['supervisor']; ?></option>
<?php } ?>
</select>

&nbsp;&nbsp;&nbsp;
<strong>Farm:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" name="farmer" id="farmer" value="" size="18" readonly />&nbsp;&nbsp;&nbsp;
<select name="farmdup" id="farmdup" onchange = "loaddata()" >
       <option value="">-Select Farm-</option>
      </select>&nbsp;&nbsp;&nbsp;
<strong>Place:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" name="place" id="place" value="" size="15" readonly />&nbsp;&nbsp;&nbsp;
</center>
<br /><br />

<table id="paraID" aling="center">
<tr align="center">
<th width="10px"></th>
<th><strong>Flock</strong></th>
<th width="10px"></th>
<th><strong>Age</strong></th>
<th width="10px"></th>
<th><strong>Date</strong></th>
<th width="10px"></th>
<th title="mortality"><strong>Mort.<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong></th>
<th width="10px"></th>
<th><strong>Cull<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong></th>
<th width="10px"></th>
<th><strong>Feed Type</strong></th>
<th width="10px"></th>
<th title="feed consumed"><strong>Feed Cons.<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong></th>
<th width="10px"></th>
<th title="average weight"><strong>Avg. Wt.</strong></th>
<th width="10px"></th>
<th><strong>Water</strong></th>
<th width="10px"></th>
<th><strong>Medicine</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>
<th width="10px"></th>
<th><strong>Vaccine</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>
<th width="10px"></th>
<th><strong>Remarks</strong></th>
<th width="10px"></th>
</tr>

<tr align="center">
<th colspan="13"></th>
		<?php session_start();
		if($_SESSION['client'] == 'KWALITY')
		{
		?><th style="font-size:10px">(In Bag's)<th><?php
		}
		else
		{
		?><th style="font-size:10px">(In Kg's)<th><?php
		}
		?>


<th style="font-size:10px">(In Gram's)<th>
<th style="font-size:10px">(In Lt's)<th>
<th width="10px"></th>
<!--<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>-->
</tr>


<?php
$i = 0;
 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "config.php";
$query = "";
if( $_FILES['excel_file'] &&
   ($_FILES['excel_file']['tmp_name'] != '') ) {

 $fsz = filesize($_FILES['excel_file']['tmp_name']);
 $fh = @fopen ($_FILES['excel_file']['tmp_name'],'rb');
 if( !$fh || ($fsz==0) )
  die('No file uploaded');
 $file = fread( $fh, $fsz );
 @fclose($fh);
 if( strlen($file) < $fsz )
  die('Cannot read the file');
} else {
 die('No file uploaded');
}

$ee = new ExcelExplorer;

switch ($ee->Explore($file)) {
 case 0:
  break;
 case 1:
  die('File corrupted or not in Excel 5.0 and above format');
 case 2:
  die('Unknown or unsupported Excel file version');
 default:
  die('ExcelExplorer give up');
}

for( $sheet=0; $sheet<$ee->GetWorksheetsNum(); $sheet++ ) {
  //print 'Sheet: '.$ee->AsHTML($ee->GetWorksheetTitle($sheet))."<br>\n";
$bank = $ee->AsHTML($ee->GetWorksheetTitle($sheet));
$bank = substr_replace($bank,"",-4); 


if( !$ee->IsEmptyWorksheet($sheet) ) {

 for($row=0; $row<=$ee->GetLastRowIndex($sheet); $row++) {
 
  if( !$ee->IsEmptyRow($sheet,$row) ) {

   for($col=0; $col<=$ee->GetLastColumnIndex($sheet); $col++) {

    if( !$ee->IsEmptyColumn($sheet,$col) ) {

     $data = $ee->GetCellData($sheet,$col,$row);
     $type = '';

     switch( $ee->GetCellType($sheet,$col,$row) ) {
      case 0:
       $type = 'Empty';
       break;
      case 7:
       $type = 'Blank';
       break;
      case 8:
       $type = 'Merged';
       break;
      case 1:
       $type = 'Number';
       break;
      case 3:
       $type = 'Text';
       $data = $ee->AsHTML($data);
       break;
      case 2:
       $type = 'Percentage';
       $data = (100*$data).'%';
       break;
      case 4:
       $type = 'Boolean';
       $data = ($data ? 'TRUE' : 'FALSE');
       break;
      case 5:
       $type = 'Error';
       switch( $data ) {
        case 0x00:
         $data = "#NULL!";
         break;
        case 0x07:
         $data = "#DIV/0";
         break;
        case 0x0F:
         $data = "#VALUE!";
         break;
        case 0x17:
         $data = "#REF!";
         break;
        case 0x1D:
         $data = "#NAME?";
         break;
        case 0x24:
         $data = "#NUM!";
         break;
        case 0x2A:
         $data = "#N/A!";
         break;
        default:
         $data = "#UNKNOWN";
         break;
       }
       break;
      case 6:
       $data = $data['string'];
       $type = 'Date';
       break;
      default:
       break;
     }
	 
if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }
        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        //if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        //if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
     
       
           
          $totalcol = "11";
        
                if ($col == $totalcol && $data0 <> '')
                {
?>









<tr height="10px"><td></td></tr>

<tr  align="center">
<td width="10px"></td>
<td><input type="text" name="flock[]" id="flock" size="16" value="<?php echo $data0;?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" name="age[]" id="age" size="1" value="<?php echo $data1;?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" name="date1[]" id="date1" size="10" value="<?php echo date('d.m.Y',strtotime($data2)); ?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" name="mort[]" id="mort" size="1" value="<?php echo $data3; ?>" /></td>
<td width="10px"></td>
<td><input type="text" name="cull[]" id="cull" size="1" value="<?php echo $data4; ?>"/></td>
<td width="10px"></td>
<td><input type="text" name="feedtype[]" id="feedtype" size="5" value="<?php echo $data5; ?>"/></td>
<td width="10px"></td>
<td><input type="text" name="consumed[]" id="consumed" size="4" value="<?php echo $data6; ?>"/></td>
<td width="10px"></td>
<td><input type="text" name="weight[]" id="weight" size="4" value="<?php echo $data7; ?>"/></td>
<td width="10px"></td>
<td><input type="text" name="water[]" id="water" value="0"  size="4" /></td>
<td width="10px"></td>
<td><input type="text" name="medicine[]" id="medicine" size="5" value="<?php echo $data8; ?>"/></td>
<td width="10px"></td>
<td><input type="text" name="mquantity[]" id="mquantity" value="<?php echo $data9; ?>"  size="3" /></td>
<td width="10px"></td>
<td><input type="text" name="vaccine[]" id="vaccine" size="5" value="<?php echo $data10; ?>"/>
</td> 
<td width="10px"></td> 
<td><input type="text" name="vquantity[]" id="vquantity"size="3" value="<?php echo $data11; ?>" /></td>
<td width="10px"></td> 
<td><input type="text" name="remarks[]" id="remarks"size="10" onfocus = "makeForm();" /></td>
<td width="10px"></td> 
<input type="hidden" name="birds[]"  id="birds" value="0"/>
</tr>
<?php


				}	// End of if($col == $tocol
}    
          
        }
    }

   }

  }
 }
 else {
 print "Empty sheet<br>\n";
} 
print "<hr>\n";
}

?>
</table>


<center>
<br /><br /><br />

<h4 style="color:red">Other Items Consumed</h4><br />

<table border="0px" id="inputs1">


     <tr>
         <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Flock</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Item</strong></th>
        <th width="20px"></th>
 <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Description</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;<strong>Quantity</strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
        <input type="text" name="flocko[]" id="flocko" size="16" value="<?php echo $displayflock;?>" readonly />
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="dateo[]" id="dateo" class="datepicker" value="" size="10" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <select name="itemo[]" id="item@-1" style="width:80px;" onChange="getdesc(this.id);" >
           <option value="">-Select-</option>
           <?php
              
              $query = "SELECT code,description FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client' and broileractive='YES'  ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['code']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
           <?php } ?>
         </select>
       </td>
<td width="10px"></td>
       <td style="text-align:left;">
         <select name="desc[]" id="desc@-1" style="width:200px;" onChange="getcode(this.id);">
           <option value="">-Select-</option>
           <?php
               
              $query = "SELECT code,description FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client' and broileractive='YES'  ORDER BY description ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>

           <option value="<?php echo $row1['description']; ?>" title="<?php echo $row1['code']; ?>"><?php echo $row1['description']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="qtyo[]" id="qtyo" value="" size="8" onFocus="makeform1();" /> 
       </td>
    </tr>

 
</table>
<br /><br />

<input type="submit" value="Save" id="Save" <?php if($warning != "") { ?> disabled="disabled" <?php } ?>/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=broiler_dailyentry';">


</center>
</form>
<br />
<script type="text/javascript">
function getcode(codeid)
{
temp = codeid.split("@");
var index12 = temp[1];
var code1 = document.getElementById("desc@" + index12).value;
<?php
$q = "select distinct(description) from ims_itemcodes where broileractive='YES'";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[description]') {";
$q1 = "select distinct(code),sunits from ims_itemcodes where description = '$qr[description]' and broileractive='YES' order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById("item@" + index12).value = "<?php echo $q1r['code'];?>";
<?php
}
echo "}";
}
?>

}
function getdesc(codeid)
{
temp = codeid.split("@");
var index11 = temp[1];

var code1=document.getElementById("item@" + index11).value;
<?php 
$q = "select distinct(code) from ims_itemcodes where broileractive='YES'";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[code]') {";
$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' and broileractive='YES' order by description";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById('desc@' + index11).value = "<?php echo $q1r['description'];?>";
<?php
}
echo "}";
}
?>
}</script>
<script type="text/javascript">
function script1() {
window.open('BroilerHelp/help_t_addbookentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</body> 
<?php 
include "broiler_bookentry1feedatives.php"; 
?>
<script type="text/javascript">
var index1a =0;
function makeform1()
{
  index1a = index1a + 1;
  var t1a  = document.getElementById('inputs1');
  var r1a = document.createElement('tr'); 

 
  mybox1=document.createElement("input");
  mybox1.size="16";
  mybox1.type="text";
  mybox1.name="flocko[]";
  mybox1.value="<?php echo $displayflock;?>";
  mybox1.id="date1" +  index1a;
  var ba1a = document.createElement('td');
  ba1a.appendChild(mybox1);

  var b1a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1a.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="10";
  mybox1.type="text";
  mybox1.name="dateo[]";
  mybox1.id="dateo" +  index1a;
  var c = "datepicker" + index;
  mybox1.setAttribute("class",c);
  var ba2a = document.createElement('td');
  ba2a.appendChild(mybox1);

  var b2a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2a.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="ageo[]";
  mybox1.id="ageo" +  index1a;
  var ba3a = document.createElement('td');
  ba3a.appendChild(mybox1);

  var b3a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3a.appendChild(myspace2);


  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "itemo[]";
  myselect1.id = "item@" + index1a;
myselect1.onchange= function() { getdesc(this.id); };
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client' and broileractive='YES' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba11a = document.createElement('td');
  ba11a.appendChild(myselect1);
  var b11a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b11a.appendChild(myspace2);


myselect1 = document.createElement("select");
  myselect1.style.width = "200px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "desc[]";
  myselect1.id = "desc@" + index1a;
myselect1.onchange= function() { getcode(this.id); };

  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and broileractive='YES' and client = '$client'  ORDER BY description ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['description']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['code']; ?>";
		theOption.value = "<?php echo $row1['description']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba13a = document.createElement('td');
  ba13a.appendChild(myselect1);
  var b13a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b13a.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="qtyo[]";
  mybox1.onfocus= function() { makeform1(); };
  var ba12a = document.createElement('td');
  ba12a.appendChild(mybox1);

  var b12a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b12a.appendChild(myspace2);

  
      r1a.appendChild(ba1a);
      r1a.appendChild(b1a);
      r1a.appendChild(ba2a);
      r1a.appendChild(b2a);
      r1a.appendChild(ba11a);
      r1a.appendChild(b11a);

r1a.appendChild(ba13a);
      r1a.appendChild(b13a);
      r1a.appendChild(ba12a);
      r1a.appendChild(b12a);
      t1a.appendChild(r1a);


$(function() {
	$( "." + c ).datepicker();
  });

}

</script>




</html>


