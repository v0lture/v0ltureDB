# v0ltureDB
A web based application for managing MySQL databases without a desktop client by v0lture.

# This software is not complete and is currently missing major features
It is not recommended to use unless you want to give feedback this early but if you want to actively use the software please wait until an official release.

If you have any comments, questions or ideas, send an email to support@v0lture.com

We will not be held liable for any loss or damage to data or your servers or anything else that happens in using v0ltureDB. Your use of v0ltureDB is at your own risk.

## Installation

After downloading the repository extract the contents to the intended location you want to run it from.

For example `/var/www/html/v0lturedb/`.

### Requirements
v0ltureDB has been tested with PHP version `5.5` and `7` however it is expected to work with the version inbetween those.

It has also been tested with MySQL version `5.6.12` but is expected to work with most versions around that.

### Configuration Requirements
In order to use the configuration the user currently logged in as must have the `CREATE` and `INSERT` privilege in order to initialize the database and tables. This is only required to run once unless the database or table have been dropped.

Afterwards, as long as the user has the `SELECT` privilege the configuration will be applied.

## Local configuration
This is the configuration stored on your browser. Your selected language and theme are stored here so it works even without an active server connection.

To manage these settings, click on **Account Setup** in the user dropdown or **Language** if you are not logged in.

To reset these settings, under each category, press the **Reset** or **Restore...** button to reset that category to its defaults.

## Updating
As of `v0.0.1.9` there is now version checking. This does **not** install updates for you.

To install the latest update, redownload the master branch and extract again in the current installation folder.

It is recommended that you backup your current installation in case an update breaks a feature or is not supported by your server.

## Translating
View `translate.md` for details on translating v0ltureDB.

## Themes
**v0ltureDB Default** The preselected theme or the defaulted one whenever the selected theme is invalid or a fresh install.

**Dark** A black-to-grey background with white text, pleasant on the eyes.

**Matrix** Black background with green text, for all your stereotypical hacker needs.

## Changelogs
Changelogs are labeled as release.beta.alpha.nightly.

### 0.0.3.0 - 2017-02-08
:bulb: **BETA** Added new table support

:wrench: Minor adjustments to theming

### 0.0.2.4 - 2016-12-31
:bulb: Added redirect when user goes to auth.php and is logged in

:wrench: Fixed logout confirmation logging out no matter what button was pressed

:wrench: Fixed "Drop database" option disappearing when show_system_tables was set to "false"

:wrench: Fixed icon being wrong for config in database view when show_system_tables was set to "true"

:boom: Removed "Drop database" option from config database

### 0.0.2.3 - 2016-12-30
:wrench: Fixed config not creating properly

:wrench: Modified navbar to be cleaner and more accurate

:boom: Removed old variables from language file

### 0.0.2.2 - 2016-11-23
:bulb: Added username and host hints to auth page for direct linking username/host combos.

:wrench: Readded vanished logout code

:wrench: Fixed some typos

:bulb: Replaced `info.php` with more detailed information in local settings.

### 0.0.2.1 - 2016-11-23
:wrench: Correct version number

:wrench: Fixed issue where modals won't open due to init function changing

:wrench: Fixed some more cases of older use of open/close modals

:wrench: Improved UI on smaller displays

:wrench: Fixed issue where table no rows result was malformed

:bulb: Added theme support

:bulb: Themes added: Dark, Matrix

:x: Removed `settings_gui` flag and made settings load the GUI by default and no longer added support for the table editor

:wrench: Fixed bug where settings could not be accessed until running `prepConfig()` and `resetConfig()` manually

:wrench: Changed ?msg= errors to the warning handler and not the error handler

:bulb: Added database and table tracking in browser history

### 0.0.2.0 - 2016-11-22
:wrench: Improved a bunch of backend code

:x: Removed old code that is no longer in use

:speech_balloon: Removed more hardcoded text and placed it into translation file

:wrench: Instead of every MySQL error being reported as invalid credentials, we give to the actual error.

:wrench: Added support for user account with no password (with warning)

:bulb: Added language switching support

:raised_hands: Updated Materialize to v0.97.8

:wrench: Fixed code changes due to Materialize update

### 0.0.1.13 - 2016-10-27
:wrench: Improved some warning messages

:bulb: Redesigned and simplified login page

:wrench: Made some blue elements purple

### 0.0.1.12 - 2016-10-11
:bulb: Added idle timeout flag, redirects back to the login page after 10 minutes of inactivity.

:boom: Changed warning modal to a message that appears above the breadcrumb.

:x: Removed ability to hide table view

### 0.0.1.11 - 2016-08-11
:boom: Fixed scrolling issue in user dropdown from long usernames/hostnames

:boom: Fixed footer colors in modals not being correct

:boom: Removed unused '...' in navbar as it served no purpose

### 0.0.1.10 - 2016-08-03
:wrench: Fixes bug with `v0.0.1.9` where if v0ltureDB was using the latest version it would still show an update prompt.

:bulb: Added view for when the version checking service is unavailable.

### 0.0.1.9 - 2016-08-02
:bulb: Added 3 new flags `login_update_check` for checking updates at login, `updates_config` which updates the configuration whenever a new update has been installed, `updates_allowed` for disabling/enabling support for updating, and `global_update_notice` to toggle the visibility of the notice of any future updates.

:bulb: Added updates view in settings (requires `settings_gui` to be enabled)

:bulb: Added v0ltureDB's new logo in the navigation bar

:wrench: Some minor text and styling changes

**this version update checking is supported but not update installation**

### 0.0.1.8 - 2016-07-25
:wrench: Fixed the information page being broken since v0.0.1.5

:one: Unified all the css elements into one singular css file for easier theming

:bulb: Added another system database under the `show_system_tables` flag

:wrench: Some visual changes in the readme

### 0.0.1.7 - 2016-07-22
:wrench: Improved ways of adding new flags to be a bit easier

:bulb: Added Update Configuration option which will update your config to support any new flags without wiping your old changes

### 0.0.1.6
:bulb: Added settings menu that replaces the old version broken by the UI changes

:x: Removed sudo_mode flag

:wrench: Changed the default value of `limit_col_count` to `false`, set `settings_gui` to `true`

:boom: Fixed a bug where direct settings database and table caused the settings menu not to load.

:boom: Updated Readme with more instructions!

### 0.0.1.5
:bulb: Redesigned the entire UI with Material Design in mind

:boom: Added another config flag `show_system_tables` which toggles visibility of the system related tables like **MySQL**, **performance_schema**, **information_schema**, and **sys**.

:one: Simplified majority of view/edit functions into one page to minimize amount of page switching

:boom: Changed add button behavior from adding a new row to just opening the FAB menu

:boom: Fixed bug where setting `show_system_tables` to `false` broke the database view on the side.
