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
 * @copyright  &copy; 2012+ G J Barnard in respect to modifications of standard topics format.
 * @author     G J Barnard - gjbarnard at gmail dot com, about.me/gjbarnard and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Paul Krix and Julian Ridden.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Lib unit tests for the Grid course format.
 * @group format_grid
 */
class format_grid_courseformatlib_testcase extends advanced_testcase {
    protected $courseone;
    protected $coursetwo;
    protected $courseformatone;
    protected $courseformattwo;

    protected function setUp() {
        $this->resetAfterTest(true);

        set_config('theme', 'clean');
        global $PAGE;
        // Ref: https://docs.moodle.org/dev/Writing_PHPUnit_tests.
        $this->courseone = $this->getDataGenerator()->create_course(
            array('format' => 'grid',
                'numsections' => 1,
                'sectiontitleinsidetitletextcolour' => '#ffffff',
                'sectiontitleinsidetitlebackgroundcolour' => '#000000'),
            array('createsections' => true));
        $this->courseformatone = course_get_format($this->courseone);
        $this->coursetwo = $this->getDataGenerator()->create_course(
            array('format' => 'grid',
                'numsections' => 1,
                'sectiontitleinsidetitletextcolour' => '#ffffff',
                'sectiontitleinsidetitlebackgroundcolour' => '#000000'),
            array('createsections' => true));
        $this->courseformattwo = course_get_format($this->courseone);
    }

    public function test_reset_section_title_options() {
        $this->setAdminUser();
        $data = new stdClass;
        $data->resetsectiontitleoptions = true;
        $this->courseformatone->update_course_format_options($data);
        $cfo = $this->courseformatone->get_format_options();

        $this->assertEquals('000000', $cfo['sectiontitleinsidetitletextcolour']);
        $this->assertEquals('ffffff', $cfo['sectiontitleinsidetitlebackgroundcolour']);
    }

    public function test_reset_all_section_title_options() {
        $this->setAdminUser();
        $data = new stdClass;
        $data->resetallsectiontitleoptions = true;
        $this->courseformatone->update_course_format_options($data);
        $cfo1 = $this->courseformatone->get_format_options();

        $this->assertEquals('000000', $cfo1['sectiontitleinsidetitletextcolour']);
        $this->assertEquals('ffffff', $cfo1['sectiontitleinsidetitlebackgroundcolour']);

        $data = new stdClass;
        $data->resetallsectiontitleoptions = true;
        $this->courseformattwo->update_course_format_options($data);
        $cfo2 = $this->courseformattwo->get_format_options();

        $this->assertEquals('000000', $cfo2['sectiontitleinsidetitletextcolour']);
        $this->assertEquals('ffffff', $cfo2['sectiontitleinsidetitlebackgroundcolour']);
    }
}