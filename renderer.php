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
 * Renderer for outputting the redirected course format.
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Basic renderer for redirected format.
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class format_redirected_renderer extends plugin_renderer_base {

    /**
     * Displays the list of redirected courses when user is not
     * redirected to the target course.
     *
     * @param stdClass $course record from table course
     */
    public function display($course) {

        $output = '';
        $modinfo = get_fast_modinfo($course);
        $output .= $this->output->heading(get_string('redirectedcourse', 'format_redirected'), 3, 'sectionname');
        // Get matalinked courses and list them.
        $metas = format_redirected::get_metalinks($course->id);
        $outputlist = '<ul>';
        foreach($metas as $meta) {
            $course = get_course($meta->courseid);
            $url = new moodle_url('/course/view.php', ['id' => $course->id]);
            $outputlist .= '<li><a href="'. $url->out() . '" >' . $course->fullname . '</a></li>';
        }
        $outputlist .= '</ul>';
        $output .= $this->output->box(get_string('metalinked', 'format_redirected', $outputlist));
        
        return $output;
    }
}
