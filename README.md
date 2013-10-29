# phpIrofferAdmin

This is a web interface to manage iroffer dinoex via the telnet interface of iroffer dinoex

a demo is avaible [here](http://xdcc-demo.genua.fr) with user `demo` and password `demo`

## Installation

### Requirements
 * php5.4
 * php mysql pdo
 * php smarty3 template engine
 * a mysql database for storing bots and users credentials
 
As using the php PDO for database access, it should be easy to adapt the sql schema to other database backends

### Instructions
Copy the file `includes/config.php.sample` to `includes/config.php` and edit with your database parameters.

Change the `ROOT` constant to the relative root path to phpIrofferAdmin directory.

Check the file `check_install.php` for some tests (for exemple testing if the template cache diretory `template_c` if writeble by php), 
import the database schema `includes/schema.sql` (if the database user in config.php is allowed to, otherwise, 
you must do it by hand) and allow you to create the first user to log in.

For nicer url, you can activate url rewrite by setting the constant `REWRITE_URL` to `true` in the `includes/config.php` file.
(rewrite's rules are in the `.htaccess` file)
