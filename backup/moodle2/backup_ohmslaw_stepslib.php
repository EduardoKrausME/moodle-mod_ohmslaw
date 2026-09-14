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
 * backup_ohmslaw_stepslib.php
 *
 * @package   mod_ohmslaw
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_ohmslaw_activity_structure_step extends backup_activity_structure_step {
    /**
     * Method define_structure.
     *
     * @return backup_nested_element Return value.
     */
    protected function define_structure(): backup_nested_element {
        $ohmslaw = new backup_nested_element("ohmslaw", ["id"], [
            "name", "intro", "introformat", "timecreated", "timemodified",
        ]);
        $ohmslaw->set_source_table("ohmslaw", ["id" => backup::VAR_ACTIVITYID]);
        $ohmslaw->annotate_files("mod_ohmslaw", "intro", null);
        return $this->prepare_activity_structure($ohmslaw);
    }
}
