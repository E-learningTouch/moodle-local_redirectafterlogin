# Redirect After Login

## Table of Contents

- [Multiple Enrollments](#multiple-enrollments)
- [Table of Contents](#table-of-contents)
- [:bookmark_tabs: About The Project](#bookmark_tabs-about-the-project)
  - [:sparkles: Features](#sparkles-features)
    - [Global Redirection](#global-redirection)
    - [Cohort-based Redirection](#cohort-based-redirection)
  - [:repeat: Redirection Logic](#repeat-redirection-logic)
- [:gear: Installation](#gear-installation)
  - [:mortar_board: Moodle Way](#mortar_board-moodle-way)
  - [:wrench: Manual](#wrench-manual)
  - [:octocat: Using Git](#octocat-using-git)
- [:book: Documentation](#book-documentation)

## :bookmark_tabs: About The Project

This Moodle plugin allows administrators to define custom redirection behavior after user login. It supports both **global redirects** and **cohort-based redirects**, giving you fine-grained control over post-login navigation.

### :sparkles: Features

#### Global Redirection

- Redirect all users to a specific URL after login (e.g. `/my/`, a course, or a dashboard).
- Option to exclude **administrators** and/or **managers**.

#### Cohort-based Redirection

- Assign specific redirect URLs to individual cohorts.
- Cohorts already mapped are hidden from the dropdown to avoid duplicates.
- Add multiple cohort mappings in a single form.
- Display of existing mappings in a table with delete icons.
- Option to exclude **admins** and/or **managers**.

### :repeat: Redirection Logic

1. If the user belongs to a cohort with a defined redirect → they are redirected to that URL (first match wins).
2. If no cohort match → global redirect applies.
3. If neither is defined → Moodle default behavior is used.
4. Exclusion rules for admins and managers are respected.

## :gear: Installation

For more information, see the [official plugin installation guide](https://docs.moodle.org/en/Installing_plugins).

### :mortar_board: Moodle Way

1. Download the latest version or source code of the plugin compatible with your Moodle platform.
2. Go to your platform's plugin installation page: `Site administration > Plugins > Install plugins`.
3. Upload the plugin file and follow the installation process.

### :wrench: Manual

1. Download the latest version or source code of the plugin compatible with your Moodle platform.
2. Navigate to the `moodle/local` directory on your platform.
3. Unzip the plugin into the directory and make sure that the folder containing the plugin files is named `redirectafterlogin`.

### :octocat: Using Git

1. Open a terminal and navigate to the `moodle/local` directory on your platform.
2. Clone the project using the following command:  
   `git clone https://github.com/E-learningTouch/moodle-local_redirectafterlogin redirectafterlogin`
