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

namespace local_redirectafterlogin;

class observer
{


    public static function user_loggedin(\core\event\user_loggedin $event)
    {
        global $SESSION, $DB;

        $enabled = get_config('local_redirectafterlogin', 'enableplugin');
        if (!$enabled) {
            return;
        }

        $redirecturl    = get_config('local_redirectafterlogin', 'redirecturl');
        $includeadmin   = get_config('local_redirectafterlogin', 'includeadmin');
        $includemanager = get_config('local_redirectafterlogin', 'includemanager');

        $user    = $event->get_record_snapshot('user', $event->objectid);
        $isadmin = is_siteadmin($user);

        $syscontext     = \context_system::instance();
        $hasmanagerrole = user_has_role_assignment($user->id, 1, $syscontext->id);
        // 1 = manager role id.
        // Skip redirect if user is admin AND exclude admin.
        if ($isadmin && !$includeadmin) {
            return;
        }

        // Skip redirect if user is manager AND exclude manager.
        if ($hasmanagerrole && !$includemanager) {
            return;
        }

        // Only reach here if user is included for redirection.
        // Load cohort mappings.
        $cohortmappings = json_decode(get_config('local_redirectafterlogin', 'cohortmappings'), true);
        if (!is_array($cohortmappings)) {
            $cohortmappings = [];
        }

        // Get user’s cohort IDs.
        $usercohortids = $DB->get_fieldset_sql(
            '
            SELECT cm.cohortid
              FROM {cohort_members} cm
             WHERE cm.userid = ?',
            [$user->id]
        );

        // Check for matching cohort mapping.
        foreach ($usercohortids as $cohortid) {
            if (isset($cohortmappings[$cohortid])) {
                $SESSION->wantsurl = (new \moodle_url($cohortmappings[$cohortid]))->out(false);
                return;
                // Stop → cohort redirect takes priority.
            }
        }

        // No cohort redirect → fallback to global.
        if (!empty($redirecturl)) {
            $SESSION->wantsurl = ( new \moodle_url($redirecturl))->out(false);
        }

    }//end user_loggedin()


}//end class
