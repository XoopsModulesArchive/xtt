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

include '../include/xtt_functions.php';
include 'admin_header.php';
include 'header.php';

global $xoopsDB, $xoopsConfig, $xoopsTheme;

$Action = $_GET['Action'];
$ProjectID = $_GET['ProjectID'];

xoops_cp_header();

OpenTable();

if ('EDIT' == $Action) {
    ?>
    <div align='center'>
        <TABLE class='centerbox'>
            <form method=post action="a_submit_project.php" name="edit_project">
                <input type=hidden name='action' value='update'>
                <input type=hidden name='ProjectID' value='<?php echo $ProjectID ?>'>
                <tr class='bg2'>
                    <td align='center' colspan=2><?php echo _MA_XTT_EDIT; ?></td>
                </tr>
                <tr class='bg2'>
                    <td valign=center align=center colspan=2><?php echo _MA_XTT_PROJECT_NAME; ?>:
                        <?php
                        $ProjectName = getProjectName($ProjectID);

    echo "<input type=text name=Project size=16 value='$ProjectName'>"; ?>
                    </TD>
                </tr>
                <tr class='bg3'>
                    <td align='center'>
                        <input type=button value='<?php echo _MA_XTT_CANCEL; ?>' onclick="javascript:document.location = 'a_edit_projects.php';">
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
            <form method=post action="a_submit_project.php" name="edit_project">
                <input type=hidden name='action' value='delete'>
                <input type=hidden name='ProjectID' value='<?php echo $ProjectID; ?>'>
                <tr class='bg2'>
                    <td align='center' colspan=2><?php echo _MB_XTT_CONFIRM_DELETE; ?></td>
                </tr>
                <tr class='bg3'>
                    <td valign=center align=center colspan=2><?php echo _MB_XTT_DELETE_PROJECT; ?> [
                        <?php
                        $ProjectName = getProjectName($ProjectID);

        echo $ProjectName; ?>
                        ] ?
                    </td>
                </tr>
                <tr class='bg3'>
                    <td align='center'>
                        <input type=button value='<?php echo _MA_XTT_CANCEL; ?>' onclick="javascript:document.location = 'a_edit_projects.php';">
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

        $sql = 'SELECT ProjectID, ClientID, ProjectName FROM ' . $xoopsDB->prefix('xtt_projects') . ' ORDER BY ClientID, ProjectName';

        $result = $xoopsDB->query($sql); ?>
    <table width="100%" class='centerbox'>
        <tr class='bg2'>
            <td align=center><?php echo _MB_XTT_CLIENT; ?></TD>
            <td align=center><?php echo _MB_XTT_PROJECT; ?></TD>
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

            echo getClientName($myrow['ClientID']);

            echo '</td>';

            echo "<td valign='top' align='center'>";

            echo $myrow['ProjectName'];

            echo '</td>';

            echo "<td validn='top' align='center'>";

            echo "<a href='javascript:DoEdit(" . $myrow['ProjectID'] . ")'>";

            echo "<img src='../art/editicon.gif' border='0'></a>";

            echo '&nbsp;&nbsp;';

            echo "<a href='javascript:DoDelete(" . $myrow['ProjectID'] . ")'>";

            echo "<img src='../art/del.gif' border='0'></a>";

            echo '</td>';

            echo '</tr>';
        } ?>
        <form method=post action="a_submit_project.php" name=submitproject>
            <input type=hidden name='action' value='new'>
            <tr class='bg2'>
                <td valign=center align=center colspan=3><?php echo _MA_XTT_CREATE_PROJECT; ?>:
                    <?php
                    chooseClients('Client', 'FALSE'); ?>
                    <input type=text name=Project size=16>
                    &nbsp;<a href="javascript:document.submitproject.submit();"><img src="../art/go.gif" border=0></a>
                </TD>
            </tr>
        </form>

    </table>
    <SCRIPT>
        function DoEdit(ProjectID) {
            document.location = "a_edit_projects.php?Action=EDIT&ProjectID=" + ProjectID;
        }

        function DoDelete(ProjectID) {
            document.location = "a_edit_projects.php?Action=DEL&ProjectID=" + ProjectID;
        }
    </SCRIPT>

    <?php
    }

CloseTable();
xoops_cp_footer();

?>
