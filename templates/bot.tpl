{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="base.tpl"}
{block name="title"}{$params.bot->name()} - {block name="bot_title"}{/block}{/block}
{block name="description"}{$params.bot->name()} - {block name="bot_description"}{/block}{/block}
{block name="navbar"}
{include file='navbar.tpl' page='bots' subpage="$subpage"}
{/block}
{block name="container"}
	<h1>{$params.bot->name()}</h1>
{include file='bot_nav.tpl' page='bots' subpage="$subpage"}
{block name="bot_container"}
{/block}
{/block}

