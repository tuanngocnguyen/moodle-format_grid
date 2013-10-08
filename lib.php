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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/format/lib.php'); // For format_base.

class format_grid extends format_base {

    // CONTRIB-4099:....
    // Width constants - 128, 192, 210, 256, 320, 384, 448, 512, 576, 640, 704 and 768:...
    private static $iconwidths = array(128 => '128', 192 => '192', 210 => '210', 256 => '256', 320 => '320', 384 => '384',
                                       448 => '448', 512 => '512', 576 => '576', 640 => '640', 704 => '704', 768 => '768');
    // Ratio constants - 3-2, 3-1, 3-3, 2-3, 1-3, 4-3 and 3-4:...
    private static $iconratios = array(1 => '3-2', 2 => '3-1', 3 => '3-3', 4 => '2-3', 5 => '1-3', 6 => '4-3', 7 => '3-4');
    //private $fliped_iconratios;
    // Border width constants - 1 to 10:....
    private static $borderwidths = array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10');

    /**
     * Creates a new instance of class
     *
     * Please use {@link course_get_format($courseorid)} to get an instance of the format class
     *
     * @param string $format
     * @param int $courseid
     * @return format_grid
     */
    protected function __construct($format, $courseid) {
        parent::__construct($format, $courseid);
        //$fliped_iconratios = array_flip(self::$iconratios);
    }

    /**
     * Prevents ability to change a static variable outside of the class.
     * @return array Array of icon widths.
     */
    public static function get_icon_widths() {
        return self::$iconwidths;
    }

    /**
     * Gets the default icon width.
     * @return int Default icon width.
     */
    public static function get_default_icon_width() {
        return 210;
    }

    /**
     * Prevents ability to change a static variable outside of the class.
     * @return array Array of icon ratios.
     */
    public static function get_icon_ratios() {
        return self::$iconratios;
    }

    /**
     * Gets the default icon ratio.
     * @return int Default icon ratio.
     */
    public static function get_default_icon_ratio() {
        return 1; // '3-2'.
    }

    /**
     * Prevents ability to change a static variable outside of the class.
     * @return array Array of border widths.
     */
    public static function get_border_widths() {
        return self::$borderwidths;
    }

    /**
     * Gets the default border width.
     * @return int Default border width.
     */
    public static function get_default_border_width() {
        return 3; // '3'.
    }

    /**
     * Returns the format's settings and gets them if they do not exist.
     * @return type The settings as an array.
     */
    public function get_settings() {
        if (empty($this->settings) == true) {
            $this->settings = $this->get_format_options();
        }
        return $this->settings;
    }

    /**
     * Gets the name for the provided section.
     *
     * @param stdClass $section The section.
     * @return string The section name.
     */
    public function get_section_name($section) {
        $course = $this->get_course();
        $section = $this->get_section($section);
        if (!empty($section->name)) {
            return format_string($section->name, true, array('context' => get_context_instance(CONTEXT_COURSE, $course->id)));
        } if ($section->section == 0) {
            return get_string('topic0', 'format_grid');
        } else {
            return get_string('topic', 'format_grid') . ' ' . $section->section;
        }
    }

    /**
     * Indicates this format uses sections.
     *
     * @return bool Returns true
     */
    public function uses_sections() {
        return true;
    }

    /**
     * The URL to use for the specified course (with section)
     *
     * @param int|stdClass $section Section object from database or just field course_sections.section
     *     if omitted the course view page is returned
     * @param array $options options for view URL. At the moment core uses:
     *     'navigation' (bool) if true and section has no separate page, the function returns null
     *     'sr' (int) used by multipage formats to specify to which section to return
     * @return null|moodle_url
     */
    public function get_view_url($section, $options = array()) {
        $course = $this->get_course();
        $url = new moodle_url('/course/view.php', array('id' => $course->id));

        $sr = null;
        if (array_key_exists('sr', $options)) {
            $sr = $options['sr'];
        }
        if (is_object($section)) {
            $sectionno = $section->section;
        } else {
            $sectionno = $section;
        }
        if ($sectionno !== null) {
            if ($sr !== null) {
                if ($sr) {
                    $usercoursedisplay = COURSE_DISPLAY_MULTIPAGE;
                    $sectionno = $sr;
                } else {
                    $usercoursedisplay = COURSE_DISPLAY_SINGLEPAGE;
                }
            } else {
                $usercoursedisplay = $course->coursedisplay;
            }
            if ($sectionno != 0 && $usercoursedisplay == COURSE_DISPLAY_MULTIPAGE) {
                $url->param('section', $sectionno);
            } else {
                if (!empty($options['navigation'])) {
                    return null;
                }
                $url->set_anchor('section-' . $sectionno);
            }
        }
        return $url;
    }

    /**
     * Returns the information about the ajax support in the given source format
     *
     * The returned object's property (boolean)capable indicates that
     * the course format supports Moodle course ajax features.
     * The property (array)testedbrowsers can be used as a parameter for {@link ajaxenabled()}.
     *
     * @return stdClass
     */
    public function supports_ajax() {
        $ajaxsupport = new stdClass();
        $ajaxsupport->capable = true;
        $ajaxsupport->testedbrowsers = array('MSIE' => 8.0, 'Gecko' => 20061111, 'Opera' => 9.0, 'Safari' => 531, 'Chrome' => 6.0);
        return $ajaxsupport;
    }

    /**
     * Custom action after section has been moved in AJAX mode
     *
     * Used in course/rest.php
     *
     * @return array This will be passed in ajax respose
     */
    public function ajax_section_move() {
        global $PAGE;
        $titles = array();
        $course = $this->get_course();
        $modinfo = get_fast_modinfo($course);
        $renderer = $this->get_renderer($PAGE);
        if ($renderer && ($sections = $modinfo->get_section_info_all())) {
            foreach ($sections as $number => $section) {
                $titles[$number] = $renderer->section_title($section, $course);
            }
        }
        return array('sectiontitles' => $titles, 'action' => 'move');
    }

    /**
     * Returns the list of blocks to be automatically added for the newly created course
     *
     * @return array of default blocks, must contain two keys BLOCK_POS_LEFT and BLOCK_POS_RIGHT
     *     each of values is an array of block names (for left and right side columns)
     */
    public function get_default_blocks() {
        return array(
            BLOCK_POS_LEFT => array(),
            BLOCK_POS_RIGHT => array('search_forums', 'news_items', 'calendar_upcoming', 'recent_activity')
        );
    }

    /**
     * Definitions of the additional options that this course format uses for course
     *
     * Grid format uses the following options (until extras are migrated):
     * - coursedisplay
     * - numsections
     * - hiddensections
     *
     * @param bool $foreditform
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        static $courseformatoptions = false;

        if ($courseformatoptions === false) {
            $courseconfig = get_config('moodlecourse');
            $courseformatoptions = array(
                'numsections' => array(
                    'default' => $courseconfig->numsections,
                    'type' => PARAM_INT,
                ),
                'hiddensections' => array(
                    'default' => $courseconfig->hiddensections,
                    'type' => PARAM_INT,
                ),
                'coursedisplay' => array(
                    'default' => $courseconfig->coursedisplay,
                    'type' => PARAM_INT,
                ),
                'iconwidth' => array(
                    'default' => get_config('format_grid', 'defaulticonwidth'),
                    'type' => PARAM_INT,
                ),
                'iconratio' => array(
                    'default' => get_config('format_grid', 'defaulticonratio'),
                    'type' => PARAM_ALPHANUM,
                ),
                'bordercolour' => array(
                    'default' => get_config('format_grid', 'defaultbordercolour'),
                    'type' => PARAM_ALPHANUM,
                ),
                'borderwidth' => array(
                    'default' => get_config('format_grid', 'defaultborderwidth'),
                    'type' => PARAM_INT,
                ),
                'iconbackgroundcolour' => array(
                    'default' => get_config('format_grid', 'defaulticonbackgroundcolour'),
                    'type' => PARAM_ALPHANUM,
                ),
                'currentselectedsectioncolour' => array(
                    'default' => get_config('format_grid', 'defaultcurrentselectedsectioncolour'),
                    'type' => PARAM_ALPHANUM,
                ),
                'currentselectediconcolour' => array(
                    'default' => get_config('format_grid', 'defaultcurrentselectediconcolour'),
                    'type' => PARAM_ALPHANUM,
                )
            );
        }
        if ($foreditform && !isset($courseformatoptions['coursedisplay']['label'])) {
            global $COURSE;
            $coursecontext = context_course::instance($COURSE->id);

            $courseconfig = get_config('moodlecourse');
            $sectionmenu = array();
            for ($i = 0; $i <= $courseconfig->maxsections; $i++) {
                $sectionmenu[$i] = "$i";
            }
            $courseformatoptionsedit = array(
                'numsections' => array(
                    'label' => new lang_string('numbersections', 'format_grid'),
                    'element_type' => 'select',
                    'element_attributes' => array($sectionmenu),
                ),
                'hiddensections' => array(
                    'label' => new lang_string('hiddensections'),
                    'help' => 'hiddensections',
                    'help_component' => 'moodle',
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            0 => new lang_string('hiddensectionscollapsed'),
                            1 => new lang_string('hiddensectionsinvisible')
                        )
                    ),
                ),
                'coursedisplay' => array(
                    'label' => new lang_string('coursedisplay'),
                    'element_type' => 'select',
                    'element_attributes' => array(
                        array(
                            COURSE_DISPLAY_SINGLEPAGE => new lang_string('coursedisplay_single'),
                            COURSE_DISPLAY_MULTIPAGE => new lang_string('coursedisplay_multi')
                        )
                    ),
                    'help' => 'coursedisplay',
                    'help_component' => 'moodle',
                )
            );
            if (true /* has_capability('format/grid:changeiconsize', $coursecontext)*/) {
                $courseformatoptionsedit['iconwidth'] = array(
                    'label' => new lang_string('seticonwidth', 'format_grid'),
                    'help' => 'seticonwidth',
                    'help_component' => 'format_grid',
                    'element_type' => 'select',
                    'element_attributes' => array( self::$iconwidths )
                );
                $courseformatoptionsedit['iconratio'] = array(
                    'label' => new lang_string('seticonratio', 'format_grid'),
                    'help' => 'seticonratio',
                    'help_component' => 'format_grid',
                    'element_type' => 'select',
                    'element_attributes' => array( self::$iconratios )
                );
            } else {
                $courseformatoptionsedit['iconwidth'] =
                    array('label' => new lang_string('seticonwidth', 'format_grid'), 'element_type' => 'hidden');
                $courseformatoptionsedit['iconratio'] =
                    array('label' => new lang_string('seticonratio', 'format_grid'), 'element_type' => 'hidden');
            }

            if (true /* has_capability('format/grid:changeiconstyle', $coursecontext)*/) {
                $courseformatoptionsedit['bordercolour'] = array(
                    'label' => new lang_string('setbordercolour', 'format_grid'),
                    'help' => 'setbordercolour',
                    'help_component' => 'format_grid',
                    'element_type' => 'gfcolourpopup',
                    'element_attributes' => array(
                        array('tabindex' => -1, 'value' => get_config('format_grid', 'defaultbordercolour'))
                    )
                );

                $courseformatoptionsedit['borderwidth'] = array(
                    'label' => new lang_string('seticonwidth', 'format_grid'),
                    'help' => 'setborderwidth',
                    'help_component' => 'format_grid',
                    'element_type' => 'select',
                    'element_attributes' => array( self::$borderwidths )
                );

                $courseformatoptionsedit['iconbackgroundcolour'] = array(
                    'label' => new lang_string('seticonbackgroundcolour', 'format_grid'),
                    'help' => 'seticonbackgroundcolour',
                    'help_component' => 'format_grid',
                    'element_type' => 'gfcolourpopup',
                    'element_attributes' => array(
                        array('tabindex' => -1, 'value' => get_config('format_grid', 'defaulticonbackgroundcolour'))
                    )
                );

                $courseformatoptionsedit['currentselectedsectioncolour'] = array(
                    'label' => new lang_string('setcurrentselectedsectioncolour', 'format_grid'),
                    'help' => 'setcurrentselectedsectioncolour',
                    'help_component' => 'format_grid',
                    'element_type' => 'gfcolourpopup',
                    'element_attributes' => array(
                        array('tabindex' => -1, 'value' => get_config('format_grid', 'defaultcurrentselectedsectioncolour'))
                    )
                );

                $courseformatoptionsedit['currentselectediconcolour'] = array(
                    'label' => new lang_string('setcurrentselectediconcolour', 'format_grid'),
                    'help' => 'setcurrentselectediconcolour',
                    'help_component' => 'format_grid',
                    'element_type' => 'gfcolourpopup',
                    'element_attributes' => array(
                        array('tabindex' => -1, 'value' => get_config('format_grid', 'defaultcurrentselectediconcolour'))
                    )
                );
            } else {
                $courseformatoptionsedit['bordercolour'] =
                    array('label' => new lang_string('setbordercolour', 'format_grid'), 'element_type' => 'hidden');
                $courseformatoptionsedit['borderwidth'] =
                    array('label' => new lang_string('setborderwidth', 'format_grid'), 'element_type' => 'hidden');
                $courseformatoptionsedit['iconbackgroundcolour'] =
                    array('label' => new lang_string('seticonbackgroundcolour', 'format_grid'), 'element_type' => 'hidden');
                $courseformatoptionsedit['currentselectedsectioncolour'] =
                    array('label' => new lang_string('setcurrentselectedsectioncolour', 'format_grid'), 'element_type' => 'hidden');
                $courseformatoptionsedit['currentselectediconcolour'] =
                    array('label' => new lang_string('setcurrentselectediconcolour', 'format_grid'), 'element_type' => 'hidden');
            }
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }

    /**
     * Adds format options elements to the course/section edit form
     *
     * This function is called from {@link course_edit_form::definition_after_data()}
     *
     * @param MoodleQuickForm $mform form the elements are added to
     * @param bool $forsection 'true' if this is a section edit form, 'false' if this is course edit form
     * @return array array of references to the added form elements
     */
    public function create_edit_form_elements(&$mform, $forsection = false) {
        global $CFG, $OUTPUT;
        MoodleQuickForm::registerElementType('gfcolourpopup', "$CFG->dirroot/course/format/grid/js/gf_colourpopup.php",
                                             'MoodleQuickForm_gfcolourpopup');

        $elements = parent::create_edit_form_elements($mform, $forsection);
        if ($forsection == false) {
            global $COURSE, $USER;
            /*
             Increase the number of sections combo box values if the user has increased the number of sections
             using the icon on the course page beyond course 'maxsections' or course 'maxsections' has been
             reduced below the number of sections already set for the course on the site administration course
             defaults page.  This is so that the number of sections is not reduced leaving unintended orphaned
             activities / resources.
             */
            $maxsections = get_config('moodlecourse', 'maxsections');
            $numsections = $mform->getElementValue('numsections');
            $numsections = $numsections[0];
            if ($numsections > $maxsections) {
                $element = $mform->getElement('numsections');
                for ($i = $maxsections+1; $i <= $numsections; $i++) {
                    $element->addOption("$i", $i);
                }
            }

            $coursecontext = context_course::instance($COURSE->id);

            //$changeiconsize = has_capability('format/grid:changeiconsize', $coursecontext);
            $changeiconsize = true;
            //$changeiconstyle = has_capability('format/grid:changeiconstyle', $coursecontext);
            $changeiconstyle = true;
            $resetall = is_siteadmin($USER); // Site admins only.

            $elements[] = $mform->addElement('header', 'gfreset', get_string('gfreset', 'format_grid'));
            $mform->addHelpButton('gfreset', 'gfreset', 'format_grid', '', true);

            $resetelements = array();

            if ($changeiconsize) {
                $checkboxname = get_string('reseticonsize', 'format_grid').$OUTPUT->help_icon('reseticonsize', 'format_grid');
                $resetelements[] =& $mform->createElement('checkbox', 'reseticonsize', '', $checkboxname);
            }

            if ($changeiconstyle) {
                $checkboxname = get_string('reseticonstyle', 'format_grid').$OUTPUT->help_icon('reseticonstyle', 'format_grid');
                $resetelements[] =& $mform->createElement('checkbox', 'iconstyle', '', $checkboxname);
            }

            $elements[] = $mform->addGroup($resetelements, 'resetgroup', get_string('resetgrp', 'format_grid'), null, false);

            if ($resetall) {
                $resetallelements = array();

                $checkboxname = get_string('resetalliconsize', 'format_grid').$OUTPUT->help_icon('resetalliconsize', 'format_grid');
                $resetallelements[] =& $mform->createElement('checkbox', 'resetalliconsize', '', $checkboxname);

                $checkboxname = get_string('resetalliconstyle', 'format_grid').$OUTPUT->help_icon('resetalliconstyle', 'format_grid');
                $resetallelements[] =& $mform->createElement('checkbox', 'resetalliconstyle', '', $checkboxname);

                $elements[] = $mform->addGroup($resetallelements, 'resetallgroup', get_string('resetallgrp', 'format_grid'), null, false);
            }
        }

        return $elements;
    }

    // Grid specific methods...
    public function grid_moodle_url($url, array $params = null) {
        return new moodle_url('/course/format/grid/' . $url, $params);
    }

    public function is_empty_text($text) {
        return empty($text) ||
                preg_match('/^(?:\s|&nbsp;)*$/si', htmlentities($text, 0 /* ENT_HTML401 */, 'UTF-8', true));
    }

    /**
     * Gets the grid icon entries for the given course.
     * @param int $courseid The course id to use.
     * @returns bool|array The records or false if the course id is 0 or the request failed.
     */
    public function grid_get_icons($courseid) {
        global $DB;

        if (!$courseid) {
            return false;
        }

        if (!$sectionicons = $DB->get_records('format_grid_icon', array('courseid' => $courseid),'','sectionid, iconpath, displayediconpath')) {
            $sectionicons = false;
        }
        return $sectionicons;
    }

    /**
     * Create an entry for the icon in the database if 'grid_get_icons' reports it does not exist.
     * @param int $courseid The course id to use.
     * @param int $sectionid The section id to use.
     * @returns bool|class The new record or false if the course id / section id are 0.
     * @throws moodle_exception If the table 'format_grid_icon' does not exist or the record cannot be created.
     */
    public function create_get_icon($courseid, $sectionid) {
        global $DB;

        if ((!$courseid) || (!$sectionid)) {
            return false;
        }

        $newicon = new stdClass();
        $newicon->sectionid = $sectionid;
        $newicon->courseid = $courseid;

        if (!$newicon->id = $DB->insert_record('format_grid_icon', $newicon, true)) {
            throw new moodle_exception('invalidrecordid', 'format_grid', '',
                    'Could not create icon. Grid format database is not ready. An admin must visit the notifications section.');
        }
        return $newicon;
    }

    /**
     * Gets the grid icon entry for the given course and section.
     * @param int $courseid The course id to use.
     * @param int $sectionid The section id to use.
     * @returns bool|array The record or false if the course id is 0 or section id is 0 or the request failed.
     */
    public function grid_get_icon($courseid, $sectionid) {
        global $CFG, $DB;

        if ((!$courseid) || (!$sectionid)) {
            return false;
        }

        if (!$sectionicon = $DB->get_record('format_grid_icon', array('sectionid' => $sectionid))) {

            $newicon = new stdClass();
            $newicon->sectionid = $sectionid;
            $newicon->courseid = $courseid;

            if (!$newicon->id = $DB->insert_record('format_grid_icon', $newicon, true)) {
                throw new moodle_exception('invalidrecordid', 'format_grid', '',
                        'Could not create icon. Grid format database is not ready. An admin must visit the notifications section.');
            }
            $sectionicon = false;
        }
        return $sectionicon;
    }

    /**
     * Get section icon, if it doesn't exist create it.
     */
    public function get_summary_visibility($course) {
        global $DB;
        if (!$summary_status = $DB->get_record('format_grid_summary', array('courseid' => $course))) {
            $new_status = new stdClass();
            $new_status->courseid = $course;
            $new_status->showsummary = 1;

            if (!$new_status->id = $DB->insert_record('format_grid_summary', $new_status)) {
                throw new moodle_exception('invalidrecordid', 'format_grid', '',
                    'Could not set summary status. Grid format database is not ready. An admin must visit the notifications section.');
            }
            $summary_status = $new_status;
        }
        return $summary_status;
    }
}

/**
 * Indicates this format uses sections.
 *
 * @return bool Returns true
 */
function callback_grid_uses_sections() {
    return true;
}

/**
 * Used to display the course structure for a course where format=grid
 *
 * This is called automatically by {@link load_course()} if the current course
 * format = weeks.
 *
 * @param array $path An array of keys to the course node in the navigation
 * @param stdClass $modinfo The mod info object for the current course
 * @return bool Returns true
 */
function callback_grid_load_content(&$navigation, $course, $coursenode) {
    return $navigation->load_generic_course_sections($course, $coursenode, 'grid');
}

/**
 * The string that is used to describe a section of the course
 * e.g. Topic, Week...
 *
 * @return string
 */
function callback_grid_definition() {
    return get_string('topic', 'format_grid');
}

/**
 * Deletes the settings entry for the given course upon course deletion.
 */
function format_grid_delete_course($courseid) {
    global $DB;

    $DB->delete_records("format_grid_icon", array("courseid" => $courseid));
    $DB->delete_records("format_grid_summary", array("courseid" => $courseid));
}
