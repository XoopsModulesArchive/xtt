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

function getClientName($ClientID)
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme;

    $ret = [];

    $sql = 'SELECT ClientName FROM ' . $xoopsDB->prefix('xtt_clients') . ' WHERE ClientID = ' . $ClientID;

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    $tmp = $myrow['ClientName'];

    if ('' == $tmp) {
        $tmp = 'Unknown';
    }

    return $tmp;
}

function getProjectName($ProjectID)
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme;

    $ret = [];

    $sql = 'SELECT ProjectName FROM ' . $xoopsDB->prefix('xtt_projects') . ' WHERE ProjectID = ' . $ProjectID;

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    $tmp = $myrow['ProjectName'];

    if ('' == $tmp) {
        $tmp = _MB_XTT_UNKNOWN;
    }

    return $tmp;
}

function getTaskOwner($TaskID)
{
    global $xoopsDB, $xoopsConfig, $xoopsTheme;

    $ret = [];

    $sql = 'SELECT uid FROM ' . $xoopsDB->prefix('xtt_task_data') . ' WHERE TaskID = ' . $TaskID;

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    $tmp = $myrow['uid'];

    if ('' == $tmp) {
        $tmp = -1;
    }

    return $tmp;
}

function translateBillable($Billable)
{
    if (1 == $Billable) {
        return _MB_XTT_YES;
    }

    return _MB_XTT_NO;
}

function getCategoryName($CategoryID)
{
    global $xoopsDB;

    $ret = [];

    $sql = 'SELECT CategoryName FROM ' . $xoopsDB->prefix('xtt_categories') . ' WHERE CategoryID = ' . $CategoryID;

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    $tmp = $myrow['CategoryName'];

    if ('' == $tmp) {
        $tmp = _MB_XTT_UNKNOWN;
    }

    return $tmp;
}

function getUserName($UID)
{
    global $xoopsDB;

    $ret = [];

    $sql = 'SELECT uname FROM ' . $xoopsDB->prefix('users') . ' WHERE uid = ' . $UID;

    $result = $xoopsDB->query($sql);

    $myrow = $xoopsDB->fetchArray($result);

    $tmp = $myrow['uname'];

    if ('' == $tmp) {
        $tmp = _MB_XTT_UNKNOWN;
    }

    return $tmp;
}

function chooseClients($SelectName, $useJava)
{
    global $xoopsDB;

    $sql = 'SELECT ClientName, ClientID FROM ' . $xoopsDB->prefix('xtt_clients') . ' ORDER BY ClientName';

    $result_choose = $xoopsDB->query($sql);

    echo "\n<SELECT NAME='" . $SelectName . "'";

    if ('TRUE' == $useJava) {
        echo " onChange='javascript:NewClient( logtime.Client.selectedIndex );'";
    }

    echo '>';

    if ('TRUE' == $useJava) {
        echo "\n<option value='0'>" . _MB_XTT_CHOOSE_CLIENT . "\n";
    }

    while (false !== ($client_row = $xoopsDB->fetchArray($result_choose))) {
        echo "\n<option value='" . $client_row['ClientID'] . "'>";

        echo $client_row['ClientName'];
    }

    echo "\n</SELECT>\n";
}

function chooseCategories($SelectName)
{
    global $xoopsDB;

    $sql = 'SELECT CategoryName, CategoryID FROM ' . $xoopsDB->prefix('xtt_categories') . ' ORDER BY CategoryName';

    $result_choose = $xoopsDB->query($sql);

    echo "<SELECT NAME='" . $SelectName . "'>";

    while (false !== ($client_row = $xoopsDB->fetchArray($result_choose))) {
        echo "<option value='" . $client_row['CategoryID'] . "'>";

        echo $client_row['CategoryName'];
    }

    echo '</SELECT>';
}

function chooseUsers($SelectName)
{
    global $xoopsDB;

    $sql = 'SELECT uname, uid FROM ' . $xoopsDB->prefix('users');

    $result_choose = $xoopsDB->query($sql);

    echo "<SELECT NAME='" . $SelectName . "'>";

    while (false !== ($client_row = $xoopsDB->fetchArray($result_choose))) {
        echo "<option value='" . $client_row['uid'] . "'>";

        echo $client_row['uname'];
    }

    echo '</SELECT>';
}

function generateProjects($formName, $functionName)
{
    echo "<SCRIPT>\n";

    echo "\tfunction " . $functionName . "( iClient )\n\t{\n";

    echo "\t\tvar logtime = document.forms[\"logtime\"];\n";

    echo "\t\tswitch( iClient )\n\t\t{\n";

    global $xoopsDB;

    $sql = 'SELECT ClientName, ClientID FROM ' . $xoopsDB->prefix('xtt_clients') . ' ORDER BY ClientName';

    $result_choose = $xoopsDB->query($sql);

    $clientCount = 0;

    while (false !== ($client_row = $xoopsDB->fetchArray($result_choose))) {
        $ClientName = $client_row['ClientName'];

        $ClientID = $client_row['ClientID'];

        $clientCount++;

        echo "\t\tcase " . $clientCount . ":\n";

        echo "\t\t// Client " . $ClientName . "\n";

        $inner_sql = 'SELECT ProjectName, ProjectID FROM ' . $xoopsDB->prefix('xtt_projects');

        $inner_sql .= ' WHERE ClientID = ' . $ClientID . ' ORDER BY ProjectName';

        $result_proj = $xoopsDB->query($inner_sql);

        $rowCount = 0;

        $projectCount = $xoopsDB->getRowsNum($result_proj);

        echo "\t\t\t" . $formName . '.length=' . $projectCount . ";\n";

        while (false !== ($project_row = $xoopsDB->fetchArray($result_proj))) {
            $ProjectName = $project_row['ProjectName'];

            $ProjectID = $project_row['ProjectID'];

            echo "\t\t\t" . $formName . '.options[' . $rowCount . "].text = '" . $ProjectName . "';\n";

            echo "\t\t\t" . $formName . '.options[' . $rowCount . "].value = '" . $ProjectID . "';\n";

            $rowCount++;
        }

        echo "\t\t\tbreak;\n";
    }

    echo "\n\t\tdefault:\n";

    echo "\t\t\t" . $formName . ".length=1;\n";

    echo "\t\t\t" . $formName . ".options[0].value = '3';\n";

    echo "\t\t}\n";

    echo "\t}\n";

    echo "</SCRIPT>\n";
}

function generateAdminReport($sql_statement)
{
    global $xoopsDB;

    $result = $xoopsDB->query($sql_statement); ?>
<div align='center'>
    <table width="100%" class='centerbox'>
        <tr class='bg2'>
            <td align=center><?php echo _MB_XTT_DATE; ?></td>
            <td align=center><?php echo _MB_XTT_USER; ?></td>
            <td align=center><?php echo _MB_XTT_CLIENT; ?></td>
            <td align=center><?php echo _MB_XTT_PROJECT; ?></td>
            <td align=center><?php echo _MB_XTT_CATEGORY; ?></td>
            <td align=center><?php echo _MB_XTT_HOURS; ?></td>
            <td align=center><?php echo _MB_XTT_TASK_DETAILS; ?></td>
            <td align=center><?php echo _MB_XTT_BILLABLE; ?></td>
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

        echo getUserName($myrow['uid']);

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

        echo '</tr>';
    }
}

        ?>
