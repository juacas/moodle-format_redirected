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
 * Settings for format_redirected
 *
 * @package    format_redirected
 * @copyright  2021 Juan Pablo de Castro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_confightmleditor(
        'format_redirected/noticeforteachers',
        new lang_string('format_redirected_noticeforteachers', 'format_redirected'),
        new lang_string('format_redirected_noticeforteachers_desc', 'format_redirected'),
        new lang_string('format_redirected_defaultnoticeforteachers', 'format_redirected'),
        PARAM_RAW,
        '60',
        '8'
    ));
    $settings->add(new admin_setting_confightmleditor(
        'format_redirected/noticeforstudents',
        new lang_string('format_redirected_noticeforstudents', 'format_redirected'),
        new lang_string('format_redirected_noticeforstudents_desc', 'format_redirected'),
        new lang_string('format_redirected_defaultnoticeforstudents', 'format_redirected'),
        PARAM_RAW,
        '60',
        '8'
    ));
    // Pattern to match the course idnumber to exclude from the list of courses to redirect to.
    $settings->add(new admin_setting_configtext(
        'format_redirected/excludepattern',
        new lang_string('excludepattern', 'format_redirected'),
        new lang_string('excludepattern_desc', 'format_redirected'),
        '^(TIT-.*|DEMO-.*)$',
        PARAM_TEXT
    ));
}
