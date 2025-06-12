# Change Log

All notable changes to this project will be documented in this file.

<u>Key words:</u>
- **Added**: Features, documentation or files are added to improve the plugin or its management.
- **Fixed**: Features, documentation or files are fixed.
- **Changed**: Features, parts of the code or files are changed, altering the plugin's behavior, visual appearance or the project's management.
- **Removed**: Comments, checks, files or other elements deemed unnecessary are removed from the code and project. In the case of comments, it is best to improve them if possible, or to group them together.

When an issue is resolved, ensure it is properly linked to the corresponding issue (E.g: `Fix [#1](/../../issues/1)`).

Additionally, make sure to acknowledge all contributors by adding their names to the [CONTRIBUTORS.md](CONTRIBUTORS.md) file.

## Table of Contents

- [1.1.1](#1.1.1)
- [1.1.0](#1.1.0)
- [1.0.0](#1.0.0)

## [1.1.1]

### Fixed
- Converted `$SESSION->wantsurl` from `moodle_url` object to string using `->out(false)` to prevent errors when Moodle tries to persist session data (e.g., during signup).

## [1.1.0]

### Added
- Admin interface to assign **redirect URLs to specific cohorts**.
- Support for adding **multiple cohort redirects** in a single form.
- Cohort dropdown that excludes already-assigned cohorts.
- Display of current cohort mappings in a table with delete icons.
- Option to exclude admins and/or managers from **cohort-based redirection**.
- Language support in **English and French**.

## [1.0.0]

### Added
- Initial release of the plugin.
- Global redirect after login to a configurable URL.
- Option to exclude **administrators** and/or **managers** from global redirection.
