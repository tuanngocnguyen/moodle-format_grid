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
 * Grid Format - A topics based format that uses a grid of user selectable images to popup a light box of the section.
 *
 * @package    course/format
 * @subpackage grid
 * @copyright  &copy; 2013 G J Barnard.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/* Imports */
require_once('../../../config.php');
require_once($CFG->dirroot . '/repository/lib.php');
//require_once($CFG->libdir . '/gdlib.php');
require_once('gdlib_m25.php');

/* Script settings */
define('GRID_ITEM_IMAGE_WIDTH', 210);
define('GRID_ITEM_IMAGE_HEIGHT', 140);

function grid_get_icons() {
    global $DB;

    if (!$sectionicons = $DB->get_records('format_grid_icon', null, '', 'sectionid, imagepath')) {
        $sectionicons = false;
    }
    return $sectionicons;
}

function grid_files() {
    global $DB;

    if (!$sectionicons = $DB->get_records('files', null, '', 'pathnamehash, contextid, component, filearea, filepath, filename')) {
        $sectionicons = false;
    }
    return $sectionicons;
}

/* Page parameters */
$contextid = required_param('contextid', PARAM_INT);

if ($contextid) {

    $fs = get_file_storage();

    $sectionicons = grid_get_icons();
    $sectionfiles = grid_files();
    if ($sectionfiles) {
        echo('<p>Files table before ' . print_r($sectionfiles, true) . '.</p>');
        error_log('Files table before ' . print_r($sectionfiles, true) . '.');
    }

    if ($sectionicons) {
        echo('<p>Converting legacy images ' . print_r($sectionicons, true) . ".</p>");
        error_log('Converting legacy images ' . print_r($sectionicons, true) . '.');

        foreach ($sectionicons as $sectionicon) {

            if (isset($sectionicon->imagepath)) {
                echo('<p>Converting legacy image ' . $sectionicon->imagepath . ".</p>");
                error_log('Converting legacy image ' . $sectionicon->imagepath . '.');

                if ($temp_file = $fs->get_file($contextid, 'course', 'legacy', 0, '/icons/', $sectionicon->imagepath)) {

                    echo('<p> Stored file:' . print_r($temp_file, true) . '</p>');
                    error_log(print_r($temp_file, true));
                    // Resize the image and save it...
                    $created = time();
                    $storedfile_record = array(
                        'contextid' => $contextid,
                        'component' => 'course',
                        'filearea' => 'section',
                        'itemid' => $sectionicon->sectionid,
                        'filepath' => '/',
                        'filename' => $sectionicon->imagepath,
                        'timecreated' => $created,
                        'timemodified' => $created);

                    try {
                        $convert_success = true;
                        $mime = $temp_file->get_mimetype();

                        $storedfile_record['mimetype'] = $mime;

                        if ($mime != 'image/gif') {
                            $tmproot = make_temp_directory('gridformaticon');
                            $tmpfilepath = $tmproot . '/' . $temp_file->get_contenthash();
                            $temp_file->copy_content_to($tmpfilepath);

                            $data = generate_image_thumbnail($tmpfilepath, GRID_ITEM_IMAGE_WIDTH, GRID_ITEM_IMAGE_HEIGHT);
                            if (!empty($data)) {
                                $fs->create_file_from_string($storedfile_record, $data);
                            } else {
                                $convert_success = false;
                            }
                            unlink($tmpfilepath);
                        } else {
                            $fr = $fs->convert_image($storedfile_record, $temp_file, GRID_ITEM_IMAGE_WIDTH, GRID_ITEM_IMAGE_HEIGHT, true, null);
                        }

                        if ($convert_success == false) {
                            print('<p>Image ' . $sectionicon->imagepath . ' failed to convert.</p>');
                            error_log('Image ' . $sectionicon->imagepath . ' failed to convert.');
                        } else {
                            print('<p>Image ' . $sectionicon->imagepath . ' converted.</p>');
                            error_log('Image ' . $sectionicon->imagepath . ' converted.');

                            // Clean up and remove the old thumbnail too.
                            $temp_file->delete();
                            unset($temp_file);
                            if ($temp_file = $fs->get_file($contextid, 'course', 'legacy', 0, '/icons/', 'tn_' . $sectionicon->imagepath)) {
                                // Remove thumbnail.
                                $temp_file->delete();
                                unset($temp_file);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($temp_file)) {
                            $temp_file->delete();
                            unset($temp_file);
                        }
                        print('Grid Format Convert Image Exception:...');
                        debugging($e->getMessage());
                    }
                } else {
                    echo('<p>Image ' . $sectionicon->imagepath . ' could not be found in the legacy files.</p>');
                    error_log('Image ' . $sectionicon->imagepath . ' could not be found in the legacy files.');
                }
            }
        }
        $sectionfiles = grid_files();
        if ($sectionfiles) {
            echo('<p>Files table after ' . print_r($sectionfiles, true) . '.</p>');
            error_log('Files table after ' . print_r($sectionfiles, true) . '.');
        }
    } else {
        echo('<p>No section icons found.</p>');
        error_log('No section icons found.');
    }
} else {
    echo('<p>Context id not supplied.</p>');
    error_log('Context id not supplied.');
}
