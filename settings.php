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
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig && isset($ADMIN)) {
    $settings = new admin_settingpage('local_redirectafterlogin', get_string('pluginname', 'local_redirectafterlogin'));

    $settings->add(new admin_setting_configcheckbox(
        'local_redirectafterlogin/enableplugin',
        get_string('enableplugin', 'local_redirectafterlogin'),
        get_string('enableplugin_desc', 'local_redirectafterlogin'),
        1
    ));

    $settings->add(new admin_setting_configtext(
        'local_redirectafterlogin/redirecturl',
        get_string('redirecturl', 'local_redirectafterlogin'),
        get_string('redirecturl_desc', 'local_redirectafterlogin'),
        '/my/'
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_redirectafterlogin/includeadmin',
        get_string('includeadmin', 'local_redirectafterlogin'),
        get_string('includeadmin_desc', 'local_redirectafterlogin'),
        0
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_redirectafterlogin/includemanager',
        get_string('includemanager', 'local_redirectafterlogin'),
        get_string('includemanager_desc', 'local_redirectafterlogin'),
        0
    ));


    $ADMIN->add('localplugins', $settings);

    $ADMIN->add('localplugins', new admin_externalpage(
        'local_redirectafterlogin_mapping',
        get_string('cohortredirectmappings', 'local_redirectafterlogin'),
        new moodle_url('/local/redirectafterlogin/mapping.php')
    ));
}
