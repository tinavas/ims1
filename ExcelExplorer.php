<?php
//
// +----------------------------------+
// | Excel Explorer Version 2.3       |
// | Professional Edition             |
// +----------------------------------+
//

/*
 * This class provides functions for retrieve data stored in the
 * Microsoft's Excel file.
 *
 */

class ExcelExplorer {

	var $known_date_formats = array(
		// custom date formats
		0x0 => 'd/m',
		0x1 => 'd/m/yy',
		0x2 => 'dd/mm/yy',
		0x3 => 'd\ mmm',
		0x4 => 'd\ mmm\ yy',
		0x5 => 'dd\ mmm\ yy',
		0x6 => 'mmm\ yy',
		0x7 => 'mmmm\ yy',
		0x8 => 'd\ mmmm\,\ yyyy',
		0x9 => 'dd/mm/yy\ h:mm\ AM/PM',
		0xa => 'dd/mm/yy\ h:mm',
		0xb => 'mmmm',
		0xc => 'mmmmm\-yy',
		0xd => 'mmmm\ d',
		0xe => 'd\ mmmm',
		0xf => 'd/mm/yyyy',
		0x10 => 'dd/mm/yyyy',
		0x11 => 'd/m/yyyy',
		0x12 => 'dd\-mmm\-yy',

		// build-in date formats written as custom
		0x010e => 'm/d/yyyy',
		0x010f => 'd\-mmm\-yy',
		0x0110 => 'd\-mmm',
		0x0111 => 'mmm\-yy',
		0x0112 => 'h:mm\ AM/PM',
		0x0113 => 'h:mm:ss\ AM/PM',
		0x0114 => 'h:mm',
		0x0115 => 'h:mm:ss',
		0x0116 => 'm/d/yyyy\ h:mm',
		0x012d => 'mm:ss',
		0x012e => '[h]:mm:ss',
		0x012f => 'mm:ss.0'
	 );

	var $last_block;
	var $last_small_block;
	var $fat;
	var $small_fat;
	var $directory;
	var $worksheet;
	var $date1904;

/*
 * Public interface
 *
 */

/*
 * Data convertion functions
 *
 */

	function IsUnicode($data) {
		if( !is_string($data) || (ord($data[0])==0) ) {
			return false;
		}

		return true;
	}

	function AsIs($data) {
		if( is_string($data) ) {
			return substr($data,1);
		} else {
			return $data;
		}
	}

	function AsPlain($data) {
		if( is_string($data) ) {
			if( ord($data[0])==0 ) {
				return substr($data,1);
			} else {
				$s = '';
				for( $i=1; $i<strlen($data); $i+=2 )
					$s .= $data[$i];
				return $s;
			}
		} else {
			return $data;
		}
	}

	function AsHTML($data) {
		if( is_string($data) ) {
			if( ord($data[0])==0 ) {
				return htmlspecialchars(substr($data,1));
			} else {
				$s = '';
				for( $c=1; $c<strlen($data); $c+=2 ) {
				 $l = ord($data[$c]);
				 $h = ord($data[$c+1]);
				 if( ($h>0) || ($l<32) ) {
			 		$s .= '&#'.(256*$h+$l).';';
				 } else {
					$s .= htmlspecialchars($data[$c]);
				 }
				}
				return $s;
			}
		} else {
			return $data;
		}
	}

	function AsDate($data) {
		$d = $this->AsPlain($data);
		if( is_numeric($d) )
			return $this->as_date($d);
		return false;
	}

/*
 * Worksheets functions
 *
 */

	function GetWorksheetsNum() {
		return count($this->worksheet);
	}

	function GetWorksheetType($n) {
		return $this->worksheet[$n]['type'];
	}

	function GetWorksheetTitle($n) {
		return $this->worksheet[$n]['title'];
	}

	function IsEmptyWorksheet($n) {
		return !( is_array($this->worksheet[$n]['data']) &&
		    ($this->worksheet[$n]['last_row'] >= 0) &&
		    ($this->worksheet[$n]['last_col'] >= 0) );
	}

	function IsHiddenWorksheet($n) {
		return $this->worksheet[$n]['hidden'];
	}

/*
 * Columns functions
 *
 */

	function GetLastColumnIndex($n) {
		if( isset($this->worksheet[$n]['last_col']) &&
		    ($this->worksheet[$n]['last_col'] >= 0) )
			return $this->worksheet[$n]['last_col'];
		else
			return false;
	}

	function GetColumnLevel($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_level'][$col]) )
		 return $this->worksheet[$n]['data']['column_level'][$col];
		return 0;
	}

	function IsEmptyColumn($n,$col) {
		if( isset($this->worksheet[$n]['last_row']) ) {
		 for($i=0; $i<=$this->worksheet[$n]['last_row']; $i++)
			if( isset($this->worksheet[$n]['data']['cell_type'][$i][$col]) )
				return false;
		}
		return true;
	}

	function IsHiddenColumn($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_hidden'][$col]) )
			return true;
		return false;
	}

	function GetColumnWidth($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_width'][$col]) ) {
			return $this->worksheet[$n]['data']['column_width'][$col];
		} elseif ( isset($this->worksheet[$n]['data']['defcolwidth']) ) {
			return $this->worksheet[$n]['data']['defcolwidth'];
		}
		return false;
	}

/*
 * Rows functions
 *
 */

	function GetLastRowIndex($n) {
		if( isset($this->worksheet[$n]['last_row']) &&
		    ($this->worksheet[$n]['last_row'] >= 0) )
			return $this->worksheet[$n]['last_row'];
		else
			return false;
	}

	function GetRowLevel($n,$row) {
		if( isset($this->worksheet[$n]['data']['row_level'][$row]) )
		 return $this->worksheet[$n]['data']['row_level'][$row];
		return 0;
	}

	function IsEmptyRow($n,$row) {
		return (count($this->worksheet[$n]['data']['cell_type'][$row])==0);
	}

	function IsHiddenRow($n,$row) {
		if( isset($this->worksheet[$n]['data']['row_hidden'][$row]) )
			return true;
		return false;
	}

	function GetRowHeight($n,$row) {
		if( isset($this->worksheet[$n]['data']['row_height'][$row]) ) {
			return $this->worksheet[$n]['data']['row_height'][$row];
		} elseif ( isset($this->worksheet[$n]['data']['defrowheight']) ) {
			return $this->worksheet[$n]['data']['defrowheight'];
		}
		return false;
	}

/*
 * Cells functions
 *
 */

	function GetCellLink($n,$col,$row) {
		if( !isset($this->worksheet[$n]['data']['cell_link'][$row][$col]) )
			return false;

		$d = $this->worksheet[$n]['data']['cell_link'][$row][$col];
		if( !is_numeric($d) || !isset($this->link[$d]) )
			return false;

		return $this->link[$d];
	}

	function GetCellType($n,$col,$row) {
		if( !isset($this->worksheet[$n]['data']['cell_type'][$row][$col]) ) {
			return 0;
		}

		$t = $this->worksheet[$n]['data']['cell_type'][$row][$col];
		if( $t==1 ) {
			$xf_ind = $this->worksheet[$n]['data']['cell_xf'][$row][$col];
			$f = $this->xf['format'][$xf_ind];
			if( $this->is_percent_format($f) )
				return 2;
			if( $this->is_date_format($f) )
				return 6;
		}
		return $t;
	}

	function GetCellData($n,$col,$row) {
		$t = $this->GetCellType($n,$col,$row);
		if( ($t==0) || ($t==7) || ($t==8) ) {
			return null;
		}

		if( $t==3 ) {
			$ind = $this->worksheet[$n]['data']['cell_data'][$row][$col];
			if( isset($ind) && is_numeric($ind) && isset($this->sst[$ind]) )
				return $this->sst[$ind];
			else
				return false;
		}

		$d = $this->worksheet[$n]['data']['cell_data'][$row][$col];

		if( $t==6 ) {
			$xf_ind = $this->worksheet[$n]['data']['cell_xf'][$row][$col];
			$f = $this->xf['format'][$xf_ind];
			return $this->date_format($d,$f);
		}

		return $d;
	}

	function GetCellStyle($n,$col,$row) {
	 $col_set = false;
	 $row_set = false;
	 if( isset($this->worksheet[$n]['data']['column_xf'][$col]) ) {
		$col_set = true;
	 }
	 if( isset($this->worksheet[$n]['data']['row_xf'][$row]) ) {
		$row_set = true;
	 }

	 if( $row_set && $col_set ) {
		if( $this->worksheet[$n]['data']['row_order'][$row] >
		    $this->worksheet[$n]['data']['column_order'][$col] ) {
			$dxf_ind = $this->worksheet[$n]['data']['row_xf'][$row];
		} else {
			$dxf_ind = $this->worksheet[$n]['data']['column_xf'][$col];
		}
	 } elseif ( $row_set ) {
		$dxf_ind = $this->worksheet[$n]['data']['row_xf'][$row];
	 } elseif ( $col_set ) {
		$dxf_ind = $this->worksheet[$n]['data']['column_xf'][$col];
	 } else {
		$dxf_ind = 15;
	 }

	 if( !isset($this->worksheet[$n]['data']['cell_xf'][$row][$col]) ) {
		$xf_ind = $dxf_ind;
	 } else {
		$xf_ind = $this->worksheet[$n]['data']['cell_xf'][$row][$col];
	 }

	 $style = array();

	 $xfi = false;
	 if( isset($this->xf['font'][$xf_ind]) ) {
		$xfi = $xf_ind;
	 } elseif( isset($this->xf['font'][$dxf_ind]) ) {
		$xfi = $dxf_ind;
	 }

	 if( isset($this->xf['font'][$xfi]) ) {
		$font_ind = $this->xf['font'][$xfi];
		if( $font_ind > 3 ) $font_ind--;
		if( isset($this->font[$font_ind]) ) {
			$style['font'] = $this->font[$font_ind];
			unset($style['font']['pal_ind']);
			$style['font_index'] = $font_ind;
			$pal_ind = $this->font[$font_ind]['pal_ind'];
			if( isset($this->palette[$pal_ind]) ) {
				$style['color'] = $this->palette[$pal_ind];
			}
		}
	 }

	 $xfi = false;
	 if( isset($this->xf['format'][$xf_ind]) ) {
		$xfi = $xf_ind;
	 } elseif( isset($this->xf['format'][$dxf_ind]) ) {
		$xfi = $dxf_ind;
	 }

	 if( isset($this->xf['format'][$xfi]) ) {
		$format_ind = $this->xf['format'][$xfi];
		if( isset($this->format[$format_ind]) ) {
			$style['format'] = $this->format[$format_ind];
			$style['format_index'] = $format_ind;
		}
		if( (($format_ind >= 0) && ($format_ind <= 4)) ||
		    (($format_ind >= 9) && ($format_ind <= 0x16)) ||
		    (($format_ind >= 0x25) && ($format_ind <= 0x28)) ||
		    (($format_ind >= 0x2d) && ($format_ind <= 0x31)) ) {
			$style['format_index'] = $format_ind;
		}
	 }

	 $xfi = false;
	 if( isset($this->xf['bgcolor'][$xf_ind]) ) {
		$xfi = $xf_ind;
	 } elseif( isset($this->xf['bgcolor'][$dxf_ind]) ) {
		$xfi = $dxf_ind;
	 }

	 if( isset($this->xf['bgcolor'][$xfi]) ) {
		$bgcolor_ind = $this->xf['bgcolor'][$xfi];
		if( isset($this->palette[$bgcolor_ind]) ) {
			$style['bgcolor'] = $this->palette[$bgcolor_ind];
		}
	 }

	 $xfi = false;
	 if( isset($this->xf['align'][$xf_ind]) ) {
		$xfi = $xf_ind;
	 } elseif( isset($this->xf['align'][$dxf_ind]) ) {
		$xfi = $dxf_ind;
	 }

	 if( isset($this->xf['align'][$xfi]) ) {
		$align = $this->xf['align'][$xfi];
		$style['align'] = $align & 7;
		$style['valign'] = ($align >> 4) & 7;
		$style['word_wrap'] = (boolean)(($align >> 3) & 1);
	 }

	 return $style;
	}

	function GetMergedColumnsNum($n,$col,$row,$exclude_hidden=false) {
		if( !isset($this->worksheet[$n]['data']['merged_columns']) ||
		    !isset($this->worksheet[$n]['data']['merged_columns'][$row][$col]) ) {
			return 0;
		}
		$mc = (int)($this->worksheet[$n]['data']['merged_columns'][$row][$col]);
		if( $exclude_hidden ) {
			$new_mc = $mc;
			for( $i=$col; $i<$col+$mc; $i++ ) {
				if( $this->IsHiddenColumn($n,$i) )
					$new_mc--;
			}
			$mc = $new_mc;
		}
		return $mc;
	}

	function GetMergedRowsNum($n,$col,$row,$exclude_hidden=false) {
		if( !isset($this->worksheet[$n]['data']['merged_rows']) ||
		    !isset($this->worksheet[$n]['data']['merged_rows'][$row][$col]) ) {
			return 0;
		}
		$mc = (int)($this->worksheet[$n]['data']['merged_rows'][$row][$col]);
		if( $exclude_hidden ) {
			$new_mc = $mc;
			for( $i=$row; $i<$row+$mc; $i++ ) {
				if( $this->IsHiddenRow($n,$i) )
					$new_mc--;
			}
			$mc = $new_mc;
		}
		return $mc;
	}

/*
 * Miscellaneous functions
 *
 */

	function SerializeData() {
	 $sst = '';
	 for( $i=0; $i<count($this->sst); $i++ ) {
		$sz = strlen($this->sst[$i]);
		$sst .= chr($sz & 0xFF).chr($sz >> 8).$this->sst[$i];
	 }

	 return serialize(array(
		$this->worksheet,
		$sst,
		$this->xf,
		$this->format,
		$this->font,
		$this->palette,
		$this->date1904,
		$this->link
	 ));
	}

	function UnserializeData($data) {
	 $data = unserialize($data);
	 if( !is_array($data) || (count($data)<8) ) {
		return false;
	 }

	 $this->worksheet = $data[0];

	 $ofs = 0;
	 $this->sst = array();
	 while( $ofs<strlen($data[1])-1 ) {
		$sz = ord($data[1][$ofs])|(ord($data[1][$ofs+1])<<8);
		$this->sst[] = substr($data[1],$ofs+2,$sz);
		$ofs += 2+$sz;
	 }

	 $this->xf = $data[2];
	 $this->format = $data[3];
	 $this->font = $data[4];
	 $this->palette = $data[5];
	 $this->date1904 = $data[6];
	 $this->link = $data[7];

	 return true;
	}

	function GetFontsList() {
	 $fl = array();
	 for( $i=0; $i<count($this->font); $i++ ) {
		$f = $this->font[$i];
		unset($f['pal_ind']);
		$pal_ind = $this->font[$i]['pal_ind'];
		if( isset($this->palette[$pal_ind]) ) {
			$f['color'] = $this->palette[$pal_ind];
		}
		$fl[] = $f;
	 }
	 return $fl;
	}

	function GetFormatsList() {
	 return $this->format;
	}

/*
 * End of public interface
 *
 */

	function is_percent_format($f) {
	 if( ($f==9) || ($f==0x0a) )
		return true;

	 if( !isset($this->format[$f]) )
		return false;

	 $fs = $this->format[$f];
	 if( !$fs || $this->IsUnicode($fs) )
		return false;

	 $fs = $this->AsPlain($fs);

	 if( (strlen($fs) > 0) && ($fs[strlen($fs)-1] == '%')  )
		return true;

	 return false;
	}

	function is_date_format($f) {
	 if ( (($f>=0x0e) && ($f<=0x16)) || (($f>=0x2d) && ($f<=0x2f)) )
		return true;

	 if( !isset($this->format[$f]) )
		return false;

	 $fs = $this->format[$f];
	 if( !$fs || $this->IsUnicode($fs) )
		return false;

	 $fs = $this->AsPlain($fs);
	 if( $fs=='' )
		return false;

	 $f = 0xff;
	 foreach( $this->known_date_formats as $i => $value )
		if( !strcmp($value,$fs) ) {
			$f = $i;
			break;
		}

	 if( $f==0xff )
		return false;

	 return true;
	}

	function as_date($s) {
	 if( $s<0 )
		return $s;

	 $DaysInMonths = array(0,31,59,90,120,151,181,212,243,273,304,334);
	 $DaysInMonthsV = array(0,31,60,91,121,152,182,213,244,274,305,335);

	 if( ($this->date1904==0) && ($s<60) )
		$s++;
	 // days in 1900 years (1-1899)
	 $ds = (int)$s+693595-2+1462*$this->date1904;

	 // 400-year periods in $ds
	 $d1 = (int)($ds/146097);
	 // days after last 400-year period (0-146096)
	 $d2 = $ds-146097*$d1;
	 // 100-year periods in $d2
	 $d3 = (int)($d2/36524);
	 if( $d3>3 )
		$d3 = 3;
	 // days after last 100-year period (0-36523 or 0-36524)
	 $d4 = $d2-36524*$d3;
	 // 4-year periods in $d4
	 $d5 = (int)($d4/1461);
	 // days after last 4-year period (0-1460)
	 $d6 = $d4-1461*$d5;
	 // years in $d6
	 $d7 = (int)($d6/365);
	 if( $d7>3 )
		$d7 = 3;
	 // days in a last year (1-365 or 1-366)
	 $d8 = $d6-365*$d7+1;

	 $date_year = 400*$d1 + 100*$d3 + 4*$d5 + $d7 + 1;

	 $v = false;
	 if( (($date_year % 400) == 0) || 
	     ((($date_year % 100) != 0) && (($date_year % 4) == 0)) )
		$v = true;

	 $i = 1;
	 if( $v ) {
		while( ($i<12) && ($d8>$DaysInMonthsV[$i]) ) $i++;
		$date_month = $i;
		$date_day = $d8 - $DaysInMonthsV[$i-1];
	 } else {
		while( ($i<12) && ($d8>$DaysInMonths[$i]) ) $i++;
		$date_month = $i;
		$date_day = $d8 - $DaysInMonths[$i-1];
	 }

	 $tm = $s-(int)$s;
	 $tm = round(24*60*60*1000*$tm);
	 $time_msec = ($tm % 1000);
	 $tm = (int)(($tm-$time_msec)/1000);
	 $time_sec = ($tm % 60);
	 $tm = (int)(($tm-$time_sec)/60);
	 $time_min = ($tm % 60);
	 $tm = (int)(($tm-$time_min)/60);
	 $time_hour = ($tm % 24);

	 return array(
		'year'	=> $date_year,
		'month'	=> $date_month,
		'day'	=> $date_day,
		'hour'	=> $time_hour,
		'min'	=> $time_min,
		'sec'	=> $time_sec,
		'usec'	=> $time_msec
	 );
	}

	function date_format($s,$f) {

	 if ( !((($f>=0x0e) && ($f<=0x16)) || (($f>=0x2d) && ($f<=0x2f))) ) {

	  $fs = $this->AsPlain($this->format[$f]);
	  foreach( $this->known_date_formats as $i => $value )
		if( !strcmp($value,$fs) ) {
			$f = $i;
			break;
		}
	 } else {
		$f += 0x100;
	 }

	 $ret = $this->as_date($s);
	 $date_year = $ret['year'];
	 $date_month = $ret['month'];
	 $date_day = $ret['day'];
	 $time_hour = $ret['hour'];
	 $time_min = $ret['min'];
	 $time_sec = $ret['sec'];
	 $time_msec = $ret['usec'];

	 for($i=1; $i<=12; $i++) {
		$month[$i] = date('F',mktime(12,0,0,$i,10,2000));
		$month3[$i] = date('M',mktime(12,0,0,$i,10,2000));
	 }

	 $date_year2 = sprintf('%02d',($date_year % 100));
	 $date_month2 = sprintf('%02d',$date_month);
	 $date_day2 = sprintf('%02d',$date_day);
	 $time_hour2 = sprintf('%02d',$time_hour);
	 $time_min2 = sprintf('%02d',$time_min);
	 $time_sec2 = sprintf('%02d',$time_sec);
	 if( $time_hour>=12 ) {
		$time_ap = 'PM';
		$time_hour12 = $time_hour-12;
	 } else {
		$time_ap = 'AM';
		$time_hour12 = $time_hour;
	 }
	 if( $time_hour12==0 )
		$time_hour12 = 12;
	 $time_hour_full = (int)($s*24);


	 $s = '';
	 switch ($f) {

		//--- CUSTOM ---
		// d/m/yy
		case 1:
			$s = '/'.$date_year2;

		// d/m
		case 0:
			$s = $date_day.'/'.$date_month.$s;
			break;

		// dd/mm/yy\ h:mm\ AM/PM
		case 9:
			$s = ' '.$time_hour12.':'.$time_min2.' '.$time_ap;

		// dd/mm/yy
		case 2:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year2.$s;
			break;

		// d\ mmm\ yy
		case 4:
			$s = ' '.$date_year2;

		// d\ mmm
		case 3:
			$s = $date_day.' '.$month3[$date_month].$s;
			break;

		// dd\ mmm\ yy
		case 5:
			$s = $date_day2.' '.$month3[$date_month].' '.$date_year2;
			break;

		// mmm\ yy
		case 6:
			$s = $month3[$date_month].' '.$date_year2;
			break;

		// mmmm\ yy
		case 7:
			$s = $month[$date_month].' '.$date_year2;
			break;

		// d\ mmmm\,\ yyyy
		case 8:
			$s = $date_day.' '.$month[$date_month].', '.$date_year;
			break;

		// dd/mm/yy\ h:mm
		case 0x0a:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year2.' '.$time_hour.':'.$time_min2;
			break;

		// mmmm\ d
		case 0x0d:
			$s = ' '.$date_day;

		// mmmm
		case 0x0b:
			$s = $month[$date_month].$s;
			break;

		// mmmmm\-yy
		case 0x0c:
			$s = $month[$date_month][0].'-'.$date_year2;
			break;

		// d\ mmmm
		case 0x0e:
			$s = $date_day.' '.$month[$date_month];
			break;

		// d/mm/yyyy
		case 0x0f:
			$s = $date_day.'/'.$date_month2.'/'.$date_year;
			break;

		// dd/mm/yyyy
		case 0x10:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year;
			break;

		// d/m/yyyy
		case 0x11:
			$s = $date_day.'/'.$date_month.'/'.$date_year;
			break;

		// dd\-mmm\-yy
		case 0x12:
			$s = $date_day2.'-'.$month3[$date_month].'-'.$date_year2;
			break;

		//--- BUILD-IN ---
		// m/d/yyyy\ h:mm
		case 0x0116:
			$s = ' '.$time_hour.':'.$time_min2;

		// m/d/yyyy
		case 0x010e:
// Month and Day order ??? (must be obtained from locale settings/date format)
			$s = $date_month.'/'.$date_day.'/'.$date_year.$s;
			break;

		// d\-mmm\-yy
		case 0x010f:
			$s = '-'.$date_year2;

		// d\-mmm
		case 0x0110:
			$s = $date_day.'-'.$month3[$date_month].$s;
			break;

		// mmm\-yy
		case 0x0111:
			$s = $month3[$date_month].'-'.$date_year2;
			break;

		// h:mm AM/PM
		case 0x0112:
			$s = $time_hour12.':'.$time_min2.' '.$time_ap;
			break;

		// h:mm:ss AM/PM
		case 0x0113:
			$s = $time_hour12.':'.$time_min2.':'.$time_sec2.' '.$time_ap;
			break;

		// h:mm:ss
		case 0x0115:
			$s = ':'.$time_sec2;

		// h:mm
		case 0x0114:
			$s = $time_hour.':'.$time_min2.$s;
			break;

		// mm:ss
		case 0x012d:
			$s = $time_min2.':'.$time_sec2;
			break;

		// [h]:mm:ss
		case 0x012e:
			$s = $time_hour_full.':'.$time_min2.':'.$time_sec2;
			break;

		// mm:ss.0
		case 0x012f:
			$s = $time_min2.':'.$time_sec2.'.'.round(($time_msec-1)/100);
			break;
	 }
	 return array(
		'string'=> $s,
		'year'	=> $date_year,
		'month'	=> $date_month,
		'day'	=> $date_day,
		'hour'	=> $time_hour,
		'min'	=> $time_min,
		'sec'	=> $time_sec,
		'usec'	=> $time_msec
	 );
	}

	function s2l($s) {
	 return 16777216*ord($s[3])+(ord($s[0])|(ord($s[1])<<8)|(ord($s[2])<<16));
	}

	function chain($first) {
		$chain = array();

		$next = $first;
		while(  ($next!=0xfffffffe) &&
			($next <= $this->last_block) &&
			(($next+1) <= count($this->fat)) ) {
			$chain[] = $next;
			$next = $this->fat[$next];
		}
		if( $next != 0xfffffffe ) return false;
		return $chain;
	}

	function small_chain($first) {
		$chain = array();

		$next = $first;
		while(  ($next!=0xfffffffe) &&
			($next <= $this->last_small_block) &&
			(($next+1) <= count($this->small_fat)) ) {
			$chain[] = $next;
			$next = $this->small_fat[$next];
		}
		if( $next != 0xfffffffe ) return false;
		return $chain;
	}

	function stream($item_name,$item_num=0) {

		$dt = ord($this->directory[$item_num*0x80+0x42]);
		$prev = $this->s2l(substr($this->directory,$item_num*0x80+0x44,4));
		$next = $this->s2l(substr($this->directory,$item_num*0x80+0x48,4));
		$dir = $this->s2l(substr($this->directory,$item_num*0x80+0x4c,4));

		$curr_name = '';
		if( ($dt==2) || ($dt==5) )
			for( $i=0;
			 $i < (ord($this->directory[$item_num*0x80+0x40]) + 
			  256*ord($this->directory[$item_num*0x80+0x41]))/2-1;
			 $i++ )
				$curr_name .= $this->directory[$item_num*0x80+$i*2];

		if( (($dt==2) || ($dt==5)) && (strcasecmp($curr_name,$item_name)==0) )
			return $item_num;

		if( $prev != 0xffffffff ) {
			$i = $this->stream($item_name,$prev);
			if( $i>=0 ) return $i;
		}
		if( $next != 0xffffffff ) {
			$i = $this->stream($item_name,$next);
			if( $i>=0 ) return $i;
		}
		if( $dir != 0xffffffff ) {
			$i = $this->stream($item_name,$dir);
			if( $i>=0 ) return $i;
		}

		return -1;
	}

	function rk($rk) {
		if( $rk & 2 ) {
			$val = ($rk & 0xfffffffc) >> 2;
			if( $rk & 1 ) $val = $val / 100;
			return (int)$val;
		}

		$frk = $rk;

		$fexp =  (($frk & 0x7ff00000) >> 20) - 1023;
		$val = 1+(($frk & 0x000fffff) >> 2)/262144;

		if( $fexp > 0 ) {
			for( $i=0; $i<$fexp; $i++ )
				$val *= 2;
		} else {
			if( $fexp==-1023 ) {
				$val=0;
			} else {
			 for( $i=0; $i<abs($fexp); $i++ )
				$val /= 2;
			}
		}

		if( $rk & 1 ) $val = $val / 100;
		if( $rk & 0x80000000 ) $val = -$val;

		return (float)$val;
	}

	function ieee($ieee) {
		$num_lo = 16777216*ord($ieee[3])+(ord($ieee[0])|(ord($ieee[1])<<8)|(ord($ieee[2])<<16));
		$num_hi = 16777216*ord($ieee[7])+(ord($ieee[4])|(ord($ieee[5])<<8)|(ord($ieee[6])<<16));

		$fexp = (($num_hi & 0x7ff00000) >> 20) - 1023;
		$val = 1+(($num_hi & 0x000fffff)+$num_lo/4294967296)/1048576;

		if( ($fexp==1024) || ($fexp==-1023) )
			return (float)0;

		if( $fexp > 0 ) {
			for( $i=0; $i<$fexp; $i++ )
				$val *= 2;
		} else {
			for( $i=0; $i<abs($fexp); $i++ )
				$val /= 2;
		}
		if( $num_hi & 0x80000000 ) $val = -$val;

		return (float)$val;
	}

	function explore_worksheet($ofs) {

		if( //(strlen($this->bd) < 4) ||
		    //(strlen($this->bd) < 4+256*ord($this->bd[3])+ord($this->bd[2])) ||
		    (ord($this->bd[$ofs]) != 0x09) )
			return 1;

		$biff_ver = $this->biff_version;
		$data = array('last_row'=>-1,'last_col'=>-1);
		$wtype = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
		if( $wtype != 0x0010 )
			return $data;

		$merged = array();
		$item = 0;

		$defcolwidth = false;

		while( (ord($this->bd[$ofs])!=0x0a) && ($ofs<strlen($this->bd)) ) {

		 switch (ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8)) {

		  // COLINFO
		  case 0x007d:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 10 )
				return 1;
			$fc = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$lc = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$width = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);
			$xf = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			$opts = ord($this->bd[$ofs+12])|(ord($this->bd[$ofs+13])<<8);
			$hidden = (($opts & 1)==1);
			$level = ($opts & 0x0700) >> 8;
			for( $i=$fc; $i<=$lc; $i++ ) {
				if( $hidden ) {
					$data['column_hidden'][$i] = true;
				}
				if( $level > 0 ) {
					$data['column_level'][$i] = $level;
				}
				$data['column_width'][$i] = $width;
				$data['column_xf'][$i] = $xf;
				$data['column_order'][$i] = $item;
			}

			if( ($data['last_col'] < $lc) &&
			    isset($this->xf['bgcolor'][$xf]) &&
			    isset($this->palette[$this->xf['bgcolor'][$xf]]) )
				$data['last_col'] = $lc;

			break;

		  // DEFCOLWIDTH
		  case 0x0055:
			if( $defcolwidth === false ) {
				$defcolwidth = 292.5*(ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8));
			}
			break;

		  // STANDARDWIDTH
//		  case 0x0099:
//			$defcolwidth = 292.5*(ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8));
//			break;

		  // ROWINFO
		  case 0x0208:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 16 )
				return 1;

			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$height = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			if( !($height & 0x8000) ) {
				if( !isset($data['defrowheight']) ||
				    ($height != $data['defrowheight']) ) {
					$data['row_height'][$row] = $height;
				}
			}
			$opts = 16777216*ord($this->bd[$ofs+19])+(ord($this->bd[$ofs+16])|(ord($this->bd[$ofs+17])<<8)|(ord($this->bd[$ofs+18])<<16));
			if( $opts & 0x0020 ) {
				$data['row_hidden'][$row] = true;
			}
			if( $level = $opts & 0x7 ) {
				$data['row_level'][$row] = $level;
			}
			if( $opts & 0x80 ) {
				$xf = ($opts & 0x0fff0000) >> 16;
				$data['row_xf'][$row] = $xf;
				if( ($data['last_row'] < $row) &&
				    isset($this->xf['bgcolor'][$xf]) &&
				    isset($this->palette[$this->xf['bgcolor'][$xf]]) )
					$data['last_row'] = $row;
			}
			$data['row_order'][$row] = $item;

			break;

		  // DEFAULTROWHEIGHT
		  case 0x0225:
			$data['defrowheight'] = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			break;

		  // BLANK
		  case 0x0201:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 6 )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$data['cell_type'][$row][$col] = 7;
			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // MULBLANK
		  case 0x00be:
			$len = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			if( $len < 8 )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$lcol = ord($this->bd[$ofs+2+$len])|(ord($this->bd[$ofs+3+$len])<<8);
			if( $lcol < $col ) break;
			if( $len != ($lcol-$col+1)*2+6 ) break;

			for( $i=$col; $i<=$lcol; $i++) {
				$data['cell_type'][$row][$i] = 7;
				$data['cell_xf'][$row][$i] = ord($this->bd[$ofs+8+2*($i-$col)])|(ord($this->bd[$ofs+9+2*($i-$col)])<<8);
			}

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $lcol ) $data['last_col'] = $lcol;

			break;

		  // BOOLERR
		  case 0x0205:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 8 )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);

			if( ord($this->bd[$ofs+11])==0 ) {
				$data['cell_type'][$row][$col] = 4;
				$data['cell_data'][$row][$col] = (boolean)(ord($this->bd[$ofs+10]));
			} else {
				$data['cell_type'][$row][$col] = 5;
				$data['cell_data'][$row][$col] = (int)(ord($this->bd[$ofs+10]));
			}

			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // NUMBER
		  case 0x0203:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 14 )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);

			$data['cell_type'][$row][$col] = 1;
			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);
			$data['cell_data'][$row][$col] = $this->ieee(substr($this->bd,$ofs+10,8));

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // RK
		  case 0x027e:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 0x0a )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$data['cell_type'][$row][$col] = 1;
			$data['cell_data'][$row][$col] = $this->rk(16777216*ord($this->bd[$ofs+13])+(ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8)|(ord($this->bd[$ofs+12])<<16)));
			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // MULRK
		  case 0x00bd:
			$rksz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			if( $rksz < 6 ) return 1;

			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$fc = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$lc = ord($this->bd[$ofs+$rksz+2])|(ord($this->bd[$ofs+$rksz+3])<<8);

			for( $i=0; $i<=$lc-$fc; $i++) {
			 $data['cell_type'][$row][$fc+$i] = 1;
			 $data['cell_data'][$row][$fc+$i] = $this->rk(16777216*ord($this->bd[$ofs+13+$i*6])+(ord($this->bd[$ofs+10+$i*6])|(ord($this->bd[$ofs+11+$i*6])<<8)|(ord($this->bd[$ofs+12+$i*6])<<16)));
			 $data['cell_xf'][$row][$fc+$i] = ord($this->bd[$ofs+8+$i*6])|(ord($this->bd[$ofs+9+$i*6])<<8);
			}

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $lc ) $data['last_col'] = $lc;

			break;

		  // LABEL or LABEL with formatting info
		  case 0x0204:
		  case 0x00d6:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 8 )
				return 1;

			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$str_len = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			if( $ofs+12+$str_len > strlen($this->bd) )
				return 1;
			$this->sst[] = chr(0).substr($this->bd,$ofs+12,$str_len);
			$data['cell_type'][$row][$col] = 3;
			$data['cell_data'][$row][$col] = count($this->sst)-1;
			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // FORMULA
		  case 0x0006:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 20 )
				return 1;

			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$xf = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);
			$res = substr($this->bd,$ofs+10,8);

			$data_ok = false;

			if( (ord($res[6])==0xff) && (ord($res[7])==0xff) ) {
			 switch (ord($res[0])) {

			  // STRING
			  case 0:
		 	   $ofs = $ofs+4+(ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8));
			   if ((ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8))==0x0207) {
			    $sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			    if( $ofs+4+$sz > strlen($this->bd) )
				return 1;

			    $ln = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);

			    if($biff_ver < 8) {
			     if( $ln+2 <= $sz ) {
				$data['cell_type'][$row][$col] = 3;
				$this->sst[] = chr(0).substr($this->bd,$ofs+6,$ln);
				$data['cell_data'][$row][$col] = count($this->sst)-1;
			     } else {
				$str = substr($this->bd,$ofs+6,$sz-2);
				$ln -= $sz-2;
				while( $ln>0 ) {
				 $ofs += 4+(ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8));
				 if( (ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8)) != 0x3c )
					return 1;

				 $sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
				 if( $ofs+$sz+4 > strlen($this->bd) )
					return 1;

				 $str .= substr($this->bd,$ofs+4,$sz);
				 $ln -= $sz;
				}
				$data['cell_type'][$row][$col] = 3;
				$this->sst[] = $s;
				$data['cell_data'][$row][$col] = count($this->sst)-1;
			     }
			    } else {

			     $rt = 0;
			     $fesz = 0;
			     $s = chr(0);
			     $fln = $ln;
			     $sofs = $ofs+6;

			     while ( $fln>0 ) {
			      $uc = ord($this->bd[$sofs]) & 1;
			      $ln = $fln;

			      switch (ord($this->bd[$sofs]) & 0x0c) {

			       case 0x0c:
				$rt = ord($this->bd[$sofs+1])|(ord($this->bd[$sofs+2])<<8);
				$fesz = $this->s2l(substr($this->bd,$sofs+3,4));
				if( $sofs+3+$ln*($uc+1) > $ofs+$sz )
					$ln = (int)($ofs+$sz-$sofs-3)/($uc+1);
				$str = substr($this->bd,$sofs+7,$ln*($uc+1));
				break;

			       case 8:
				$rt = ord($this->bd[$sofs+1])|(ord($this->bd[$sofs+2])<<8);
				if( $sofs-1+$ln*($uc+1) > $ofs+$sz )
					$ln = (int)($ofs+1+$sz-$sofs)/($uc+1);
				$str = substr($this->bd,$sofs+3,$ln*($uc+1));
				break;

			       case 4:
				$fesz = $this->s2l(substr($this->bd,$sofs+1,4));
				if( $sofs+1+$ln*($uc+1) > $ofs+$sz )
					$ln = (int)($ofs-1+$sz-$sofs)/($uc+1);
				$str = substr($this->bd,$sofs+5,$ln*($uc+1));
				break;

			       case 0:
				if( $sofs-3+$ln*($uc+1) > $ofs+$sz )
					$ln = (int)($ofs+3+$sz-$sofs)/($uc+1);
			 	$str = substr($this->bd,$sofs+1,$ln*($uc+1));
				break;
			      }

			      if( ($uc==0) && (ord($s[0]) & 1) ) {
				$s2 = '';
				for( $i=0; $i<strlen($str); $i++ )
					$s2 .= $str[$i].chr(0);
				$str = $s2;
			      }

			      if( ($uc==1) && !(ord($s[0]) & 1) ) {
				$s2 = chr(1);
				for( $i=1; $i<strlen($s); $i++ )
					$s2 .= $s[$i].chr(0);
				$s = $s2;
			      }

			      $s .= $str;
			      $fln -= $ln;

			      if( $fln>0 ) {
				$ofs += 4+(ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8));
				if( (ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8)) != 0x3c )
					return 1;

				$sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
				if( $ofs+$sz+4 > strlen($this->bd) )
					return 1;

				$sofs = $ofs+4;
			      }
			     }

			     $data['cell_type'][$row][$col] = 3;
			     $this->sst[] = $s;
			     $data['cell_data'][$row][$col] = count($this->sst)-1;
			    }
			    $data_ok = true;
			   }
			   break;

			  // BOOLEAN
			  case 1:
				$data['cell_type'][$row][$col] = 4;
				$data['cell_data'][$row][$col] = (boolean)(ord($res[2]));
				$data_ok = true;
				break;

			  // ERROR
			  case 2:
				$data['cell_type'][$row][$col] = 5;
				$data['cell_data'][$row][$col] = (int)(ord($res[2]));
				$data_ok = true;
				break;
			 }
			} else {

			 // IEEE
			 $data['cell_type'][$row][$col] = 1;
			 $data['cell_data'][$row][$col] = $this->ieee($res);
			 $data_ok = true;
                        }

			if( $data_ok ) {
				if( $data['last_row'] < $row ) $data['last_row'] = $row;
				if( $data['last_col'] < $col ) $data['last_col'] = $col;
			 	$data['cell_xf'][$row][$col] = $xf;
			}
			
			break;

		  // LABELSST
		  case 0x00fd:
			if( (ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8)) < 0x0a )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$col = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$data['cell_type'][$row][$col] = 3;
			$data['cell_data'][$row][$col] = 16777216*ord($this->bd[$ofs+13])+(ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8)|(ord($this->bd[$ofs+12])<<16));
			$data['cell_xf'][$row][$col] = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			break;

		  // HLINK
		  case 0x01b8:
			$len = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			if( $len < 32 )
				return 1;
			$row = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$lrow = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$col = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);
			$lcol = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			$opt = $this->s2l(substr($this->bd,$ofs+32,4));

			$link = array('type' => 0,'absolute' => ($opt & 2) >> 1);

			$lofs = $ofs+36;
			if( ($opt & 0x14) == 0x14 ) {
				$dlen = $this->s2l(substr($this->bd,$ofs+36,4));
				if( $len < 36+2*$dlen )
					return 1;
				$lofs = $ofs+40+2*$dlen;
			}

			if( ($opt & 0x101) == 1 ) {
			  if( $len < $lofs-$ofs+12 )
				return 1;

			  $url_id = array(
				0xe0,0xc9,0xea,0x79,0xf9,0xba,0xce,0x11,
				0x8c,0x82,0x00,0xaa,0x00,0x4b,0xa9,0x0b
			  );
			  $file_id = array(
				0x03,0x03,0x00,0x00,0x00,0x00,0x00,0x00,
				0xc0,0x00,0x00,0x00,0x00,0x00,0x00,0x46
			  );

			  $url = true;
			  for( $i=0; $i<count($url_id); $i++ ) {
				if( $url_id[$i] != ord($this->bd[$lofs+$i]) ) {
					$url = false;
					break;
				}
			  }

			  if( !$url ) {
				$file = true;
				for( $i=0; $i<count($file_id); $i++ ) {
				  if( $file_id[$i] != ord($this->bd[$lofs+$i]) ) {
					$file = false;
					break;
				  }
				}
			  } else {
				$file = false;
			  }

			  if( $url || $file ) {
			    if( $url ) {
				$link['type'] = 1;
				$ulen = $this->s2l(substr($this->bd,$lofs+16,4));
				if( $len < $lofs-$ofs+16+$ulen )
					return 1;
				$url = chr(1);
				if( $ulen > 2 ) {
				  $url .= substr($this->bd,$lofs+20,$ulen-2);
				}
				$lofs += 20+$ulen;
				$link['link'] = $url;
			    } elseif( $file ) {
				$link['type'] = 2;
				$link['updir'] = ord($this->bd[$lofs+16])|(ord($this->bd[$lofs+17])<<8);

				$sfnlen = $this->s2l(substr($this->bd,$lofs+18,4));

				if( $len < $lofs-$ofs+18+$sfnlen )
					return 1;

				$sfn = chr(0);
				if( $sfnlen > 1 ) {
					$sfn .= substr($this->bd,$lofs+22,$sfnlen-1);
				}

				$lfnslen = $this->s2l(substr($this->bd,$lofs+46+$sfnlen,4));
				$lfnlen = 0;
				if( $lfnslen > 4 ) {
					$lfnlen = $this->s2l(substr($this->bd,$lofs+50+$sfnlen,4));
				}

				if( $len < $lofs-$ofs+46+$sfnlen+$lfnslen )
					return 1;

				if( $lfnlen > 0 ) {
					$fn = chr(1).substr($this->bd,$lofs+56+$sfnlen,$lfnlen);
				} else {
					$fn = $sfn;
				}

				$lofs += 50+$sfnlen+$lfnslen;
				$link['link'] = $fn;
			    }

			  }

			} elseif( ($opt & 0x103) == 0x103 ) {
				$link['type'] = 3;
				$ulen = $this->s2l(substr($this->bd,$lofs,4));
				if( $len < $lofs-$ofs-4+$ulen*2 )
					return 1;
				$unc = chr(1);
				if( $ulen > 0 ) {
				  $unc .= substr($this->bd,$lofs+4,$ulen*2-2);
				}
				$lofs += 4+$ulen*2;
				$link['link'] = $unc;
			}

			if( $opt & 0x80 ) {
				$tlen = $this->s2l(substr($this->bd,$lofs,4));
				if( $len < $lofs-$ofs-4+$tlen*2 )
					return 1;
				$target = chr(1);
				if( $tlen > 0 ) {
				  $target .= substr($this->bd,$lofs+4,$tlen*2-2);
				}
				$lofs += 4+$tlen*2;
				$link['target'] = $target;
			}

			if( $opt & 8 ) {
				$tlen = $this->s2l(substr($this->bd,$lofs,4));
				if( $len < $lofs-$ofs-4+$tlen*2 )
					return 1;
				$tmark = chr(1);
				if( $tlen > 0 ) {
				  $tmark .= substr($this->bd,$lofs+4,$tlen*2-2);
				}
				$lofs += 4+$tlen*2;
				$link['tmark'] = $tmark;
			}

			$this->link[] = $link;
			$ind = count($this->link)-1;

			for( $i=$row; $i<=$lrow; $i++ ) {
			  for( $j=$col; $j<=$lcol; $j++ ) {
				$data['cell_link'][$row][$col] = $ind;
			  }
			}

			if( $data['last_row'] < $lrow ) $data['last_row'] = $lrow;
			if( $data['last_col'] < $lcol ) $data['last_col'] = $lcol;

			break;

		  // QUICKTIP
		  case 0x0800:
			$len = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			if( $len < 10 )
				return 1;

			$qtlen = $len-10;
			if( $qtlen <= 2 )
				break;

			$row = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$lrow = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);
			$col = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			$lcol = ord($this->bd[$ofs+12])|(ord($this->bd[$ofs+13])<<8);

			$qt = chr(1).substr($this->bd,$ofs+14,$qtlen-2);
			for( $i=$row; $i<=$lrow; $i++ ) {
			  for( $j=$col; $j<=$lcol; $j++ ) {
				if( isset($data['cell_link'][$row][$col]) ) {
					$lind = $data['cell_link'][$row][$col];
					$this->link[$lind]['quick_tip'] = $qt;
				} else {
					$this->link[]['quick_tip'] = $qt;
					$data['cell_link'][$row][$col] = count($this->link)-1;
				}
			  }
			}

			break;

		  // MERGEDCELLS
		  case 0x00e5:
			$mgsz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			if( $mgsz < 2 )
				return 1;
			$cells = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			if( $mgsz < 2+8*$cells )
				return 1;

			$n = count($merged);
			for( $i=0; $i<$cells; $i++ ) {
			 $merged[$n+$i]['fr'] = ord($this->bd[$ofs+6+8*$i])|(ord($this->bd[$ofs+7+8*$i])<<8);
			 $merged[$n+$i]['lr'] = ord($this->bd[$ofs+8+8*$i])|(ord($this->bd[$ofs+9+8*$i])<<8);
			 $merged[$n+$i]['fc'] = ord($this->bd[$ofs+10+8*$i])|(ord($this->bd[$ofs+11+8*$i])<<8);
			 $merged[$n+$i]['lc'] = ord($this->bd[$ofs+12+8*$i])|(ord($this->bd[$ofs+13+8*$i])<<8);
			}

			break;

		  // unknown, unsupported or unused opcode
		  default:
			break;
		 }

		 $ofs += 4+(ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8));
		 $item++;
		}

		if( $defcolwidth !== false ) {
			$data['defcolwidth'] = $defcolwidth;
		}

		if( isset($data['row_height']) && is_array($data['row_height']) && isset($data['defrowheight']) ) {
			foreach( $data['row_height'] as $key => $val ) {
				if( $val == $data['defrowheight'] ) {
					unset($data['row_height'][$key]);
				}
			}
		}

		for( $n=0; $n<count($merged); $n++ ) {
			if( ($merged[$n]['lr'] < $merged[$n]['fr']) ||
			    ($merged[$n]['lc'] < $merged[$n]['fc']) )
				continue;
		 for( $i=$merged[$n]['fr']; $i<=$merged[$n]['lr']; $i++ )
		  for( $j=$merged[$n]['fc']; $j<=$merged[$n]['lc']; $j++ ) {
			if( ($i==$merged[$n]['fr']) && ($j==$merged[$n]['fc']) ) {
				$data['merged_rows'][$i][$j] = 1+$merged[$n]['lr']-$merged[$n]['fr'];
				$data['merged_columns'][$i][$j] = 1+$merged[$n]['lc']-$merged[$n]['fc'];
			} else {
				$data['cell_type'][$i][$j] = 8;
			}
		  }
		}

		return $data;
	}

	function Explore_file($filename) {

	 $fsz = filesize($filename);
	 if( $fsz <= 0x200 )
		return 1;

	 $fh = @fopen ($filename,'rb');
	 if( $fh===false )
		return 1;

	 $this->last_block = (int)(($fsz-1) / 0x200) - 1;

	 $header = fread( $fh, 0x200 );
	 if( strlen($header) != 0x200 ) {
		@fclose($fh);
		return 1;
	 }

	 $file_signature = array(0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1);

	 for( $i=0; $i<count($file_signature); $i++ )
		if( $file_signature[$i] != ord($header[$i]) ) {
			@fclose($fh);
			return 1;
		}

	 $root_entry_block = $this->s2l(substr($header,0x30,4));
	 $num_fat_blocks = $this->s2l(substr($header,0x2c,4));

	 $this->fat = array();
	 for( $i=0; $i<$num_fat_blocks; $i++ ) {
		$fat_block = $this->s2l(substr($header,0x4c+4*$i,4));
		if( fseek( $fh, 0x200+$fat_block*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		}
		$fat = fread( $fh, 0x200 );
		if( strlen($fat) != 0x200 ) {
			@fclose($fh);
			return 1;
		}
		for( $j=0; $j<0x80; $j++ )
		 $this->fat[] = $this->s2l(substr($fat,$j*4,4));
	 }

	 if( count($this->fat) < $num_fat_blocks ) {
		@fclose($fh);
		return 1;
	 }

	 $chain = $this->chain($root_entry_block);
	 if( !is_array($chain) ) {
		@fclose($fh);
		return 1;
	 }

	 $this->directory = '';
	 for( $i=0; $i<count($chain); $i++ ) {
		if( fseek( $fh, 0x200+$chain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		}
		$dir = fread( $fh, 0x200 );
		if( strlen($dir) < 0x200 ) {
			@fclose($fh);
			return 1;
		}
		$this->directory .= $dir;
	 }

	 $this->small_fat = array();
	 $sfc = '';
	 $small_block = $this->s2l(substr($header,0x3c,4));
	 if( $small_block != 0xfeffffff )  {
		$root_entry_index = $this->stream('Root Entry');
		if( $root_entry_index < 0 ) $root_entry_index = 0;
		$sdc_start_block = $this->s2l(substr($this->directory,$root_entry_index*0x80+0x74,4));
		$small_data_chain = $this->chain($sdc_start_block);
		if( !is_array($small_data_chain) ) {
			@fclose($fh);
			return 1;
		}

		$this->last_small_block = count($small_data_chain) * 8;

		$schain = $this->chain($small_block);
		if( !is_array($schain) ) {
			@fclose($fh);
			return 1;
		}

		for( $i=0; $i<count($schain); $i++ ) {
		  if( fseek( $fh, 0x200+$schain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		  }

		  $small_fat = fread( $fh, 0x200 );
		  if( strlen($small_fat) < 0x200 ) {
			@fclose($fh);
			return 1;
		  }

		  for( $j=0; $j<0x80; $j++ )
		   $this->small_fat[] = $this->s2l(substr($small_fat,$j*4,4));
		}

		for( $i=0; $i<count($small_data_chain); $i++ ) {
		    if( fseek( $fh, 0x200+$small_data_chain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		    }
		    $sfc .= fread( $fh, 0x200 );
		}
	 }

	 $ibook = $this->stream('Workbook');
	 if( $ibook<0 ) {
		$ibook = $this->stream('Book');
		if( $ibook<0 )
			return 1;
	 }

	 $lbook = $this->s2l(substr($this->directory,$ibook*0x80+0x78,4));
	 if( $lbook == 0 ) {
		@fclose($fh);
		return 1;
	 }

	 $this->bd = '';
	 if( $lbook >= 0x1000 ) {
		$chain = $this->chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) ) {
			@fclose($fh);
			return 1;
		}

		for( $i=0; $i<count($chain); $i++ ) {
			if( fseek( $fh, 0x200+$chain[$i]*0x200 ) == -1 ) {
				@fclose($fh);
				return 1;
			}
			$this->bd .= fread( $fh, 0x200 );
		}
	 } else {
		$chain = $this->small_chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) ) {
			@fclose($fh);
			return 1;
		}

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($sfc,$chain[$i]*0x40,0x40);

	 }

	 @fclose($fh);

	 $this->bd = substr($this->bd,0,$lbook);
	 if( strlen($this->bd) != $lbook )
		return 1;

	 unset($this->fat);
	 unset($this->small_fat);
	 unset($this->directory);
	 unset($header);
	 unset($sfc);

	 $result = $this->explore_workbook();
	 unset($this->bd);
	 return $result;
	}

	function Explore($file_data) {

	 if( strlen($file_data) <= 0x200 )
		return 1;

	 $this->last_block = (int)((strlen($file_data)-1) / 0x200) - 1;
	 $header = substr($file_data,0,0x200);
	 $fc = substr($file_data,0x200);
	 $file_signature = array(0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1);

	 for( $i=0; $i<count($file_signature); $i++ )
		if( $file_signature[$i] != ord($header[$i]) )
			return 1;

	 $root_entry_block = $this->s2l(substr($header,0x30,4));
	 $num_fat_blocks = $this->s2l(substr($header,0x2c,4));

	 $this->fat = array();
	 for( $i=0; $i<$num_fat_blocks; $i++ ) {
		$fat_block = $this->s2l(substr($header,0x4c+4*$i,4));
		$fat = substr($fc,$fat_block*0x200,0x200);
		if( strlen($fat) < 0x200 ) return 1;
		for( $j=0; $j<0x80; $j++ )
		 $this->fat[] = $this->s2l(substr($fat,$j*4,4));
	 }
	 if( count($this->fat) < $num_fat_blocks )
		return 1;

	 $chain = $this->chain($root_entry_block);
	 if( !is_array($chain) )
		return 1;

	 $this->directory = '';
	 for( $i=0; $i<count($chain); $i++ )
		$this->directory .= substr($fc,$chain[$i]*0x200,0x200);

	 $this->small_fat = array();
	 $sfc = '';
	 $small_block = $this->s2l(substr($header,0x3c,4));
	 if( $small_block != 0xfeffffff )  {
		$root_entry_index = $this->stream('Root Entry');
		if( $root_entry_index < 0 ) $root_entry_index = 0;
		$sdc_start_block = $this->s2l(substr($this->directory,$root_entry_index*0x80+0x74,4));
		$small_data_chain = $this->chain($sdc_start_block);
		if( !is_array($small_data_chain) )
			return 1;

		$this->last_small_block = count($small_data_chain) * 8;

		$schain = $this->chain($small_block);
		if( !is_array($schain) )
			return 1;

		for( $i=0; $i<count($schain); $i++ ) {
		 $small_fat = substr($fc,$schain[$i]*0x200,0x200);
		 if( strlen($small_fat) < 0x200 ) return 1;
		 for( $j=0; $j<0x80; $j++ )
		  $this->small_fat[] = $this->s2l(substr($small_fat,$j*4,4));
		}

		for( $i=0; $i<count($small_data_chain); $i++ )
		 $sfc .= substr($fc,$small_data_chain[$i]*0x200,0x200);
	 }

	 $ibook = $this->stream('Workbook');
	 if( $ibook<0 ) {
		$ibook = $this->stream('Book');
		if( $ibook<0 )
			return 1;
	 }

	 $lbook = $this->s2l(substr($this->directory,$ibook*0x80+0x78,4));
	 if( $lbook == 0 )
		return 1;

	 $this->bd = '';

	 if( $lbook >= 0x1000 ) {
		$chain = $this->chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) )
			return 1;

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($fc,$chain[$i]*0x200,0x200);
	 } else {
		$chain = $this->small_chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) )
			return 1;

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($sfc,$chain[$i]*0x40,0x40);
	 }
	 $this->bd = substr($this->bd,0,$lbook);
	 if( strlen($this->bd) != $lbook )
		return 1;

	 unset($this->fat);
	 unset($this->small_fat);
	 unset($this->directory);
	 unset($header);
	 unset($fc);
	 unset($sfc);

	 $result = $this->explore_workbook();
	 unset($this->bd);
	 return $result;
	}

	function explore_workbook() {

		if( (strlen($this->bd) < 4) ||
		    (strlen($this->bd) < 4+ord($this->bd[2])+256*ord($this->bd[3])) ||
		    (ord($this->bd[0]) != 0x09) )
			return 1;

		$vers = ord($this->bd[1]);
		if( ($vers!=0) && ($vers!=2) && ($vers!=4) && ($vers!=8) )
			return 2;

		if( $vers!=8 ) {
		 $biff_ver = (int)($ver+4)/2;
		} else {
		 if( strlen($this->bd) < 12 ) return 1;
		 switch( ord($this->bd[4])+256*ord($this->bd[5]) ) {
			case 0x0500:
				if( ord($this->bd[0x0a])+256*ord($this->bd[0x0b]) < 1994 ) {
					$biff_ver = 5;
				} else {
					switch(ord( $this->bd[8])+256*ord($this->bd[9]) ) {
					 case 2412:
					 case 3218:
					 case 3321:
						$biff_ver = 5;
						break;
					 default:
						$biff_ver = 7;
						break;
					}
				}
				break;
			case 0x0600:
				$biff_ver = 8;
				break;
			default:
				return 2;
		 }
		}

		$this->biff_version = $biff_ver;
		if( $biff_ver < 5 ) return 2;

		$ofs = 4+ord($this->bd[2])+256*ord($this->bd[3]);
		$this->worksheet = array();
		$this->sst = array();
		$this->xf = array();
		$this->font = array();
		$this->format = array();
		$this->palette = array();
		$this->link = array();

		$ws_offsets = array();
		$this->date1904 = 0;
		$sheet_count = 0;
		while( (ord($this->bd[$ofs])!=0x0a) && ($ofs<strlen($this->bd)) ) {

		 switch (ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8)) {

		  // 1904
		  case 0x0022:
			$this->date1904 = ord($this->bd[$ofs+4]) & 1;
			break;

		  // FONT
		  case 0x0031:
			$ind = count($this->font);
			$this->font[$ind]['height'] = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$this->font[$ind]['italic'] = (boolean)(ord($this->bd[$ofs+6]) & 2);
			$this->font[$ind]['strike'] = (boolean)(ord($this->bd[$ofs+6]) & 8);
			$this->font[$ind]['pal_ind'] = (ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8))-8;
			$this->font[$ind]['bold'] = ord($this->bd[$ofs+10])|(ord($this->bd[$ofs+11])<<8);
			$script = ord($this->bd[$ofs+12]);
			if( $script > 2 ) $script = 0;
			$this->font[$ind]['script'] = $script;
			$this->font[$ind]['underline'] = ord($this->bd[$ofs+14]);

			if( $biff_ver < 8 ) {
			 $len = ord($this->bd[$ofs+18]);
			 $str = substr($this->bd,$ofs+19,$len);

			 if( strlen($str) != $len )
				return 1;

			 $this->font[$ind]['name'] = chr(0).$str;
			} else {
			 $len = ord($this->bd[$ofs+18]);

			 if( ord($this->bd[$ofs+19]) & 1 ) {
			  $str = substr($this->bd,$ofs+20,$len*2);

			  if( strlen($str) != $len*2 )
				return 1;

			  $this->font[$ind]['name'] = chr(1).$str;
			 } else {
			  $str = substr($this->bd,$ofs+20,$len);

			  if( strlen($str) != $len )
				return 1;

			  $this->font[$ind]['name'] = chr(0).$str;
			 }
			}

			break;

		  // PALETTE
		  case 0x0092:
			$count = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			for( $i=0; $i<$count; $i++ ) {
				$c['red'] = ord($this->bd[$ofs+6+$i*4]);
				$c['green'] = ord($this->bd[$ofs+7+$i*4]);
				$c['blue'] = ord($this->bd[$ofs+8+$i*4]);

				$red = dechex($c['red']);
				if( strlen($red) < 2 )
					$red = '0'.$red;
				$green = dechex($c['green']);
				if( strlen($green) < 2 )
					$green = '0'.$green;
				$blue = dechex($c['blue']);
				if( strlen($blue) < 2 )
					$blue = '0'.$blue;

				$c['html'] = '#'.$red.$green.$blue;

				$this->palette[] = $c;
			}

			break;

		  // XF
		  case 0x00e0:
			if( $biff_ver < 8 ) {
				$used_attr = ord($this->bd[$ofs+11]);
				$bgcolor = ord($this->bd[$ofs+12]) & 0x7F;
			} else {
				$used_attr = ord($this->bd[$ofs+13]);
				$bgcolor = ord($this->bd[$ofs+22]) & 0x7F;
			}

			$this->xf['font'][] = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);
			$this->xf['format'][] = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);
			$this->xf['parent'][] = (ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8)) >> 4;
			$this->xf['align'][] = ord($this->bd[$ofs+10]) & 0x7f;

			$this->xf['bgcolor'][] = $bgcolor-8;
			$style = (ord($this->bd[$ofs+8]) & 4) >> 2;
			$this->xf['style'][] = $style;

			if( $style ) {
				$used_attr = $used_attr ^ 0xff;
			}
			$this->xf['used_attr'][] = $used_attr;

			break;

		  // BOUNDSHEET
		  case 0x0085:
			$ws_offsets[$sheet_count] = $this->s2l(substr($this->bd,$ofs+4,4));
			$opts = ord($this->bd[$ofs+8])|(ord($this->bd[$ofs+9])<<8);

			$hidden = $opts & 3;
			$this->worksheet[$sheet_count]['hidden'] = (($hidden==1) || ($hidden==2));
			$this->worksheet[$sheet_count]['type'] = $opts >> 8;

			if( $biff_ver < 8 ) {
			 $this->worksheet[$sheet_count]['title'] = chr(0).substr($this->bd,$ofs+11,ord($this->bd[$ofs+10]));
			} else {
			 $this->worksheet[$sheet_count]['title'] =
			    chr(ord($this->bd[$ofs+11]) & 1).
			    substr(
				$this->bd,
				$ofs+12,
				ord($this->bd[$ofs+10])*(1+(ord($this->bd[$ofs+11]) & 1))
			    );
			}

			$sheet_count++;
			break;

		  // SST
		  case 0x00fc:
			if( $biff_ver < 8 ) break;

			$sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
			$count = $this->s2l(substr($this->bd,$ofs+8,4));
			$sofs = $ofs+12;

			while( $count>0 ) {
			 $str = chr(0);
			 $ln = ord($this->bd[$sofs])|(ord($this->bd[$sofs+1])<<8);

			 $fln = $ln;
			 $uc = ord($this->bd[$sofs+2]) & 1;
			 $rt = 0;
			 $fsz = 0;

			 switch (ord($this->bd[$sofs+2]) & 0x0c) {
			  // Rich-Text with Far-East
			  case 0x0c:
				$rt = ord($this->bd[$sofs+3])|(ord($this->bd[$sofs+4])<<8);
				$fsz = $this->s2l(substr($this->bd,$sofs+5,4));
				if( $sofs+5+$ln*(1+$uc) > $ofs+$sz )
					$ln = (int)($ofs+$sz-$sofs-5)/(1+$uc);
				$str = chr($uc).substr($this->bd,$sofs+9,$ln*(1+$uc));
				$sofs += $ln*(1+$uc)+9;
				break;

			  // Rich-Text
			  case 8:
				$rt = ord($this->bd[$sofs+3])|(ord($this->bd[$sofs+4])<<8);
				if( $sofs+1+$ln*(1+$uc) > $ofs+$sz )
					$ln = (int)($ofs+$sz-$sofs-1)/(1+$uc);
				$str = chr($uc).substr($this->bd,$sofs+5,$ln*(1+$uc));
				$sofs += $ln*(1+$uc)+5;
				break;

			  // Far-East
			  case 4:
				$fsz = $this->s2l(substr($this->bd,$sofs+3,4));
				if( $sofs+3+$ln*(1+$uc) > $ofs+$sz )
					$ln = (int)($ofs+$sz-$sofs-3)/(1+$uc);
				$str = chr($uc).substr($this->bd,$sofs+7,$ln*(1+$uc));
				$sofs += $ln*(1+$uc)+7;
				break;

			  // Compressed or uncompressed unicode
			  case 0:
				if( $sofs+$ln*(1+$uc) > $ofs+1+$sz )
					$ln = (int)($ofs+$sz-$sofs+1)/(1+$uc);
			 	$str = chr($uc).substr($this->bd,$sofs+3,$ln*(1+$uc));
			 	$sofs += $ln*(1+$uc)+3;
				break;
			 } // switch

			 $fln -= $ln;

			 if( $fln > 0 ) {
				if( $sofs < $ofs+4+$sz )
					return 1;
			       while( $fln > 0 ) {

				$ofs += 4+$sz;
				if((ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8))!=0x3c)
					return 1;

				$sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
				$sofs += 4;
				if( $sofs > strlen($this->bd) )
					return 1;

				$uc2 = ord($this->bd[$sofs]) & 1;
				if( ($uc2==1) && ($uc==0) ) {
					$s = chr(1);
					for( $i=1; $i<strlen($str); $i++ )
						$s .= $str[$i].chr(0);
					$str = $s;
				}

				$ln = $fln;

				if( $ln*(1+$uc2) > $sz-1 )
					$ln = (int)($sz-1)/(1+$uc2);

				$s = substr($this->bd,$sofs+1,$ln*(1+$uc2));
				$sofs += $ln*(1+$uc2)+1;

				if( ($uc==1) && ($uc2==0) ) {
					$s2 = '';
					for( $i=0; $i<strlen($s); $i++ )
						$s2 .= $s[$i].chr(0);
					$s = $s2;
					$uc2 = 1;
				}

				$uc = $uc2;
				$str .= $s;
				$fln -= $ln;
			       }
			 }

			 $this->sst[] = $str;

			 $count--;
			 $sofs += 4*$rt+$fsz;

			 if( $sofs > strlen($this->bd) )
				return 1;

			 if( ($sofs >= $ofs+4+$sz) && ($count>0) ) {
				$ofs += 4+$sz;
				if((ord($this->bd[$ofs])|(ord($this->bd[$ofs+1])<<8))!=0x3c)
					return 1;
				$sz = ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8);
				$sofs += 4;
			 }
			} // while
			break;

		  // FORMAT
		  case 0x041e:
			$ind = ord($this->bd[$ofs+4])|(ord($this->bd[$ofs+5])<<8);

			if( $biff_ver < 8 ) {
			 $len = ord($this->bd[$ofs+6]);
			 $str = substr($this->bd,$ofs+7,$len);

			 if( strlen($str) != $len )
				return 1;

			 $this->format[$ind] = chr(0).$str;
			} else {
			 $len = ord($this->bd[$ofs+6])|(ord($this->bd[$ofs+7])<<8);

			 if( ord($this->bd[$ofs+8]) & 1 ) {
			  $str = substr($this->bd,$ofs+9,$len*2);

			  if( strlen($str) != $len*2 )
				return 1;

			  $this->format[$ind] = chr(1).$str;
			 } else {
			  $str = substr($this->bd,$ofs+9,$len);

			  if( strlen($str) != $len )
				return 1;

			  $this->format[$ind] = chr(0).$str;
			 }
			}

			break;

		 } // switch

		 $ofs += 4+(ord($this->bd[$ofs+2])|(ord($this->bd[$ofs+3])<<8));
		} // while

		for( $i=0; $i<count($this->xf['parent']); $i++ ) {
		 if( $this->xf['style'][$i] ) continue;

		 $parent = $this->xf['parent'][$i];

		 // FONT
		 $j = $i;
		 $cnt = 0x1000;
		 while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 8) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		 }

		 if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 8) ) {
			$this->xf['font'][$i] = $this->xf['font'][$j];
		 } else {
			unset($this->xf['font'][$i]);
		 }

		 // FORMAT
		 $j = $i;
		 $cnt = 0x1000;
		 while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 4) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		 }

		 if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 4) ) {
			$this->xf['format'][$i] = $this->xf['format'][$j];
		 } else {
			unset($this->xf['format'][$i]);
		 }

		 // ALIGN
		 $j = $i;
		 $cnt = 0x1000;
		 while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 0x10) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		 }

		 if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 0x10) ) {
			$this->xf['align'][$i] = $this->xf['align'][$j];
		 } else {
			unset($this->xf['align'][$i]);
		 }

		 // BGCOLOR
		 $j = $i;
		 $cnt = 0x1000;
		 while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 0x40) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		 }

		 if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 0x40) ) {
			$this->xf['bgcolor'][$i] = $this->xf['bgcolor'][$j];
		 } else {
			unset($this->xf['bgcolor'][$i]);
		 }

		}

		unset($this->xf['parent']);
		unset($this->xf['style']);
		unset($this->xf['used_attr']);

		if( count($this->palette)==0 ) {
			$pal = array(
				0x000000, 0xFFFFFF, 0xFF0000, 0x00FF00,
				0x0000FF, 0xFFFF00, 0xFF00FF, 0x00FFFF,
				0x800000, 0x008000, 0x000080, 0x808000,
				0x800080, 0x008080, 0xC0C0C0, 0x808080,
				0x9999FF, 0x993366, 0xFFFFCC, 0xCCFFFF,
				0x660066, 0xFF8080, 0x0066CC, 0xCCCCFF,
				0x000080, 0xFF00FF, 0xFFFF00, 0x00FFFF,
				0x800080, 0x800000, 0x008080, 0x0000FF,
				0x00CCFF, 0xCCFFFF, 0xCCFFCC, 0xFFFF99,
				0x99CCFF, 0xFF99CC, 0xCC99FF, 0xFFCC99,
				0x3366FF, 0x33CCCC, 0x99CC00, 0xFFCC00,
				0xFF9900, 0xFF6600, 0x666699, 0x969696,
				0x003366, 0x339966, 0x003300, 0x333300,
				0x993300, 0x993366, 0x333399, 0x333333
			);

			for( $i=0; $i<count($pal); $i++ ) {
				$c['html'] = dechex($pal[$i]);

				$sz = strlen($c['html']);
				for( $j=0; $j<6-$sz; $j++ ) {
					$c['html'] = '0'.$c['html'];
				}

				$c['html'] = '#'.$c['html'];

				$c['red'] = ($pal[$i] >> 16) & 0xFF;
				$c['green'] = ($pal[$i] >> 8) & 0xFF;
				$c['blue'] = $pal[$i] & 0xFF;

				$this->palette[] = $c;
			}
		}

		for( $i=0; $i<count($ws_offsets); $i++ ) {
			$pws = $this->explore_worksheet($ws_offsets[$i]);
			if( is_array($pws) ) {
				$this->worksheet[$i]['last_col'] = $pws['last_col'];
				$this->worksheet[$i]['last_row'] = $pws['last_row'];
				$this->worksheet[$i]['data'] = $pws;
			} else
				return $pws;
		}

		return 0;
	}

}
?>