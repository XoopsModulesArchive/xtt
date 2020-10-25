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
// Last Modified : 10/17/2002 - SEL											 //
// ------------------------------------------------------------------------- //

include 'header.php';
include 'include/xtt_functions.php';
require XOOPS_ROOT_PATH . '/header.php';
global $xoopsDB, $xoopsConfig, $xoopsTheme;

$Action = $_POST['Action'];
$TaskID = $_POST['TaskID'];
$UID = $xoopsUser->getVar('uid');

if ('' == $Action) {
    $Action = $_GET['Action'];
}

if ('' == $TaskID) {
    $TaskID = $_GET['TaskID'];
}

if ('EDIT' == $Action) {
    redirect_header('u_review.php', 2, _MB_XTT_NOT_IMP);
} elseif ('confirm_delete' == $Action) {
    $TaskUID = getTaskOwner($TaskID);

    $dUID = (int)$UID;

    $dTaskUID = (int)$TaskUID;

    if (dUID == -1 || dTaskUID == -1 || $dTaskUID != $dUID) {
        redirect_header('u_review.php', 3, _MB_XTT_NO_DELETE);
    } else {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('xtt_task_data');

        $sql .= ' WHERE TaskID = ' . $TaskID;

        $xoopsDB->query($sql);

        $sMessage = 'Deleted Your Task';

        redirect_header('u_review.php', 1, $sMessage);
    }
} elseif ('new' == $Action) {
    $EntryDate = $_POST['date1'];

    $Hours = $_POST['hours'];

    $ClientID = $_POST['Client'];

    $CategoryID = $_POST['Category'];

    $ProjectID = $_POST['project'];

    $Details = $_POST['details'];

    $Billable = $_POST['Billable'];

    if ('on' == $Billable) {
        $Billable = 1;
    } else {
        $Billable = 0;
    }

    if (0 == $ClientID || 0 == $CategoryID || 0 == $ProjectID) {
        redirect_header('u_log_time.php', 3, _MB_XTT_CHOOSE_CLIENT);
    } elseif (mb_strstr($Details, '<?') || mb_strstr($Hours, '<?') || mb_strstr($EntryDate, '<?')) {
        redirect_header('u_log_time.php', 3, _MB_XTT_SPECIAL_CHAR);
    } else {
        // We're probably good here, though we will want to check for more

        // situations later..

        $sql = 'INSERT INTO ' . $xoopsDB->prefix('xtt_task_data');

        $sql .= ' ( ClientID, ProjectID, CategoryID, uid, Billable, Hours, EntryDate, TaskDetails )';

        $sql .= " VALUES ( $ClientID, $ProjectID, $CategoryID, $UID, $Billable, $Hours,";

        $sql .= " '$EntryDate', '$Details' )";

        $xoopsDB->query($sql);

        redirect_header('u_log_time.php', 1, _MB_XTT_INSERT_RECORD);
    }
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php'; ?>
    <script language='javascript' src='include/popcalendar.js'></script>
    <?php

    require XOOPS_ROOT_PATH . '/header.php'; ?>
    <div align='center'>
        <FORM method=post name="logtime" action="u_log_time.php">
            <input type=hidden name='Action' value='new'>

            <table width="100%" class='centerbox'>
                <TR>
                    <TD align=center colspan=4>
                        <div class='sideboxtitle'>
                            <?php echo _MB_XTT_ENTER_RECORD; ?>
                        </div>
                    </td>
                </TR>

                <TR>
                    <TD align=right class='sideboxcontent'>
                        <?php echo _MB_XTT_CLIENT; ?>
                    </td>
                    <td align=left>
                        <?php
                        chooseClients('Client', 'TRUE'); ?>
                    </td>
                    <TD class='sideboxcontent' align=right>
                        <?php echo _MB_XTT_PROJECT; ?>
                    </td>
                    <td align=left>
                        <select name=project>
                            <option value=0>N/A
                        </select>

                    </td>
                </TR>
                <TR>
                    <TD align=right class='sideboxcontent'>
                        <?php echo _MB_XTT_CATEGORY; ?>
                    </td>
                    <td align=left>
                        <?php
                        chooseCategories('Category'); ?>
                    </td>
                    <TD align=right class='sideboxcontent'>
                        <?php echo _MB_XTT_BILLABLE; ?>
                    </td>
                    <TD align=left class='sideboxcontent'>
                        <INPUT TYPE='Checkbox' Name='Billable' checked>
                    </td>
                </tr>

                <TR>
                    <TD align=right class='sideboxcontent'>
                        <?php echo _MB_XTT_DATE; ?>
                    </td>
                    <TD align=left>

                        <input type=text size=12 name=date1 value="<?php echo date('Y-m-d'); ?>">

                        <script language='javascript'>
                            <!--
                            if (!document.layers) {
                                document.write("<img src='art/btn_calendar.gif' onclick='popUpCalendar(this, logtime.date1, \"yyyy-mm-dd\")' style='cursor:pointer'>")
                            }
                            //-->
                        </script>
                    </td>
                    <TD align=right class='sideboxcontent'>
                        <?php echo _MB_XTT_HOURS; ?>
                    </td>
                    <TD align=left>
                        <input type=datetime name=hours size=8 value=>
                    </td>
                </TR>

                <TR>
                    <TD align=center colspan=4 class='sideboxcontent'>
                        <?php echo _MB_XTT_TASK_DETAILS; ?>
                    </td>
                </tr>
                <TR>
                    <TD align=center colspan=4>
                        <textarea name=details rows="4" name="S1" cols="75%"></textarea><br>
                    </td>
                </TR>

                <TR>
                    <TD align=right colspan=4>
                        <br><INPUT TYPE=SUBMIT Value="Submit">
                    </td>
                </TR>

            </table>
    </div>

    <?php
    generateProjects('logtime.project', 'NewClient');
}

require XOOPS_ROOT_PATH . '/footer.php';

?>
