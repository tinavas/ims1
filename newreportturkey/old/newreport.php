<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta name="Excel Workbook Frameset">
<meta http-equiv=Content-Type content="text/html; charset=us-ascii">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="newreport_filelist.xml">
<![if !supportTabStrip]>
<link id="shLink" href="newreport_sheet001.php">
<link id="shLink" href="newreport_sheet002.php">
<link id="shLink" href="newreport_sheet003.php">
<link id="shLink" href="newreport_sheet004.php">
<link id="shLink" href="newreport_sheet005.php">
<link id="shLink" href="newreport_sheet006.php">
<link id="shLink" href="newreport_sheet007.php">
<link id="shLink" href="newreport_sheet008.php">
<link id="shLink" href="newreport_sheet009.php">
<link id="shLink" href="newreport_sheet010.php">
<link id="shLink" href="newreport_sheet011.php">
<link id="shLink" href="newreport_sheet012.php">
<link id="shLink" href="newreport_sheet013.php">
<link id="shLink" href="newreport_sheet014.php">

<link id="shLink">

<script language="JavaScript">
<!--
 var c_lTabs=14;

 var c_rgszSh=new Array(c_lTabs);
 c_rgszSh[0] = "broodgrow";
 c_rgszSh[1] = "Laying&nbsp;-&nbsp;5";
 c_rgszSh[2] = "wkly";
 c_rgszSh[3] = "dr.format";
 c_rgszSh[4] = "wkl-print";
 c_rgszSh[5] = "vacc";
 c_rgszSh[6] = "body&nbsp;wts";
 c_rgszSh[7] = "Prod%&nbsp;Graph";
 c_rgszSh[8] = "h.egg&nbsp;%&nbsp;graph";
 c_rgszSh[9] = "Egg&nbsp;&nbsp;Bird&nbsp;Grph";
 c_rgszSh[10] = "gradewise&nbsp;b.w";
 c_rgszSh[11] = "BG&nbsp;Body&nbsp;Wt&nbsp;Graph";
 c_rgszSh[12] = "batch&nbsp;abstract";
 c_rgszSh[13] = "Laying&nbsp;Std";



 var c_rgszClr=new Array(8);
 c_rgszClr[0]="window";
 c_rgszClr[1]="buttonface";
 c_rgszClr[2]="windowframe";
 c_rgszClr[3]="windowtext";
 c_rgszClr[4]="threedlightshadow";
 c_rgszClr[5]="threedhighlight";
 c_rgszClr[6]="threeddarkshadow";
 c_rgszClr[7]="threedshadow";

 var g_iShCur;
 var g_rglTabX=new Array(c_lTabs);

function fnGetIEVer()
{
 var ua=window.navigator.userAgent
 var msie=ua.indexOf("MSIE")
 if (msie>0 && window.navigator.platform=="Win32")
  return parseInt(ua.substring(msie+5,ua.indexOf(".", msie)));
 else
  return 0;
}

function fnBuildFrameset()
{
 var szHTML="<frameset rows=\"*,18\" border=0 width=0 frameborder=no framespacing=0>"+
  "<frame src=\""+document.all.item("shLink")[1].href+"\" name=\"frSheet\" noresize>"+
  "<frameset cols=\"54,*\" border=0 width=0 frameborder=no framespacing=0>"+
  "<frame src=\"\" name=\"frScroll\" marginwidth=0 marginheight=0 scrolling=no>"+
  "<frame src=\"\" name=\"frTabs\" marginwidth=0 marginheight=0 scrolling=no>"+
  "</frameset></frameset><plaintext>";

 with (document) {
  open("text/html","replace");
  write(szHTML);
  close();
 }

 fnBuildTabStrip();
}

function fnBuildTabStrip()
{
 var szHTML=
  "<html><head><style>.clScroll {font:8pt Courier New;color:"+c_rgszClr[6]+";cursor:default;line-height:10pt;}"+
  ".clScroll2 {font:10pt Arial;color:"+c_rgszClr[6]+";cursor:default;line-height:11pt;}</style></head>"+
  "<body onclick=\"event.returnValue=false;\" ondragstart=\"event.returnValue=false;\" onselectstart=\"event.returnValue=false;\" bgcolor="+c_rgszClr[4]+" topmargin=0 leftmargin=0><table cellpadding=0 cellspacing=0 width=100%>"+
  "<tr><td colspan=6 height=1 bgcolor="+c_rgszClr[2]+"></td></tr>"+
  "<tr><td style=\"font:1pt\">&nbsp;<td>"+
  "<td valign=top id=tdScroll class=\"clScroll\" onclick=\"parent.fnFastScrollTabs(0);\" onmouseover=\"parent.fnMouseOverScroll(0);\" onmouseout=\"parent.fnMouseOutScroll(0);\"><a>&#171;</a></td>"+
  "<td valign=top id=tdScroll class=\"clScroll2\" onclick=\"parent.fnScrollTabs(0);\" ondblclick=\"parent.fnScrollTabs(0);\" onmouseover=\"parent.fnMouseOverScroll(1);\" onmouseout=\"parent.fnMouseOutScroll(1);\"><a>&lt</a></td>"+
  "<td valign=top id=tdScroll class=\"clScroll2\" onclick=\"parent.fnScrollTabs(1);\" ondblclick=\"parent.fnScrollTabs(1);\" onmouseover=\"parent.fnMouseOverScroll(2);\" onmouseout=\"parent.fnMouseOutScroll(2);\"><a>&gt</a></td>"+
  "<td valign=top id=tdScroll class=\"clScroll\" onclick=\"parent.fnFastScrollTabs(1);\" onmouseover=\"parent.fnMouseOverScroll(3);\" onmouseout=\"parent.fnMouseOutScroll(3);\"><a>&#187;</a></td>"+
  "<td style=\"font:1pt\">&nbsp;<td></tr></table></body></html>";

 with (frames['frScroll'].document) {
  open("text/html","replace");
  write(szHTML);
  close();
 }

 szHTML =
  "<html><head>"+
  "<style>A:link,A:visited,A:active {text-decoration:none;"+"color:"+c_rgszClr[3]+";}"+
  ".clTab {cursor:hand;background:"+c_rgszClr[1]+";font:9pt Arial;padding-left:3px;padding-right:3px;text-align:center;}"+
  ".clBorder {background:"+c_rgszClr[2]+";font:1pt;}"+
  "</style></head><body onload=\"parent.fnInit();\" onselectstart=\"event.returnValue=false;\" ondragstart=\"event.returnValue=false;\" bgcolor="+c_rgszClr[4]+
  " topmargin=0 leftmargin=0><table id=tbTabs cellpadding=0 cellspacing=0>";

 var iCellCount=(c_lTabs+1)*2;

 var i;
 for (i=0;i<iCellCount;i+=2)
  szHTML+="<col width=1><col>";

 var iRow;
 for (iRow=0;iRow<6;iRow++) {

  szHTML+="<tr>";

  if (iRow==5)
   szHTML+="<td colspan="+iCellCount+"></td>";
  else {
   if (iRow==0) {
    for(i=0;i<iCellCount;i++)
     szHTML+="<td height=1 class=\"clBorder\"></td>";
   } else if (iRow==1) {
    for(i=0;i<c_lTabs;i++) {
     szHTML+="<td height=1 nowrap class=\"clBorder\">&nbsp;</td>";
     szHTML+=
      "<td id=tdTab height=1 nowrap class=\"clTab\" onmouseover=\"parent.fnMouseOverTab("+i+");\" onmouseout=\"parent.fnMouseOutTab("+i+");\">"+
      "<a href=\""+document.all.item("shLink")[i].href+"\" target=\"frSheet\" id=aTab>&nbsp;"+c_rgszSh[i]+"&nbsp;</a></td>";
    }
    szHTML+="<td id=tdTab height=1 nowrap class=\"clBorder\"><a id=aTab>&nbsp;</a></td><td width=100%></td>";
   } else if (iRow==2) {
    for (i=0;i<c_lTabs;i++)
     szHTML+="<td height=1></td><td height=1 class=\"clBorder\"></td>";
    szHTML+="<td height=1></td><td height=1></td>";
   } else if (iRow==3) {
    for (i=0;i<iCellCount;i++)
     szHTML+="<td height=1></td>";
   } else if (iRow==4) {
    for (i=0;i<c_lTabs;i++)
     szHTML+="<td height=1 width=1></td><td height=1></td>";
    szHTML+="<td height=1 width=1></td><td></td>";
   }
  }
  szHTML+="</tr>";
 }

 szHTML+="</table></body></html>";
 with (frames['frTabs'].document) {
  open("text/html","replace");
  charset=document.charset;
  write(szHTML);
  close();
 }
}

function fnInit()
{
 g_rglTabX[0]=0;
 var i;
 for (i=1;i<=c_lTabs;i++)
  with (frames['frTabs'].document.all.tbTabs.rows[1].cells[fnTabToCol(i-1)])
   g_rglTabX[i]=offsetLeft+offsetWidth-6;
}

function fnTabToCol(iTab)
{
 return 2*iTab+1;
}

function fnNextTab(fDir)
{
 var iNextTab=-1;
 var i;

 with (frames['frTabs'].document.body) {
  if (fDir==0) {
   if (scrollLeft>0) {
    for (i=0;i<c_lTabs&&g_rglTabX[i]<scrollLeft;i++);
    if (i<c_lTabs)
     iNextTab=i-1;
   }
  } else {
   if (g_rglTabX[c_lTabs]+6>offsetWidth+scrollLeft) {
    for (i=0;i<c_lTabs&&g_rglTabX[i]<=scrollLeft;i++);
    if (i<c_lTabs)
     iNextTab=i;
   }
  }
 }
 return iNextTab;
}

function fnScrollTabs(fDir)
{
 var iNextTab=fnNextTab(fDir);

 if (iNextTab>=0) {
  frames['frTabs'].scroll(g_rglTabX[iNextTab],0);
  return true;
 } else
  return false;
}

function fnFastScrollTabs(fDir)
{
 if (c_lTabs>16)
  frames['frTabs'].scroll(g_rglTabX[fDir?c_lTabs-1:0],0);
 else
  if (fnScrollTabs(fDir)>0) window.setTimeout("fnFastScrollTabs("+fDir+");",5);
}

function fnSetTabProps(iTab,fActive)
{
 var iCol=fnTabToCol(iTab);
 var i;

 if (iTab>=0) {
  with (frames['frTabs'].document.all) {
   with (tbTabs) {
    for (i=0;i<=4;i++) {
     with (rows[i]) {
      if (i==0)
       cells[iCol].style.background=c_rgszClr[fActive?0:2];
      else if (i>0 && i<4) {
       if (fActive) {
        cells[iCol-1].style.background=c_rgszClr[2];
        cells[iCol].style.background=c_rgszClr[0];
        cells[iCol+1].style.background=c_rgszClr[2];
       } else {
        if (i==1) {
         cells[iCol-1].style.background=c_rgszClr[2];
         cells[iCol].style.background=c_rgszClr[1];
         cells[iCol+1].style.background=c_rgszClr[2];
        } else {
         cells[iCol-1].style.background=c_rgszClr[4];
         cells[iCol].style.background=c_rgszClr[(i==2)?2:4];
         cells[iCol+1].style.background=c_rgszClr[4];
        }
       }
      } else
       cells[iCol].style.background=c_rgszClr[fActive?2:4];
     }
    }
   }
   with (aTab[iTab].style) {
    cursor=(fActive?"default":"hand");
    color=c_rgszClr[3];
   }
  }
 }
}

function fnMouseOverScroll(iCtl)
{
 frames['frScroll'].document.all.tdScroll[iCtl].style.color=c_rgszClr[7];
}

function fnMouseOutScroll(iCtl)
{
 frames['frScroll'].document.all.tdScroll[iCtl].style.color=c_rgszClr[6];
}

function fnMouseOverTab(iTab)
{
 if (iTab!=g_iShCur) {
  var iCol=fnTabToCol(iTab);
  with (frames['frTabs'].document.all) {
   tdTab[iTab].style.background=c_rgszClr[5];
  }
 }
}

function fnMouseOutTab(iTab)
{
 if (iTab>=0) {
  var elFrom=frames['frTabs'].event.srcElement;
  var elTo=frames['frTabs'].event.toElement;

  if ((!elTo) ||
   (elFrom.tagName==elTo.tagName) ||
   (elTo.tagName=="A" && elTo.parentElement!=elFrom) ||
   (elFrom.tagName=="A" && elFrom.parentElement!=elTo)) {

   if (iTab!=g_iShCur) {
    with (frames['frTabs'].document.all) {
     tdTab[iTab].style.background=c_rgszClr[1];
    }
   }
  }
 }
}

function fnSetActiveSheet(iSh)
{
 if (iSh!=g_iShCur) {
  fnSetTabProps(g_iShCur,false);
  fnSetTabProps(iSh,true);
  g_iShCur=iSh;
 }
}

 window.g_iIEVer=fnGetIEVer();
 if (window.g_iIEVer>=4)
  fnBuildFrameset();
//-->
</script>
<![endif]><!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>broodgrow</x:Name>
    <x:WorksheetSource HRef="newreport_sheet001.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Laying - 5</x:Name>
    <x:WorksheetSource HRef="newreport_sheet002.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>wkly</x:Name>
    <x:WorksheetSource HRef="newreport_sheet003.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>dr.format</x:Name>
    <x:WorksheetSource HRef="newreport_sheet004.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>wkl-print</x:Name>
    <x:WorksheetSource HRef="newreport_sheet005.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>vacc</x:Name>
    <x:WorksheetSource HRef="newreport_sheet006.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>body wts</x:Name>
    <x:WorksheetSource HRef="newreport_sheet007.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Prod% Graph</x:Name>
    <x:WorksheetSource HRef="newreport_sheet008.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>h.egg % graph</x:Name>
    <x:WorksheetSource HRef="newreport_sheet009.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Egg  Bird Grph</x:Name>
    <x:WorksheetSource HRef="newreport_sheet010.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>gradewise b.w</x:Name>
    <x:WorksheetSource HRef="newreport_sheet011.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>BG Body Wt Graph</x:Name>
    <x:WorksheetSource HRef="newreport_sheet012.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>batch abstract</x:Name>
    <x:WorksheetSource HRef="newreport_sheet013.php"/>
   </x:ExcelWorksheet>
   <x:ExcelWorksheet>
    <x:Name>Laying Std</x:Name>
    <x:WorksheetSource HRef="newreport_sheet014.php"/>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:Stylesheet HRef="newreport_stylesheet.css"/>
  <x:WindowHeight>8160</x:WindowHeight>
  <x:WindowWidth>10620</x:WindowWidth>
  <x:WindowTopX>120</x:WindowTopX>
  <x:WindowTopY>120</x:WindowTopY>
  <x:TabRatio>924</x:TabRatio>
  <x:ActiveSheet>1</x:ActiveSheet>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<frameset rows="*,39" border=0 width=0 frameborder=no framespacing=0>
 <frame src="newreport_sheet002.php" name="frSheet">
 <frame src="newreport_tabstrip.php" name="frTabs" marginwidth=0 marginheight=0>
 <noframes>
  <body>
   <p>This page uses frames, but your browser doesn't support them.</p>
  </body>
 </noframes>
</frameset>
</html>
