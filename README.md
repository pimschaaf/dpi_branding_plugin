# dpi_branding_plugin
DPI WordPress branding plugin

## Installation
See readme.txt.

## What it does
Adds a menu option for administrators under 'Settings', leading to a page with settings, in tabs.

### Dashboard tab
Ment to clean up the dashboard and brand it with DPI corperate branding. Provides options to set up two DPI widgets and remove default WordPress widgets.

### Login tab
Provides options to style the login page. Falls back to DPI corperate branding.

### WordPress tab
Provides options to disable non-essential WordPress features. The master-switch is provided here, to disable all additions that can be enabled on this tab in one click.

* Disable toolbar: Overwrites user settings to disable the admin toolbar on the WordPress front end. Prevents the toolbar CSS from being loaded. 
* Disable RDS Support: If you don't need Really Simple Discovery services (e.g. pingbacks) use this option to remove the RSD link from the `<head>`.
* Disable WLW Support: Removes the link from the `<head>` for Windows Live Writer Support.
* Disable generator: The generator meta tag shows the installed WordPress version. You might want to hide this for security reasons.
* Disable WP 4.2 emoji styles: Removes CSS in the `<head>` for emoji support.
* Add pingback link: Typically, themes add the pingback link. You can do this with this option if your theme does not.

### Pagespeed tab
Provides the option to remove query strings (version tags) from static resources.

### Google
**Untested**
Manage Google Analytics code through the CMS.

### Social
Completely disable comments and pingbacks on front- and backend to prevent spam.
