<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file keeps track of upgrades to the speedreading module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod
 * @subpackage speedreading
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute speedreading upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_speedreading_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

    // And upgrade begins here. For each one, you'll need one
    // block of code similar to the next one. Please, delete
    // this comment lines once this file start handling proper
    // upgrade code.




    


    if ($oldversion < 2012022512) {

        // Define field timetaken to be added to sr_article
        $table = new xmldb_table('sr_article');
        $field = new xmldb_field('timetaken', XMLDB_TYPE_INTEGER, '5', null, null, null, null, 'numberofwords');

        // Conditionally launch add field timetaken
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // speedreading savepoint reached
        upgrade_mod_savepoint(true, 2012022512, 'speedreading');
    }






    // Final return of upgrade result (true, all went good) to Moodle.
    return true;
}
