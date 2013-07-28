#!/bin/bash
cat `find ../ -name '*.php' | grep -v templates_c` <(cat ../templates/*.tpl | ./tpl_to_php_gettext.php) | xgettext -L php - -o iroffer_php_admin.pot
