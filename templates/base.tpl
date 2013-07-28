<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{block name="title"}{/block}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{block name="description"}{/block}">
    <meta name="author" content="Valentin">

    {include file='styles.tpl'}
    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js"></script>
  </head>

  <body>
  {block name="assign"}{assign var="subpage" value=""}{/block}
  <div class="container main-container">
  {block name="navbar"}{/block}

    <div class="container">
	{include file='message.tpl'}
	{block name="container"}{/block}
    </div> 
    <div id="bottom"></div>
    </div>
  </body>
</html>
