<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_format_grid_upgrade($oldversion = 0) {
    global $DB;

    $dbman = $DB->get_manager();
        
    if ($oldversion < 2011041802) {
        // Define table course_grid_summary to be created
        $table = new xmldb_table('course_grid_summary');

        // Adding fields to table course_grid_summary
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
        $table->add_field('show_summary', XMLDB_TYPE_INTEGER, '1', XMLDB_UNSIGNED, null, null, '0', null);
        $table->add_field('course_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0', null);

        /// Adding keys to table course_grid_summary
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        
        // Launch create table for course_grid_summary
        $dbman->create_table($table);  
        upgrade_plugin_savepoint(true, '2011041802', 'format', 'grid');
    }

    if ($oldversion < 2012011701) {
        // Rename the tables
        if ($dbman->table_exists('course_grid_icon')) {
            $table = new xmldb_table('course_grid_icon');
            if (!$dbman->table_exists('format_grid_icon')) {
                $dbman->rename_table($table, 'format_grid_icon');
            } else {
                // May as well tidy up the db
                $dbman->drop_table($table);
            }
        }

        if ($dbman->table_exists('course_grid_summary')) {
            $table = new xmldb_table('course_grid_summary');
            if (!$dbman->table_exists('format_grid_summary')) {
                $dbman->rename_table($table, 'format_grid_summary');
            } else {
                // May as well tidy up the db
                $dbman->drop_table($table);
            }
        }

        upgrade_plugin_savepoint(true, '2012011701', 'format', 'grid');
    }

    if ($oldversion < 2012071500) {
        $table = new xmldb_table('format_grid_summary');

        $field = new xmldb_field('course_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, null, null);
        // Rename course_id
        $dbman->rename_field($table, $field, 'courseid');

        $field = new xmldb_field('show_summary', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        // Rename show_summary
        $dbman->rename_field($table, $field, 'showsummary');

        // Add fields and change to unsigned.
        $table = new xmldb_table('format_grid_icon');

        $field = new xmldb_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '1', 'sectionid');
        // Conditionally launch add field courseid
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_plugin_savepoint(true, '2012071500', 'format', 'grid');		
    }
    return true;
}