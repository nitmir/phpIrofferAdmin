{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{while $m=$messages->warning()}
<div class="alert alert-block"><strong>{'Warning:'|gettext}</strong> <button class="close" data-dismiss="alert" type="button">×</button>{$m|nl2br}</div>
{/while}
{while $m=$messages->error()}
<div class="alert alert-error"><strong>{'Error:'|gettext}</strong> <button class="close" data-dismiss="alert" type="button">×</button>{$m|nl2br}</div>
{/while}
{while $m=$messages->success()}
<div class="alert alert-success"><strong>{'Success:'|gettext}</strong> <button class="close" data-dismiss="alert" type="button">×</button>{$m|nl2br}</div>
{/while}
{while $m=$messages->info()}
<div class="alert alert-info"><strong>{'Info:'|gettext}</strong> <button class="close" data-dismiss="alert" type="button">×</button>{$m|nl2br}</div>
{/while}
