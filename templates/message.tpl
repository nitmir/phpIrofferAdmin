
{foreach $message_warning as $m}
<div class="alert alert-block"><button class="close" data-dismiss="alert" type="button">×</button>{$message_warning|@array_pop}</div>
{/foreach}
{foreach $message_error as $m}
<div class="alert alert-error"><button class="close" data-dismiss="alert" type="button">×</button>{$message_error|@array_pop}</div>
{/foreach}
{foreach $message_success as $m}
<div class="alert alert-success"><button class="close" data-dismiss="alert" type="button">×</button>{$message_success|@array_pop}</div>
{/foreach}
{foreach $message_info as $m}
<div class="alert alert-info"><button class="close" data-dismiss="alert" type="button">×</button>{$message_info|@array_pop}</div>
{/foreach}