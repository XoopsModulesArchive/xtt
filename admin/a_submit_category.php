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
$CategoryName = $_POST['Category'];
$CategoryID = $_POST['CategoryID'];

if (mb_strstr($CategoryName, '<?')) {
    $sMessage = _MA_XTT_INVALID_CATEGORY;

    redirect_header('a_edit_categories.php', 3, $sMessage);
} else {
    if ('new' == $Action) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('xtt_categories');

        $sql .= " (CategoryName) VALUES ('$CategoryName')";

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_ADDED_CATEGORY . ' [' . $CategoryName . ']';

        redirect_header('a_edit_categories.php', 1, $sMessage);
    } elseif ('update' == $Action) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('xtt_categories');

        $sql .= " SET CategoryName = '" . $CategoryName . "'";

        $sql .= ' WHERE CategoryID = ' . $CategoryID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_UPDATED_CATEGORY . ' [' . $CategoryName . ']';

        redirect_header('a_edit_categories.php', 1, $sMessage);
    } elseif ('delete' == $Action) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('xtt_categories');

        $sql .= ' WHERE CategoryID = ' . $CategoryID;

        $xoopsDB->query($sql);

        $sMessage = _MA_XTT_DELETED_CATEGORY . ' [' . $CategoryName . ']';

        redirect_header('a_edit_categories.php', 1, $sMessage);
    } else {
        redirect_header('a_edit_categorys.php', 1, 'Unknown Edit Type');
    }
}
