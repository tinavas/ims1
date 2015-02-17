  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</head>

<body> 

 <br/>
     <table  align="center" BORDER="0">
      <tbody>
        <tr>
          <th SCOPE="col" VALIGN="middle" HEIGHT="58">
            <h1> Welcome to SMOC Trial </h1>
          </th>
       </tr>
      </tbody>
     </table>

<ul>


<?php
include "config.php";
$reff = 0;
$reff1 = 0; $flag = 0;
 $user= $_SESSION['valid_user'];

$q = "select * from common_useraccess where username = '$user'  ";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
   $rights = $qr['view'];  
}
if ( strlen(strstr($rights ,$reff ))>0 && $flag == 1 && strlen(strstr($rights ,$brid ))>0) 
  { 
  
   
  ?>
 <?php if($_SESSION['country'] == 'India')
 {
 ?>
 <li><b>Reports</b></li>
 <?php } ?>
  
  
  <?php
  }
?>

</ul>
 

<html>
<body>
   <p> &nbsp;&nbsp;&nbsp;Stock Manager On Cloud is exclusively designed for business who has many inventory items with lot of inflows & outflows and integrates among all modules with accurate costing formulae.  </p>
   <p> &nbsp;&nbsp;&nbsp;Application will help you in maintaining stocks levels of multiple items, general consumption, sales and procedures in multiple warehouses along with cash books, financial standings.</p>
   
   <br />
<p>&nbsp;&nbsp;&nbsp;SMOC keeps track of : </p>


 <ul class="unorderlist">
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inventory Levels Of Items In Multiple Warehouses. </li>
	 
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Financial Tendency Of Company.</li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P&L ,Trial Balance And Balance Sheet. </li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ageing Analysis Of Customer & Supplier.</li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Minimum Stock Requirement.</li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cash Flow Analysis. </li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inflow And Outflow Of Inventories. </li> 
     

   </ul>

</body>
</html>
