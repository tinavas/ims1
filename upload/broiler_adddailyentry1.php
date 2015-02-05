
<script type="text/javascript">
var index = 0;
function makeForm() {
index = index + 1;
///////////para element//////////

table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "farm[]";
myselect1.id = "farm@" + index;
myselect1.style.width = "120px";
myselect1.onchange = function ()  {  func(index,this.value); };

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
           include "config.php"; 
           $query = "SELECT * FROM broiler_farmers where rsupervisor = '$_GET[user]' ORDER BY name ASC ";
           $result = mysql_query($query,$conn);
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['name']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['name']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>

td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);


td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="7";

mybox1.type="text";

mybox1.name="flock[]";

mybox1.id = "flock@" + index;

mybox1.setAttribute("readonly",true);

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);


td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.name="age[]";

mybox1.setAttribute("readonly",true);


mybox1.id = "age@" + index;

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);


td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="date1[]";

mybox1.value = "";

mybox1.id = "date1@" + index;

mybox1.setAttribute("class","datepicker");

mybox1.setAttribute("readonly",true);

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.value = "0";

mybox1.name="mort[]";

mybox1.id = "mort@" + index;

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="2";

mybox1.type="text";

mybox1.name="cull[]";

mybox1,id = "cull@" + index;

mybox1.value = "0";

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");

theOption1=document.createElement("OPTION");

myselect1.name = "feedtype[]";

myselect1.id = "feedtype@" + index;

myselect1.style.width = "100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
           include "config.php"; 
           $query = "SELECT distinct(code),description FROM ims_itemcodes where cat = 'Broiler Feed' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
 
td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox2=document.createElement("input");

mybox2.size="4";

mybox2.type="text";

mybox2.value = "0";

mybox2.name="consumed[]";

mybox2.id = "consumed@" + index;
td.appendChild(mybox2);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox3=document.createElement("input");

mybox3.size="4";

mybox3.type="text";

mybox3.value = "0";

mybox3.name="weight[]";

mybox3.id = "weight@" + index;

td.appendChild(mybox3);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox4=document.createElement("input");

mybox4.size="4";

mybox4.type="text";

mybox4.name="water[]";

mybox4.id = "water@" + index;

mybox4.value="0";

td.appendChild(mybox4);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");

theOption1=document.createElement("OPTION");

myselect1.name = "medicine[]";

myselect1.id = "medicine@" + index;

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
           include "config.php"; 
           $query = "SELECT distinct(code),description FROM ims_itemcodes where cat = 'Medicines' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
 
td.appendChild(myselect1);
tr.appendChild(td);


td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="3";

mybox1.type="text";

mybox1.name="mquantity[]";

mybox1.id = "mquantity@" + index;

mybox1.value="0";

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
myselect1 = document.createElement("select");

theOption1=document.createElement("OPTION");

myselect1.name = "vaccine[]";

myselect1.id = "vaccine@" + index;

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);

<?php
           include "config.php"; 
           $query = "SELECT distinct(code),description FROM ims_itemcodes where cat = 'Vaccines' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
 
td.appendChild(myselect1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.size="3";

mybox1.type="text";

mybox1.name="vquantity[]";

mybox1.id = "vquantity@" + index;

mybox1.value="0";

mybox1.onfocus = function () { makeForm(); }

td.appendChild(mybox1);
tr.appendChild(td);

td = document.createElement('td');
tr.appendChild(td);

td = document.createElement('td');
mybox1=document.createElement("input");

mybox1.type="hidden";

mybox1.name="birds[]";

mybox1.id = "birds@" + index;

mybox1.value="0";

td.appendChild(mybox1);
tr.appendChild(td);

table.appendChild(tr);
loadfarms(index);
}

</script>
