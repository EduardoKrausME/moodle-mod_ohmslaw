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
 * view.php
 *
 * @package   mod_ohmslaw
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . "/../../config.php");

$id = required_param("id", PARAM_INT);

$cm = get_coursemodule_from_id("ohmslaw", $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$ohmslaw = $DB->get_record("ohmslaw", ["id" => $cm->instance], "*", MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability("mod/ohmslaw:view", $context);

$event = \mod_ohmslaw\event\course_module_viewed::create([
    "objectid" => $ohmslaw->id,
    "context" => $context,
]);
$event->add_record_snapshot("course", $course);
$event->add_record_snapshot("ohmslaw", $ohmslaw);
$event->trigger();

$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$PAGE->set_url("/mod/ohmslaw/view.php", ["id" => $cm->id]);
$PAGE->set_title(format_string($ohmslaw->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);
$PAGE->requires->js_call_amd("mod_ohmslaw/calculator", "init");

$data = [
    "name" => format_string($ohmslaw->name),
    "hasintro" => trim($ohmslaw->intro) !== "",
    "intro" => format_module_intro("ohmslaw", $ohmslaw, $cm->id),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template("mod_ohmslaw/calculator", $data);
echo $OUTPUT->footer();
