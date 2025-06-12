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
 * Version information.
 *
 * Redirect After Login - This Moodle plugin allows administrators to define custom redirection behavior after user login.
                          It supports both global redirects and cohort-based redirects,
                          giving you fine-grained control over post-login navigation
 *
 * @package   local_redirectafterlogin
 * @copyright 2025 E-learning Touch' <contact@elearningtouch.com> (Maintainer)
 * @copyright 2025 Samar Al Khalil <155988552+Sam-elearning@users.noreply.github.com> (Coder)
 * @author    Samar Al Khalil <155988552+Sam-elearning@users.noreply.github.com> (Coder)
 * @license   https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once __DIR__.'/../../config.php';
require_once $CFG->libdir.'/adminlib.php';
require_once $CFG->dirroot.'/cohort/lib.php';
require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url(new moodle_url('/local/redirectafterlogin/mapping.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('cohortredirectmappings', 'local_redirectafterlogin'));
$PAGE->set_heading(get_string('cohortredirectmappings', 'local_redirectafterlogin'));

require_once $CFG->libdir.'/formslib.php';

// Load saved mappings.
$mappings = json_decode(get_config('local_redirectafterlogin', 'cohortmappings'), true) ?: [];

// Handle delete action.
$deletecohortid = optional_param('delete', null, PARAM_INT);
if ($deletecohortid !== null) {
    unset($mappings[$deletecohortid]);
    set_config('cohortmappings', json_encode($mappings), 'local_redirectafterlogin');
    redirect(new moodle_url('/local/redirectafterlogin/mapping.php'), get_string('changessaved'));
}

class cohort_redirect_form extends moodleform
{


    public function definition()
    {
        $mform = $this->_form;

        // Load cohorts.
        $cohorts       = cohort_get_all_cohorts(0, 0, 0);
        $cohortoptions = [];
        foreach ($cohorts['cohorts'] as $cohort) {
            $cohortoptions[$cohort->id] = format_string($cohort->name);
        }

        // Remove already mapped cohorts.
        $mappings = ($this->_customdata['mappings'] ?? []);
        foreach ($mappings as $usedid => $url) {
            unset($cohortoptions[$usedid]);
        }

        $availablecount = count($cohortoptions);

        if ($availablecount == 0) {
            $mform->addElement('static', 'nocohorts', '', get_string('allcohortsassigned', 'local_redirectafterlogin'));
        } else {
            // Define repeat elements.
            $repeatarray   = [
                $mform->createElement('select', 'cohortid', get_string('cohort', 'cohort'), $cohortoptions),
                $mform->createElement('text', 'redirecturl', get_string('redirecturl', 'local_redirectafterlogin')),
            ];
            $repeatoptions = [
                'redirecturl' => [
                    'default' => '',
                    'type'    => PARAM_RAW,
                ],
            ];

            $this->repeat_elements(
                $repeatarray,
                1,
                // Always initialize with 1 input only.
                $repeatoptions,
                'mapping_repeats',
                'mapping_add_fields',
                ($availablecount - 1 > 0 ? 1 : 0),
                // Add button only if more unmapped cohorts.
                get_string('addmappings', 'local_redirectafterlogin')
            );

            $this->add_action_buttons();
        }//end if

    }//end definition()


    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        foreach ($data['redirecturl'] as $index => $url) {
            if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL) && strpos($url, '/') !== 0) {
                $errors["redirecturl[$index]"] = get_string('invalidurl', 'local_redirectafterlogin');
            }
        }

        return $errors;

    }//end validation()


}//end class

// Create form.
$mform = new cohort_redirect_form(null, ['mappings' => $mappings]);

// Process form.
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/admin/search.php#linkmodules'));
} else if ($data = $mform->get_data()) {
    foreach ($data->cohortid as $index => $cohortid) {
        $url = trim($data->redirecturl[$index]);
        if (!empty($url)) {
            $mappings[$cohortid] = $url;
        }
    }

    set_config('cohortmappings', json_encode($mappings), 'local_redirectafterlogin');
    redirect(new moodle_url('/local/redirectafterlogin/mapping.php'), get_string('changessaved'));
}

// Output.
echo $OUTPUT->header();
$mform->display();

// Show saved mappings table.
if (!empty($mappings)) {
    echo html_writer::tag('h3', get_string('existingmappings', 'local_redirectafterlogin'));

    $table       = new html_table();
    $table->head = [
        get_string('cohort', 'cohort'),
        get_string('redirecturl', 'local_redirectafterlogin'),
        get_string('delete'),
    ];

    foreach ($mappings as $cohortid => $url) {
        $cohort     = $DB->get_record('cohort', ['id' => $cohortid]);
        $cohortname = $cohort ? format_string($cohort->name, true, ['context' => context::instance_by_id($cohort->contextid)])." (ID {$cohortid})" : "Cohorte ID {$cohortid}";

        $deleteurl     = new moodle_url('/local/redirectafterlogin/mapping.php', ['delete' => $cohortid]);
        $deleteicon    = $OUTPUT->action_icon($deleteurl, new pix_icon('t/delete', get_string('delete')));
        $table->data[] = [
            $cohortname,
            $url,
            $deleteicon,
        ];
    }

    echo html_writer::table($table);
}//end if

echo html_writer::tag(
    'p',
    html_writer::link(
        new moodle_url('/admin/settings.php', ['section' => 'local_redirectafterlogin']),
        get_string('backtosettings', 'local_redirectafterlogin')
    )
);

echo $OUTPUT->footer();
