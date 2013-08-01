<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>{block name="title"}{/block}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="{block name="description"}{/block}"/>
    <meta name="author" content="Valentin"/>

    {include file='styles.tpl'}

    <script src="{$ROOT}js/jquery.min.js" type="text/javascript"></script>
    <script src="{$ROOT}js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{$ROOT}js/bootbox.min.js" type="text/javascript"></script>
  </head>

  <body>
  {block name="assign"}{assign var="subpage" value=""}{/block}
  <div class="container main-container">
  {block name="navbar"}{/block}

    <div class="container top">
	{include file='message.tpl'}
	{block name="container"}{/block}
    </div>
    <div id="bottom"></div>
    </div>
  </body>
</html>
