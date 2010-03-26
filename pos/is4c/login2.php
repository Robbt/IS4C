<?php
/*******************************************************************************

    Copyright 2001, 2004 Wedge Community Co-op

    This file is part of IS4C.

    IS4C is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    IS4C is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in the file license.txt along with IS4C; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*********************************************************************************/

    if (!function_exists("pDataConnect")) include("connect.php");
    if (!function_exists("tDataConnect")) include("connect.php");
    if (!function_exists("setglobalflags")) include("loadconfig.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script type='text/javascript'>
            function closeFrames() {
                window.top.close();
            }
        </script>
    </head>

    <body onLoad='document.form.reginput.focus();'>
        <table border='0' cellpadding='0' cellspacing='0'>
            <tr>
                <td height='40' width='100' valign='center' bgcolor='#FFCC00' align='center'>
                    <font face='arial' size='-1'><b>I S 4 C</b></font>
                </td>
                <td height='40' width='540' valign='bottom' align='right'>
                    <font face='arial' size='-2'>
                        <b>&nbsp; P H P &nbsp; D E V E L O P M E N T &nbsp; V E R S I O N &nbsp; 1 .0 .0</b>
                    </font>
                </td>
            </tr>
            <tr>
                <td height='1' width='640' colspan='2' bgcolor='black'></td>
            </tr>
            <tr>
                <td height='20' width='100' align='center' bgcolor='#004080'>
                    <font face='arial' size='-1' color='white'><B>W E L C O M E</B></font>
                </td>
                <td></td>
            </tr>
            <tr>
                <td height='300' width='640' align='center' colspan='2' valign='center'>
                    <table border='0' cellpadding='0' cellspacing='0'>
                        <tr>
                            <td bgcolor='#004080' height='150' width='260' valign='center' align='center'>
                                <center>
                                    <br />
                                    <font face='arial' color='white'>
                                        <b>log in</b>
                                        <form name='form' method='post' autocomplete='off' action='authenticate.php'>
                                            <input Type='password' name='reginput' size='20' tabindex='0' onblur='document.form.reginput.focus();' />
                                            <p>
                                                <font face='arial' color='white'>Please enter your password</font>
                                            </p>
                                        </form>
                                    </font>
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='640' colspan='2' align='right' valign='top'>
                    <font size='-2' face='arial'>EXIT</font>
                    <?php
                        if ($_SESSION["browserOnly"] == 1) {
                            echo "<a href='#' onclick='window.top.close(); return false;' ";
                        }
                        else {
                            echo "<a href='bye.html' ";
                        }
                    ?> onMouseOver="document.exit.src='/graphics/switchred2.gif';" onMouseOut="document.exit.src='/graphics/switchblue2.gif';">
                    <img name='exit' border='0' src='/graphics/switchblue2.gif' alt='Exit' /></a>
                </td>
            </tr>
        </table>
        <form name='hidden'>
            <input type='hidden' name='alert' value='noScan'>
        </form>

    </body>

<?php
    getsubtotals();

    function load() {
        $query_member = "SELECT * FROM custdata WHERE CardNo = '205203'";
        $query_product = "SELECT * FROM products WHERE upc = '0000000000090'";
        $query_localtemptrans = "SELECT * FROM localtemptrans";

        $bdat = pDataConnect();
        $result = sql_query($query_product, $bdat);
        $result_2 = sql_query($query_member, $bdat);
        sql_close($bdat);

        $trans = tDataConnect();
        $result_3 = sql_query($query_localtemptrans, $trans);
        sql_close($trans);
    }
?>