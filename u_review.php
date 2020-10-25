<?php
// ------------------------------------------------------------------------- //
//                		 XTT - XOOPS TIME TRACKER  		                     //
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
// Last Modified:  10/17/2002 - SEL											 //
// ------------------------------------------------------------------------- //

include 'header.php';
include 'include/xtt_functions.php';

global $xoopsDB, $xoopsConfig, $xoopsTheme;

$xoopsOption['show_rblock'] = 0;

require XOOPS_ROOT_PATH . '/header.php';

$Action = $_GET['Action'];
$CategoryID = $_GET['CategoryID'];

OpenTable();

if ('EDIT' == $Action) {
} elseif ('DEL' == $Action) {
    ?>
    <div align='center'>
        <TABLE class='centerbox'>
            <form method=post action="u_log_time.php" name="delete_log">
                <input type=hidden name='Action' value='confirm_delete'>
                <input type=hidden name='TaskID' value='<?php echo $TaskID ?>'>
                <tr class='bg2'>
                    <td align='center' colspan=2><?php echo _MB_XTT_CONFIRM_DELETE; ?></td>
                </tr>
                <tr class='bg3'>
                    <td valign=center align=center colspan=2><?php echo _MB_XTT_ARE_SURE; ?>
                    </td>
                </tr>
                <tr class='bg3'>
                    <td align='center'>
                        <input type=button value='Cancel' onclick="javascript:document.location = 'u_review.php';">
                    </td>
                    <td align='center'>
                        <input type=submit value='Delete'>
                    </TD>
                </tr>
            </form>
        </TABLE>
    </div>
    <?php
} else {
        $ret = [];

        $UID = $xoopsUser->getVar('uid');

        $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

        $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data') . " where uid = $UID ORDER BY EntryDate DESC";

        $result = $xoopsDB->query($sql); ?>
<div align='center'>
    <table width="100%" class='centerbox'>
        <tr class='bg2'>
            <td align=center><?php echo _MB_XTT_DATE; ?></td>
            <td align=center><?php echo _MB_XTT_CLIENT; ?></td>
            <td align=center><?php echo _MB_XTT_PROJECT; ?></td>
            <td align=center><?php echo _MB_XTT_CATEGORY; ?></td>
            <td align=center><?php echo _MB_XTT_HOURS; ?></td>
            <td align=center><?php echo _MB_XTT_TASK_DETAILS; ?></td>
            <td align=center><?php echo _MB_XTT_BILLABLE; ?></td>
            <td align=center><?php echo _MB_XTT_OPTIONS; ?></td>
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

            echo $myrow['EntryDate'];

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo getClientName($myrow['ClientID']);

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo getProjectName($myrow['ProjectID']);

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo getCategoryName($myrow['CategoryID']);

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo $myrow['Hours'];

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo $myrow['TaskDetails'];

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo translateBillable($myrow['Billable']);

            echo '</td>';

            echo "<td validn='top' align='center'>";

            echo "<a href='javascript:DoEdit(" . $myrow['TaskID'] . ")'>";

            echo "<img src='art/editicon.gif' border='0'></a>";

            echo '&nbsp;&nbsp;';

            echo "<a href='javascript:DoDelete(" . $myrow['TaskID'] . ")'>";

            echo "<img src='art/del.gif' border='0'></a>";

            echo '</td>';

            echo '</tr>';
        } ?>
        <!--    <TR class='bg2'>
            <td colspan=8 valign=Top align='center'>[Total Hours: 1]
            &nbsp;[Hours/Week: 0.33]
            &nbsp;[Hours/Day: 0.07]
            &nbsp;[Hours/Month: 1.33]</td>
            </tr>
            -->
    </table>
    <br><br>
    <SCRIPT>
        function DoEdit(TaskID) {
            document.location = "u_log_time.php?Action=EDIT&TaskID=" + TaskID;
        }

        function DoDelete(TaskID) {
            document.location = "u_review.php?Action=DEL&TaskID=" + TaskID;
        }
    </SCRIPT>
    <?php
    }
    CloseTable();
    require XOOPS_ROOT_PATH . '/footer.php';

    ?>
