<?php

require('require.php');

session_name($_CONFIG['session_name']);
session_start();
login_require();
params();
action();
session_write_close();
