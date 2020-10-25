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

$modversion['name'] = 'XTT Time Tracker';
$modversion['version'] = 1.00;
$modversion['description'] = 'XTT is time tracking software aimed at consultants.';
$modversion['author'] = 'Sean Lensborn<br>( http://www.bcollar.com/ )';
$modversion['credits'] = 'Bluecollar Enterprises, Inc.';
$modversion['help'] = 'index.html';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'art/bcollar_logo.jpg';
$modversion['dirname'] = 'xtt';

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/xtt_mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'xtt_categories';
$modversion['tables'][1] = 'xtt_clients';
$modversion['tables'][2] = 'xtt_projects';
$modversion['tables'][3] = 'xtt_task_data';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Blocks
$modversion['blocks'][1]['file'] = 'user_menu.php';
$modversion['blocks'][1]['name'] = 'XTT';
$modversion['blocks'][1]['description'] = 'Time Tracker Menu';
$modversion['blocks'][1]['show_func'] = 'b_xtt_show';

// Menu
$modversion['hasMain'] = 0;
