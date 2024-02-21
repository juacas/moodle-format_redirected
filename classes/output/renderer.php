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
namespace format_redirected\output;
use core\output\notification;
use core_courseformat\output\section_renderer;

defined('MOODLE_INTERNAL') || die();

/**
 * Basic renderer for redirected format.
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends section_renderer {

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
        // Teacher's message.
        if (has_capability('moodle/course:update', \context_course::instance($course->id))) {
            $output .= $this->output->notification(
                format_text(get_config(
                    'format_redirected',
                    'noticeforteachers'), FORMAT_HTML),
                notification::NOTIFY_WARNING
            );
        }
        // Get matalinked courses and list them.
        $courses = \format_redirected::get_target_courses($course);
        if (count($courses) > 0) {
            // Student's message.
            $output .= $this->output->notification(format_text(get_config('format_redirected', 'noticeforstudents'), FORMAT_HTML),
                                                    notification::NOTIFY_INFO);
            // Render list of courses.
            $output .= $this->page->get_renderer('core', 'course')->courses_list($courses);
        } else {
            $output .= $this->output->notification(get_string('notredirected_error', 'format_redirected'),
                                                    notification::NOTIFY_ERROR);
        }
        return $output;
    }
}
