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
 * This file contains main class for the course format redirected
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/format/lib.php');

/**
 * Main class for the redirected course format
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @author @izendegi PR Metabulk links support.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class format_redirected extends core_courseformat\base {
    /** @var cm_info the current activity. Use get_activity() to retrieve it. */
    private $metalinks = null;

    /** @var int The category ID guessed from the form data. */
    private $categoryid = false;

    /**
     * The URL to use for the specified course
     *
     * @param int|stdClass $section Section object from database or just field course_sections.section
     *     if null the course view page is returned
     * @param array $options options for view URL. At the moment core uses:
     *     'navigation' (bool) if true and section has no separate page, the function returns null
     *     'sr' (int) used by multipage formats to specify to which section to return
     * @return null|moodle_url
     */
    public function get_view_url($section, $options = array()) {
        $targeturl = $this->get_main_redirection();
        if ($targeturl) {
            return $targeturl;
        } else {
            return new moodle_url('/course/view.php', array('id' => $this->get_courseid()));
        }
    }

    /**
     * Allows course format to execute code on moodle_page::set_course()
     *
     * This function is executed before the output starts.
     *
     * If everything is configured correctly, user is redirected from the
     * default course view page to the target Course.
     *
     *
     * If user is on course view page and there is no target course
     * show instructions.
     *
     * @param moodle_page $page instance of page calling set_course
     */
    public function page_set_course(moodle_page $page) {
        $targeturl = $this->get_main_redirection();
        if ($targeturl) {
            redirect($targeturl, get_string('course_redirected_from', 'format_redirected', $this->get_course()->fullname));
        }
    }
    /**
     * Get the main redirection if there is a criteria to select just one.
     * @return moodle_url|false
     */
    protected function get_main_redirection() {
        // Users with teacher's capabilities view the informative page.
        if (has_capability('moodle/course:update', context_course::instance($this->courseid))) {
            return false;
        }
        $metalinks = self::get_metalinks($this->get_courseid());
        if (count($metalinks) == 1) {
            $meta = reset($metalinks);
            $targeturl = new moodle_url('/course/view.php', ['id' => $meta->courseid ]);
            return $targeturl;
        }
        return false;
    }
    /**
     * Scans a course and determines what other courses are to be redirected to.
     * Use system config for the pattern to exclude courses.
     * @param stdClass $course to be redirected.
     * @return array courses that are to be redirected to.
     */
    public static function get_target_courses($course) {
        $courses = [];
        $metalinks = self::get_metalinks($course->id);
        $metabulks = self::get_metabulklinks($course->id); // PR by @izendegi.

        $metas = array_merge($metalinks, $metabulks);
        // Get the excluded pattern.
        $excludepattern = get_config('format_redirected', 'excludepattern');
        if ($excludepattern) {
            $excludepattern = '/' . $excludepattern . '/';
        }
        foreach ($metas as $meta) {
            $course = get_course($meta->courseid);
            // Check if the course is excluded.
            if ($excludepattern && preg_match($excludepattern, $course->idnumber)) {
                continue;
            }
            $courses[] = $course;
            $creationdate = userdate($meta->timecreated);
            $a = (object)[
                'coursename' => $course->fullname,
                'creationtime' => $creationdate,
            ];
            $metalinktext = new lang_string('metalinktext', 'format_redirected', $a);
            $course->summary .= $metalinktext;
        }
        return $courses;
    }
    /**
     * Query the enrolment table for metalinks to this course.
     * @param int $courseid the id of the course.
     * @return array
     */
    public static function get_metalinks($courseid) {
        global $DB;
        return $DB->get_records('enrol', array('customint1' => $courseid, 'enrol' => 'meta'), 'courseid');
    }
    /**
     * Query the enrolment table for metabulklinks to this course.
     * Based on PR by @izendegi https://github.com/juacas/moodle-format_redirected/pull/3
     * @param int $courseid the id of the course.
     * @return array
     */
    public static function get_metabulklinks($courseid) {
        // Check if the metabulk plugin is installed.
        if (!enrol_is_enabled('metabulk')) {
            return [];
        }
        global $DB;
        $sql = "SELECT e.courseid, e.timecreated 
                  FROM {enrol_metabulk} as enrol 
                  JOIN {enrol} as e ON (enrol.enrolid = e.id)
                 WHERE enrol.courseid = :courseid";
        $params['courseid'] = $courseid;
        return $DB->get_records_sql($sql , $params);
    }
    /**
     * Returns true if the course has a front page.
     *
     * @return boolean false
     */
    public function has_view_page() {
        return true;
    }
}
