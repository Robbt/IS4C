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

include('../../config.php');

$page_title = "Fannie : Sync Store";
$header = "Sync Store Operational Tables";
include($FANNIE_ROOT.'src/header.html');

echo "<form action=\"tablesync.php\" method=\"get\">";

echo "<b>Table</b>: <select name=\"tablename\">
	<option>Select a table</option>
	<option>products</option>
	<option>custdata</option>
	<option>employees</option>
	<option>departments</option>
	<option>tenders</option>
</select><br /><br />";

echo "<b>Other table</b>: <input type=\"text\" name=\"othertable\" /><br /><br />";

if ($FANNIE_MASTER_STORE == 'me'){
	echo "<b>Send to</b>: <select name=\"storeNum\">
	<option value=\"\">All Stores</option>";
	for ($i=0;$i<$FANNIE_NUM_STORES;$i++)
		printf('<option value="%d">%s</option>',$i,$FANNIE_STORES[$i]['host']);
	echo "</select><br />";
}
else {
	echo "You are <b>not</b> the master store. You are sending
		this store's table <b>to</b> the master store.
		This store's data will <b>replace</b> the master
		store's data. Be careful.<br />";
}

echo '<input type="submit" value="Send Data" />';
echo "</form>";

include($FANNIE_ROOT.'src/footer.html');

?>
