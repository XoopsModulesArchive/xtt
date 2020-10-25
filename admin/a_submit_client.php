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

$ClientType = $_POST['client_type'];
$ClientName = $_POST['Client'];
$ClientID = $_POST['ClientID'];

if (mb_strstr($ClientName, '<?')) {
    $sMessage = _MA_XTT_INVALID_CLIENT;

    redirect_header('a_edit_clients.php', 3, $sMessage);
} else {
    if ('new' == $ClientType) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('xtt_clients');

        $sql .= " (ClientName) VALUES ('$ClientName')";

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_ADDED_CLIENT . ' [' . $ClientName . ']';

        redirect_header('a_edit_clients.php', 1, $sMessage);
    } elseif ('update' == $ClientType) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('xtt_clients');

        $sql .= " SET ClientName = '" . $ClientName . "'";

        $sql .= ' WHERE ClientID = ' . $ClientID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_UPDATED_CLIENT . ' [' . $ClientName . ']';

        redirect_header('a_edit_clients.php', 1, $sMessage);
    } elseif ('delete' == $ClientType) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('xtt_clients');

        $sql .= ' WHERE ClientID = ' . $ClientID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_DELETED_CLIENT . ' [' . $ClientName . ']';

        redirect_header('a_edit_clients.php', 1, $sMessage);
    } else {
        redirect_header('a_edit_clients.php', 1, 'Unknown Edit Type');
    }
}
