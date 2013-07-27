{extends file="base.tpl"} 
{block name="title"}{$bot['name']} - {block name="bot_title"}{/block}{/block}
{block name="description"}{$bot['name']} - {block name="bot_description"}{/block}{/block}
{block name="navbar"}
{include file='navbar.tpl' page='bots' subpage="$subpage"}
{/block}
{block name="container"}
	<h1>{$bot['name']}</h1>
{include file='bot_nav.tpl' page='bots' subpage="$subpage"}
{block name="bot_container"}
{/block}
{/block}

