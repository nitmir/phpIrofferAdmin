{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="base.tpl"}
{block name="title"}phpIroffer - desk{/block}
{block name="description"}phpIroffer index page{/block}
{block name="navbar"}
{include file='navbar.tpl' page='home'}
{/block}
{block name="container"}
      <h1>{'Iroffer Admin'|gettext}</h1>
      <h2>{'Links to bots admin'|gettext}</h2>
      <table class="table table-striped table-hover">
      {foreach $user->bots() as $b}
      <tr>
      <th>{$b->name()}</th>
      <td><a href="{view page='bot_listing' params=['bot_id' => $b->id(), 'group' => '']}">{'Packs listing'|gettext}</a></td>
      <td><a href="{view page='files_listing' params=['bot_id' => $b->id(), 'path' => '']}">{'Add files'|gettext}</a></td>
      <td><a href="{view page='bot_console' params=['bot_id' => $b->id()]}">{'Console'|gettext}</a></td>
      </tr>
      {/foreach}
      </table>
      <h2>{'Bots status'|gettext}</h2>
	<table class="table table-striped table-hover">
      {foreach $user->bots() as $b}
      <tr>
      <th>{$b->name()}</th>
      <td>{$status[$b->id()]}</td>
      </tr>
      {/foreach}
      </table>
{/block}

