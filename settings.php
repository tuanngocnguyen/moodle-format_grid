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
 * @copyright  &copy; 2013 G J Barnard in respect to modifications of standard topics format.
 * @author     G J Barnard - gjbarnard at gmail dot com, about.me/gjbarnard and {@link http://moodle.org/user/profile.php?id=442195}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/course/format/grid/lib.php'); // For format_grid static constants.

if ($ADMIN->fulltree) {
    /* Default course display.
     * Course display default, can be either one of:
     * COURSE_DISPLAY_SINGLEPAGE or - All sections on one page.
     * COURSE_DISPLAY_MULTIPAGE     - One section per page.
     * as defined in moodlelib.php.
     */
    $name = 'format_grid/defaultcoursedisplay';
    $title = get_string('defaultcoursedisplay', 'format_grid');
    $description = get_string('defaultcoursedisplay_desc', 'format_grid');
    $default = COURSE_DISPLAY_SINGLEPAGE;
    $choices = array(
        COURSE_DISPLAY_SINGLEPAGE => new lang_string('coursedisplay_single'),
        COURSE_DISPLAY_MULTIPAGE => new lang_string('coursedisplay_multi')
    );
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));


    /* Icon width. */
    $name = 'format_grid/defaulticonwidth';
    $title = get_string('defaulticonwidth', 'format_grid');
    $description = get_string('defaulticonwidth_desc', 'format_grid');
    $default = format_grid::get_default_icon_width();
    $choices = format_grid::get_icon_widths();
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    /* Icon ratio. */
    $name = 'format_grid/defaulticonratio';
    $title = get_string('defaulticonratio', 'format_grid');
    $description = get_string('defaulticonratio_desc', 'format_grid');
    $default = format_grid::get_default_icon_ratio();
    $choices = format_grid::get_icon_ratios();
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Default toggle foreground colour in hexidecimal RGB without preceeding '#'.
    $name = 'format_topcoll/defaulttgfgcolour';
    $title = get_string('defaulttgfgcolour', 'format_topcoll');
    $description = get_string('defaulttgfgcolour_desc', 'format_topcoll');
    $default = '#000000';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

}