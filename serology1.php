
<script type="text/javascript">
var z = 1;
function makeForm() {
z = z + 1;
//alert(z);
///////////para element//////////

var t  = document.getElementById('paraID');
var r  = document.createElement('tr');

myspace2= document.createTextNode('\u00a0');
var cca = document.createElement('td');
cca.appendChild(myspace2);



//////////mortality/////////////

mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="farm[]";

var ca1 = document.createElement('td');
ca1.appendChild(mybox1);

myspace2= document.createTextNode('\u00a0');
var cca1 = document.createElement('td');
cca1.appendChild(myspace2);

//////////mortality/////////////

mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="sample[]";

var ca2 = document.createElement('td');
ca2.appendChild(mybox1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);

//////////leggs/////////////

mybox2=document.createElement("input");

mybox2.size="3";

mybox2.type="text";

mybox2.name="age[]";

var ca3 = document.createElement('td');
ca3.appendChild(mybox2);

myspace2= document.createTextNode('\u00a0');
var cca3 = document.createElement('td');
cca3.appendChild(myspace2);

//////////meggs/////////////

mybox3=document.createElement("input");

mybox3.size="8";

mybox3.type="text";

mybox3.name="vaccinated[]";

mybox3.onfocus = function ()  {  makeForm(); };

var ca4 = document.createElement('td');
ca4.appendChild(mybox3);

myspace2= document.createTextNode('\u00a0');
var cca4 = document.createElement('td');
cca4.appendChild(myspace2);


<?php $l = 5; for ($k = 0;$k <= 12;$k++) { ?>

//////////leggs/////////////

mybox2=document.createElement("input");

mybox2.size="3";

mybox2.type="text";

mybox2.name="<?php echo $k; ?>[]";

var ca<?php echo $l; ?> = document.createElement('td');
ca<?php echo $l; ?>.appendChild(mybox2);

myspace2= document.createTextNode('\u00a0');
var cca<?php echo $l; ?> = document.createElement('td');
cca<?php echo $l; ?>.appendChild(myspace2);

<?php $l = $l + 1; } ?>

      r.appendChild(cca1);
      r.appendChild(ca1);
      r.appendChild(cca2);
      r.appendChild(ca2);
      r.appendChild(cca3);
      r.appendChild(ca3);
      r.appendChild(cca4);
      r.appendChild(ca4);
     <?php $l = 5; for ($k = 0;$k <= 12;$k++) { ?>
      r.appendChild(cca<?php echo $l; ?>);
      r.appendChild(ca<?php echo $l; ?>);
     <?php $l = $l + 1; } ?>
      t.tBodies(0).appendChild(r);

}

</script>

