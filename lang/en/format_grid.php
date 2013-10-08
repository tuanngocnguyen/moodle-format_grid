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
 * @copyright  &copy; 2012 G J Barnard in respect to modifications of standard topics format.
 * @author     G J Barnard - gjbarnard at gmail dot com, about.me/gjbarnard and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Paul Krix and Julian Ridden.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['display_summary'] = 'move out of grid';
$string['display_summary_alt'] = 'Move this section out of the grid';
$string['editimage'] = 'Change image';
$string['editimage_alt'] = 'Set or change image';
$string['formatgrid'] = 'Grid format'; // Name to display for format.
$string['general_information'] = 'General Information';  // No longer used kept for legacy versions.
$string['hidden_topic'] = 'This section has been hidden';
$string['hide_summary'] = 'move section into grid';
$string['hide_summary_alt'] = 'Move this section into the grid';
$string['namegrid'] = 'Grid view';
$string['pluginname'] = 'Grid format';
$string['title'] = 'Section title';
$string['topic'] = 'Section';
$string['topic0'] = 'General';
$string['topicoutline'] = 'Section';  // No longer used kept for legacy versions.

// MDL-26105.
$string['page-course-view-topcoll'] = 'Any course main page in the grid format';
$string['page-course-view-topcoll-x'] = 'Any course page in the grid format';

// Moodle 2.3 Enhancement.
$string['hidefromothers'] = 'Hide section'; // No longer used kept for legacy versions.
$string['showfromothers'] = 'Show section'; // No longer used kept for legacy versions.
$string['currentsection'] = 'This section'; // No longer used kept for legacy versions.

// Moodle 2.4 Course format refactoring - MDL-35218.
$string['numbersections'] = 'Number of sections';

// Image did not convert.
$string['imagecannotbeusedasanicon'] = 'Image cannot be used as an icon, must be a Gif, Jpg or Png and the GD PHP library installed.';

// CONTRIB-4099 Icon size change improvement.
$string['gfreset'] = 'Grid reset options';
$string['gfreset_help'] = 'Reset to Grid defaults.';
$string['defaulticonwidth'] = 'Default width of the icon';
$string['defaulticonwidth_desc'] = 'The default width of the icon.';
$string['defaulticonratio'] = 'Default ratio of the icon relative to the width';
$string['defaulticonratio_desc'] = 'The default ratio of the icon relative to the width.';
$string['defaultbordercolour'] = 'Default icon border colour';
$string['defaultbordercolour_desc'] = 'The default icon border colour.';
$string['defaultborderwidth'] = 'Default border width';
$string['defaultborderwidth_desc'] = 'The default border width.';
$string['defaulticonbackgroundcolour'] = 'Default icon background colour';
$string['defaulticonbackgroundcolour_desc'] = 'The default icon background colour.';
$string['defaultcurrentselectedsectioncolour'] = 'Default current selected section colour';
$string['defaultcurrentselectedsectioncolour_desc'] = 'The default current selected section colour.';
$string['defaultcurrentselectediconcolour'] = 'Default current selected icon colour';
$string['defaultcurrentselectediconcolour_desc'] = 'The default current selected icon colour.';

$string['defaultcoursedisplay'] = 'Course display default';
$string['defaultcoursedisplay_desc'] = "Either show all the sections on a single page or section zero and the chosen section on page.";

$string['seticonwidth'] = 'Set the icon width';
$string['seticonwidth_help'] = 'Set the icon width to one of: 128, 192, 210, 256, 320, 384, 448, 512, 576, 640, 704 or 768';
$string['seticonratio'] = 'Set the icon ration relative to the width';
$string['seticonratio_help'] = 'Set the icon ration to one of: 3-2, 3-1, 3-3, 2-3, 1-3, 4-3 or 3-4.';
$string['setbordercolour'] = 'Set the border colour';
$string['setbordercolour_help'] = 'Set the border colour in hexidecimal RGB.';
$string['setborderwidth'] = 'Set the border width';
$string['setborderwidth_help'] = 'Set the border width between 1 and 10.';
$string['seticonbackgroundcolour'] = 'Set the icon background colour';
$string['seticonbackgroundcolour_help'] = 'Set the icon background colour in hexidecimal RGB.';
$string['setcurrentselectedsectioncolour'] = 'Set the current selected section colour';
$string['setcurrentselectedsectioncolour_help'] = 'Set the current selected section colour in hexidecimal RGB.';
$string['setcurrentselectediconcolour'] = 'Set the current selected icon colour';
$string['setcurrentselectediconcolour_help'] = 'Set the current selected icon colour in hexidecimal RGB.';

// Reset
$string['resetgrp'] = 'Reset:';
$string['resetallgrp'] = 'Reset all:';
$string['reseticonsize'] = 'Icon size';
$string['reseticonsize_help'] = 'Resets the icon size to the default value so it will be the same as a course the first time it is in the Grid format.';
$string['resetalliconsize'] = 'Icon sizes';
$string['resetalliconsize_help'] = 'Resets the icon sizes to the default value for all courses so it will be the same as a course the first time it is in the Grid format.';
$string['reseticonstyle'] = 'Icon style';
$string['reseticonstyle_help'] = 'Resets the icon style to the default value so it will be the same as a course the first time it is in the Grid format.';
$string['resetalliconstyle'] = 'Icon styles';
$string['resetalliconstyle_help'] = 'Resets the icon styles to the default value for all courses so it will be the same as a course the first time it is in the Grid format.';

// Capabilities.
$string['grid:changeiconsize'] = 'Change or reset the icon size';
$string['grid:changeiconstyle'] = 'Change or reset the icon style';
