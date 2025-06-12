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

$plugin->component = 'local_redirectafterlogin';
$plugin->version   = 2025040302;
$plugin->requires  = 2022112800;
// Moodle 4.1 minimum.
$plugin->supported = [
    401,
    500,
];
$plugin->release = '1.1.1';
