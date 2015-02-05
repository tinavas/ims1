
<script type="text/javascript">
var index = -1;
function makeForm() {
index = index + 1;

///////////para element//////////

var mytable=document.getElementById("mytable");

var myrow = document.createElement("tr");

var mytd = document.createElement("td");

var mybox1=document.createElement("label");


theText1=document.createTextNode(index + 2);

mybox1.appendChild(theText1);



mybox1.id = "sno" + index;



mytd.appendChild(mybox1);

myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd1 = document.createElement("td");

myselect1 = document.createElement("select");

myselect1.id = "code" + index;

myselect1.name = "code[]";

 var op1=new Option("-Select-","");
myselect1.options.add(op1);

myselect1.onchange = function ()  {  description(this.id); };


<?php
           include "config.php"; 
           $query = "select code,description from ac_coa where controltype in('') ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>

 var op1=new Option("<?php echo $row1['code']; ?>","<?php echo $row1['code']; ?>");
 op1.title = "<?php echo $row1['description']; ?>";
myselect1.options.add(op1);


<?php } ?>
mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

mytable.appendChild(myrow);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);



var mytd = document.createElement("td");

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function ()  {  getcode(this.id); };

<?php 
                       $query = "select code,description from ac_coa where controltype in('') ";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>


 var op1=new Option("<?php echo $row1['description']; ?>","<?php echo $row1['description']; ?>");

myselect1.options.add(op1);


<?php } ?>

mytd.appendChild(myselect1);

myrow.appendChild(mytd);




myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd1 = document.createElement("td");

var myselect1 = document.createElement("select");

 var op1=new Option("-Select-","");
myselect1.options.add(op1);


theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Cr');

theOption1.appendChild(theText1);

theOption1.value = "Cr";

myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Dr');

theOption1.appendChild(theText1);

theOption1.value = "Dr";

myselect1.appendChild(theOption1);

myselect1.name = "drcr[]";

myselect1.id = "drcr" + index;

myselect1.onchange = function ()  {  enabledrcr(this.id); };

mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="dramount[]";

mybox1.style.textAlign = "right";

//mybox1.setAttribute("style.text-align","right");

mybox1.setAttribute('readonly',true);

mybox1.value = 0;

mybox1.size = "8";

mybox1.id = "dramount" + index;


mybox1.onkeyup = function ()  {  total(); };
mybox1.onblur = function ()  {  newrow(this.value); };

mytd.appendChild(mybox1);

myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="cramount[]";

mybox1.setAttribute('readonly',true);

mybox1.size = "8";

mybox1.value = 0;

mybox1.id = "cramount" + index;

mybox1.style.textAlign = "right";

mybox1.onchange = function ()  {  total(); };
mybox1.onblur = function ()  {  newrow(this.value); };
mytd.appendChild(mybox1);

myrow.appendChild(mytd);





mytable.appendChild(myrow);


myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("textarea");

mybox1.name="remarks[]";

mybox1.rows = "2";

mybox1.cols = "30";

mybox1.id = "remarks" + index;

mytd.appendChild(mybox1);

myrow.appendChild(mytd);

mytable.appendChild(myrow);


}
</script>
