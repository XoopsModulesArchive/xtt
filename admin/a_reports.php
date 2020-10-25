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
// Last Modified : 10/26/2002 - SEL											 //
// ------------------------------------------------------------------------- //

include 'admin_header.php';
include 'header.php';
include '../include/xtt_functions.php';

global $xoopsDB, $xoopsConfig, $xoopsTheme;
xoops_cp_header();

// First Grab The Action Type
$Action = $_POST['Action'];
$StartDate = $_POST['StartDate'];
$EndDate = $_POST['EndDate'];

if ('REPORT_PROJECT' == $Action) {
    $Client = $_POST['Client'];

    $Project = $_POST['project'];

    $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

    $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data') . " where ClientID = $Client ";

    $sql .= " AND ProjectID = $Project ";

    $sql .= " AND EntryDate <= '" . $EndDate . "' AND EntryDate >= '" . $StartDate . "' ";

    $sql .= ' ORDER BY EntryDate DESC';

    generateAdminReport($sql);
} elseif ('REPORT_USER' == $Action) {
    $User = $_POST['Users'];

    $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

    $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data') . " where uid = $User ";

    $sql .= " AND EntryDate <= '" . $EndDate . "' AND EntryDate >= '" . $StartDate . "' ";

    $sql .= ' ORDER BY EntryDate DESC';

    generateAdminReport($sql);
} elseif ('REPORT_DAILY' == $Action) {
    $DailyDate = $_POST['DailyDate'];

    $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

    $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data');

    $sql .= " WHERE EntryDate <= '" . $DailyDate . "' AND EntryDate >= '" . $DailyDate . "' ";

    $sql .= ' ORDER BY EntryDate DESC';

    generateAdminReport($sql);
} elseif ('REPORT_CLIENT' == $Action) {
    $Client = $_POST['Client_Single'];

    $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

    $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data') . " where ClientID = $Client ";

    $sql .= " AND EntryDate <= '" . $EndDate . "' AND EntryDate >= '" . $StartDate . "' ";

    $sql .= ' ORDER BY EntryDate DESC';

    generateAdminReport($sql);
} elseif ('REPORT_CATEGORY' == $Action) {
    $Category = $_POST['Category'];

    $sql = 'SELECT TaskID, ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails ';

    $sql .= 'FROM ' . $xoopsDB->prefix('xtt_task_data') . " where CategoryID = $Category ";

    $sql .= " AND EntryDate <= '" . $EndDate . "' AND EntryDate >= '" . $StartDate . "' ";

    $sql .= ' ORDER BY EntryDate DESC';

    generateAdminReport($sql);
} else {
    // We want to just display the options ?>
    <div align='center'>
        <table cellpadding='1'>
            <tr class='bg2'>
                <td>
                    <table cellpadding="1" cellspacing="1">
                        <TR class='bg3'>
                            <TD colspan='3' align='center'>
                                <b><?php echo _MA_XTT_REPORT_TITLE; ?></b><br>
                            </td>
                        </TR>
                        <TR class='bg3'>
                            <TD colspan='3' align='left'>
                                <b><?php echo ''; ?></b>
                            </td>
                        </TR>
                        <form method=post action="a_reports.php" name='logtime'>
                            <TR class='bg1'>
                                <td></td>
                                <TD align='right'>
                                    <?php echo _MA_XTT_START_DATE; ?>:
                                </td>
                                <TD align='left'>
                                    <input type='text' size='12' name='StartDate' value='<?php echo date('Y-m-d'); ?>'>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <TD align='right'>
                                    <?php echo _MA_XTT_END_DATE; ?>:
                                </td>
                                <TD align='left'>
                                    <input type='text' size='12' name='EndDate' value='<?php echo date('Y-m-d'); ?>'>
                                </td>
                            </TR>
                            <TR class='bg3'>
                                <td><input type='radio' name='Action' value='REPORT_PROJECT'></td>
                                <TD align='left' colspan='2'>
                                    <b><?php echo _MA_XTT_SELECT_PROJECT; ?>:</b>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <td align='right'>
                                    <?php chooseClients('Client', 'TRUE'); ?>
                                </td>
                                <td align='left'>
                                    <select name='project'>
                                        <option value=0>N/A
                                    </select>
                                </td>
                            </tr>
                            <TR class='bg3'>
                                <td><input type='radio' name='Action' value='REPORT_USER'></td>
                                <TD align='left' colspan='2'>
                                    <b><?php echo _MA_XTT_SELECT_USER; ?>:</b>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <TD colspan='2' align='center'>
                                    <?php chooseUsers('Users'); ?>
                                </td>
                            </TR>
                            <TR class='bg3'>
                                <td><input type='radio' name='Action' value='REPORT_CATEGORY'></td>
                                <TD align='left' colspan='2'>
                                    <b><?php echo _MA_XTT_SELECT_CATEGORY; ?>:</b>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <TD colspan='2' align='center'>
                                    <?php chooseCategories('Category'); ?>
                                </td>
                            </TR>
                            <TR class='bg3'>
                                <td><input type='radio' name='Action' value='REPORT_CLIENT'></td>
                                <TD align='left' colspan='2'>
                                    <b><?php echo _MA_XTT_SELECT_CLIENT; ?>:</b>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <TD align='center' colspan='2'>
                                    <?php chooseClients('Client_Single', 'FALSE'); ?>
                                </td>
                            </TR>
                            <TR class='bg3'>
                                <td><input type='radio' name='Action' value='REPORT_DAILY'></td>
                                <TD align='left' colspan='2'>
                                    <b><?php echo _MA_XTT_SELECT_DAILY; ?>:<b>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td></td>
                                <TD align='center' colspan='2'>
                                    <input type='text' name='DailyDate' size='12' value='<?php echo date('Y-m-d'); ?>'>
                                </td>
                            </TR>
                            <TR class='bg1'>
                                <td colspan='3' align='center'>
                                    <input type='submit' value='<?php echo _MA_XTT_GET_REPORT; ?>'>
                                </td>
                            </tr>
                        </form>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
generateProjects('logtime.project', 'NewClient');

xoops_cp_footer();
?>
