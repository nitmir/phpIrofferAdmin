<?php

require('require.php');

session_name($_CONFIG['session_name']);
session_start();
messages();
login_require();
params();
action();
