#!/bin/bash
mysqldump -u root -p --no-data  --skip-add-drop-table $* | sed 's/CREATE TABLE/CREATE TABLE IF NOT EXISTS/g;s/ AUTO_INCREMENT=[0-9]*\b//g'
