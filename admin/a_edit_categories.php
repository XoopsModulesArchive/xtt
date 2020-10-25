<?php
// ------------------------------------------------------------------------- //
//                        XTT - XOOPS TIME TRACKER                           //
//                       <http://xtt.bcollar.org>                           //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author of File: Sean Lensborn (http://www.bcollar.com/)                   //
// Last Modified : 10/17/2002 - SEL                                          //
// ------------------------------------------------------------------------- //

include 'admin_header.php';
include 'header.php';
include '../include/xtt_functions.php';

global $xoopsDB, $xoopsConfig, $xoopsTheme;

$Action = $_GET['Action'];
$CategoryID = $_GET['CategoryID'];

xoops_cp_header();

OpenTable();

if ('EDIT' == $Action) {
    ?>
    <div align='center'>
        <TABLE class='centerbox'>
            <form method=post action="a_submit_category.php" name="edit_category">
                <input type=hidden name='action' value='update'>
                <input type=hidden name='CategoryID' value='<?php echo $CategoryID ?>'>
                <tr class='bg2'>
                    <td align='center' colspan=2><?php echo _MA_XTT_EDIT; ?></td>
                </tr>
                <tr class='bg2'>
                    <td valign=center align=center colspan=2><?php echo _MA_XTT_CATEGORY_NAME; ?>:
                        <?php
                        $CategoryName = getCategoryName($CategoryID);

    echo "<input type=text name=Category size=16 value='$CategoryName'>"; ?>
                    </TD>
                </tr>
                <tr class='bg3'>
                    <td align='center'>
                        <input type=button value='<?php echo 'Annuler'; ?>' onclick="javascript:document.location = 'a_edit_categories.php';">
                    </td>
                    <td align='center'>
                        <input type=submit value='<?php echo _MA_XTT_UPDATE; ?>'>
                    </TD>
                </tr>
            </form>
        </TABLE>
    </div>
    <?php
} elseif ('DEL' == $Action) {
        ?>
    <div align='center'>
        <TABLE class='centerbox'>
            <form method=post action="a_submit_category.php" name="edit_category">
                <input type=hidden name='action' value='delete'>
                <input type=hidden name='CategoryID' value='<?php echo $CategoryID ?>'>
                <tr class='bg2'>
                    <td align='center' colspan=2><?php echo _MB_XTT_CONFIRM_DELETE; ?></td>
                </tr>
                <tr class='bg3'>
                    <td valign=center align=center colspan=2><?php echo _MA_XTT_DELETE_CATEGORY; ?> [
                        <?php
                        $CategoryName = getCategoryName($CategoryID);

        echo $CategoryName; ?>
                        ] ?
                    </td>
                </tr>
                <tr class='bg3'>
                    <td align='center'>
                        <input type=button value='<?php echo _MA_XTT_CANCEL; ?>' onclick="javascript:document.location = 'a_edit_categories.php';">
                    </td>
                    <td align='center'>
                        <input type=submit value='<?php echo _MA_XTT_DELETE; ?>'>
                    </TD>
                </tr>
            </form>
        </TABLE>
    </div>

    <?php
    } else {
        $ret = [];

        $sql = 'SELECT CategoryID, CategoryName FROM ' . $xoopsDB->prefix('xtt_categories') . ' ORDER BY CategoryName';

        $result = $xoopsDB->query($sql); ?>
    <table width="100%" class='centerbox'>
        <tr class='bg2'>
            <td align=center><?php echo _MB_XTT_CATEGORY; ?></TD>
            <td align=center><?php echo _MB_XTT_OPTIONS; ?></TD>
        </tr>
        <?php
        $rowCount = 0;

        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
            $rowCount++;

            if (0 == $rowCount % 2) {
                echo "<tr class='bg3'>";
            } else {
                echo "<tr class='bg1'>";
            }

            echo "<td valign='top' align='center'>";

            echo $myrow['CategoryName'];

            echo '</td>';

            echo "<td validn='top' align='center'>";

            echo "<a href='javascript:DoEdit(" . $myrow['CategoryID'] . ")'>";

            echo "<img src='../art/editicon.gif' border='0'></a>";

            echo '&nbsp;&nbsp;';

            echo "<a href='javascript:DoDelete(" . $myrow['CategoryID'] . ")'>";

            echo "<img src='../art/del.gif' border='0'></a>";

            echo '</td>';

            echo '</tr>';
        } ?>
        <form method=post action="a_submit_category.php" name=submitproject>
            <input type=hidden name='action' value='new'>
            <tr class='bg2'>
                <td valign=center align=center colspan=3>
                    <?php echo _MA_XTT_CREATE_CATEGORY; ?>: <input type=text name=Category size=16>
                    &nbsp;<a href="javascript:document.submitproject.submit();"><img src="../art/go.gif" border=0></a>
                </TD>
            </tr>
        </form>
    </table>
    <SCRIPT>
        function DoEdit(CategoryID) {
            document.location = "a_edit_categories.php?Action=EDIT&CategoryID=" + CategoryID;
        }

        function DoDelete(CategoryID) {
            document.location = "a_edit_categories.php?Action=DEL&CategoryID=" + CategoryID;
        }
    </SCRIPT>

    <?php
    }

CloseTable();
xoops_cp_footer();
?>
