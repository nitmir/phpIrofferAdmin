{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>{block name="title"}{/block}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="{block name="description"}{/block}"/>
    <meta name="author" content="Valentin"/>

    {include file='styles.tpl'}

    {include file='javascript.tpl'}
  </head>

  <body>
  {block name="assign"}{assign var="subpage" value=""}{/block}
  <div class="container main-container">
  {block name="navbar"}{/block}

    <div class="container top">
	{include file='message.tpl'}
	{block name="container"}{/block}
    </div>
<br/><br/><br/>
    <div id="bottom"><a href="https://github.com/nitmir/phpIrofferAdmin">{'phpIrofferAdmin on github'|gettext}</a></div>
    </div>
  </body>
</html>
