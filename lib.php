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
 * lib.php
 *
 * @package   mod_ohmslaw
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the list of Moodle features supported by this activity.
 *
 * @param string $feature
 * @return mixed
 */
function ohmslaw_supports(string $feature) {
    return match ($feature) {
        FEATURE_MOD_ARCHETYPE => MOD_ARCHETYPE_OTHER,
        FEATURE_MOD_INTRO => true,
        FEATURE_SHOW_DESCRIPTION => true,
        FEATURE_COMPLETION_TRACKS_VIEWS => true,
        FEATURE_BACKUP_MOODLE2 => true,
        default => null,
    };
}

/**
 * Adds a new Ohm's law activity.
 *
 * @param stdClass $data
 * @param mod_ohmslaw_mod_form|null $mform
 * @return int
 */
function ohmslaw_add_instance(stdClass $data, ?mod_ohmslaw_mod_form $mform = null): int {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = time();

    return $DB->insert_record("ohmslaw", $data);
}

/**
 * Updates an Ohm's law activity.
 *
 * @param stdClass $data
 * @param mod_ohmslaw_mod_form|null $mform
 * @return bool
 */
function ohmslaw_update_instance(stdClass $data, ?mod_ohmslaw_mod_form $mform = null): bool {
    global $DB;

    $data->id = $data->instance;
    $data->timemodified = time();

    return $DB->update_record("ohmslaw", $data);
}

/**
 * Deletes an Ohm's law activity.
 *
 * @param int $id
 * @return bool
 */
function ohmslaw_delete_instance(int $id): bool {
    global $DB;

    if (!$DB->record_exists("ohmslaw", ["id" => $id])) {
        return false;
    }

    $DB->delete_records("ohmslaw", ["id" => $id]);
    return true;
}
