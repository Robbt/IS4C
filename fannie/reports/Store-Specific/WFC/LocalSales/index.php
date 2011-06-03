<?php
/*******************************************************************************

    Copyright 2011 Whole Foods Co-op

    This file is part of Fannie.

    Fannie is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    Fannie is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in the file license.txt along with IT CORE; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*********************************************************************************/

include('../../../../config.php');
include($FANNIE_ROOT.'src/mysql_connect.php');
include($FANNIE_ROOT.'src/select_dlog.php');

if (isset($_REQUEST['submit'])){
	$d1 = $_REQUEST['date1'];
	$d2 = $_REQUEST['date2'];

	$dlog = select_dtrans($d1,$d2);

	if (isset($_REQUEST['excel'])){
		header("Content-Disposition: inline; filename=customers_{$d1}_{$d2}.xls");
		header("Content-type: application/vnd.ms-excel; name='excel'");
	}
	else{
		printf("<a href=index.php?date1=%s&date2=%s&submit=yes&excel=yes>Save to Excel</a>",
			$d1,$d2);
	}

	$sales = "SELECT t.department,d.dept_name,s.superID,n.super_name,
			sum(case when numflag=1 then total else 0 end) as localSales,
			sum(total) as allSales
			FROM $dlog as t inner join departments as d
			ON t.department=d.dept_no LEFT JOIN 
			MasterSuperDepts AS s ON s.dept_ID=t.department
			LEFT JOIN SuperDeptNames AS n ON s.superID=n.superID
			WHERE 
			datetime BETWEEN '$d1 00:00:00' AND '$d2 23:59:59'
			and trans_type = 'I'
			and s.superID > 0
			AND trans_status NOT IN ('X','Z')
			AND emp_no <> 9999 and register_no <> 99
			AND upc Not IN ('RRR','DISCOUNT')
			group by t.department,d.dept_name,s.superID,n.super_name
			order by s.superID,t.department";
	//echo $sales;
	$result = $dbc->query($sales);
	$sID = -1;
	$sname = "";
	$sttl = 0;
	$slocal = 0;
	echo '<table cellspacing="0" cellpadding="4" border="1">';
	while($row = $dbc->fetch_row($result)){
		if ($sID != $row['superID']){
			if ($sID != -1){
				printf('<tr><th>Ttl</th><th>%s</th>
					<th>$%.2f</th><th>$%.2f</th>
					<th>%.2f%%</th></tr>',
					$sname,$slocal,$sttl,
					100*($slocal/$sttl));
			}
			$sID = $row['superID'];
			$sname = $row['super_name'];
			$sttl = 0;
			$slocal = 0;
		}
		if ($row['allSales'] == 0) $row['allSales']=1; // no div by zero
		printf('<tr><td>%d</td><td>%s</td><td>$%.2f</td>
			<td>$%.2f</td><td>%.2f%%</td></tr>',
			$row['department'],$row['dept_name'],
			$row['localSales'],$row['allSales'],
			100*($row['localSales']/$row['allSales'])
		);
		$slocal += $row['localSales'];
		$sttl += $row['allSales'];
	}
	printf('<tr><th>Ttl</th><th>%s</th>
		<th>$%.2f</th><th>$%.2f</th>
		<th>%.2f%%</th></tr>',
		$sname,$slocal,$sttl,
		100*($slocal/$sttl));

	echo '</table>';

			
}
else {

$page_title = "Fannie : Local Sales Report";
$header = "Local Sales Report";
include($FANNIE_ROOT.'src/header.html');
$lastMonday = "";
$lastSunday = "";

$ts = mktime(0,0,0,date("n"),date("j")-1,date("Y"));
while($lastMonday == "" || $lastSunday == ""){
	if (date("w",$ts) == 1 && $lastSunday != "")
		$lastMonday = date("Y-m-d",$ts);
	elseif(date("w",$ts) == 0)
		$lastSunday = date("Y-m-d",$ts);
	$ts = mktime(0,0,0,date("n",$ts),date("j",$ts)-1,date("Y",$ts));	
}
?>
<script type="text/javascript"
	src="<?php echo $FANNIE_URL; ?>src/CalendarControl.js">
</script>
<form action=index.php method=get>
<table cellspacing=4 cellpadding=4>
<tr>
<th>Start Date</th>
<td><input type=text name=date1 onclick="showCalendarControl(this);" value="<?php echo $lastMonday; ?>" /></td>
</tr><tr>
<th>End Date</th>
<td><input type=text name=date2 onclick="showCalendarControl(this);" value="<?php echo $lastSunday; ?>" /></td>
</tr><tr>
<td>Excel <input type=checkbox name=excel /></td>
<td><input type=submit name=submit value="Submit" /></td>
</tr>
</table>
</form>
<?php
include($FANNIE_ROOT.'src/footer.html');
}
?>
