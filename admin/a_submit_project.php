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

global $xoopsDB;

include '../../../mainfile.php';

include 'admin_header.php';
if ($xoopsUser) {
    $xoopsModule = XoopsModule::getByDirname('xtt');

    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 3, _NOPERM);

        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/', 3, _NOPERM);

    exit();
}

$Action = $_POST['action'];
$ClientID = $_POST['Client'];
$ProjectName = $_POST['Project'];
$ProjectID = $_POST['ProjectID'];

if (mb_strstr($ProjectName, '<?')) {
    $sMessage = _MA_XTT_INVALID_PROJECT;

    redirect_header('a_edit_projects.php', 3, $sMessage);
} else {
    if ('new' == $Action) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('xtt_projects');

        $sql .= " (ProjectName,ClientID) VALUES ('$ProjectName', $ClientID )";

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_ADDED_PROJECT . ' [' . $ProjectName . ']';

        redirect_header('a_edit_projects.php', 1, $sMessage);
    } elseif ('update' == $Action) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('xtt_projects');

        $sql .= " SET ProjectName = '" . $ProjectName . "'";

        $sql .= ' WHERE ProjectID = ' . $ProjectID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_UPDATED_PROJECT . ' [' . $ProjectName . ']';

        redirect_header('a_edit_projects.php', 1, $sMessage);
    } elseif ('delete' == $Action) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('xtt_projects');

        $sql .= ' WHERE ProjectID = ' . $ProjectID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_DELETED_PROJECT . ' [' . $ProjectName . ']';

        redirect_header('a_edit_projects.php', 1, $sMessage);
    } else {
        redirect_header('a_edit_projects.php', 1, _MA_XTT_UNKNOWN_EDIT);
    }
}
