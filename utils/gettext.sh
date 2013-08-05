#!/bin/bash -x
mkdir -p template_introspection/
for file in ../templates/*.tpl; do
	cat $file | ./tpl_to_php_gettext.php > template_introspection/`basename $file`.php
done
find ../ -name '*.php' | grep -v '^../templates_c/' > to_translate.txt
xgettext -L php -f to_translate.txt -o iroffer_php_admin.pot
#cat `find ../ -name '*.php' | grep -v templates_c` <(cat ../templates/*.tpl | ./tpl_to_php_gettext.php) | xgettext -L php - -o iroffer_php_admin.pot
