# phpIrofferAdmin

This is a web interface to manage iroffer dinoex via the telnet interface of iroffer dinoex

a demo is avaible at [here](http://xdcc-demo.genua.fr) (ipv6 only) with user `demo` and password `demo`

## Installation

### Requirements
 * php pdo
 * php smarty3 template engine
 * a sql database for storing bots and users credentials

### Instructions
Copy the file `includes/config.php.sample` to `includes/config.php` and edit with your database parameters.

Change the `ROOT` constant to the relative root path to phpIrofferAdmin dir.

Check the file `check_install.php` for some tests (for exemple testing if the template cache diretory `template_c` if writeble by php), 
import the database schema `includes/schema.sql` (if the database user if config.php is allowed to, otherwise, 
you must do it by hand) and allow you to create the first user to log in.

For nicer url, you can activate url rewrite by setting the constant `REWRITE_URL` to `true` in the `includes/config.php` file.
(rewrite's rules are in the `.htaccess` file)
