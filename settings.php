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

    // Default border colour in hexidecimal RGB without preceeding '#'.
    $name = 'format_grid/defaultbordercolour';
    $title = get_string('defaultbordercolour', 'format_grid');
    $description = get_string('defaultbordercolour_desc', 'format_grid');
    $default = format_grid::get_default_border_colour();
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    /* Border width. */
    $name = 'format_grid/defaultborderwidth';
    $title = get_string('defaultborderwidth', 'format_grid');
    $description = get_string('defaultborderwidth_desc', 'format_grid');
    $default = format_grid::get_default_border_width();
    $choices = format_grid::get_border_widths();
    $settings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Default icon background colour in hexidecimal RGB without preceeding '#'.
    $name = 'format_grid/defaulticonbackgroundcolour';
    $title = get_string('defaulticonbackgroundcolour', 'format_grid');
    $description = get_string('defaulticonbackgroundcolour', 'format_grid');
    $default = format_grid::get_default_icon_background_colour();
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    // Default current selected section colour in hexidecimal RGB without preceeding '#'.
    $name = 'format_grid/defaultcurrentselectedsectioncolour';
    $title = get_string('defaultcurrentselectedsectioncolour', 'format_grid');
    $description = get_string('defaultcurrentselectedsectioncolour', 'format_grid');
    $default = format_grid::get_default_current_selected_section_colour();
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);

    // Default current selected icon colour in hexidecimal RGB without preceeding '#'.
    $name = 'format_grid/defaultcurrentselectediconcolour';
    $title = get_string('defaultcurrentselectediconcolour', 'format_grid');
    $description = get_string('defaultcurrentselectediconcolour', 'format_grid');
    $default = format_grid::get_default_current_selected_icon_colour();
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $settings->add($setting);
}