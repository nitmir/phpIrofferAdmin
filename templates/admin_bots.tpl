{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="base.tpl"}
{block name="title"}phpIroffer - bots management{/block}
{block name="description"}{/block}
{block name="navbar"}
{include file='navbar.tpl' page='admin'}
{/block}
{block name="container"}
	<h1>{'Manage bots'|gettext}</h1>
      <table class="table table-striped table-hover">
      <tr id="bot_0" >
      <th>{'name'|gettext}</th>
      <th>{'host'|gettext}</th>
      <th>{'port'|gettext}</th>
      <th>{'password'|gettext}</th>
      <th>{'created'|gettext}</th>
      <th></th>
      </tr>
      {foreach $bot_list as $key => $bot}
      {if $params.action == $action.edit_bot && $params.values.0 == $bot.id}
      <tr id="bot_{$key}">
      <form method="POST" action="{action action=$action.edit_bot type='post' params=$params}">
		<td>
			<input type="hidden" name="action" value="{$action.edit_bot}"/>
			<input type="hidden" name="values[id]" value="{$bot.id}"/>
			<input type="text" name="values[name]" value="{$bot.name}" style="width:100px;"/>
		</td>
	      <td><input type="text" name="values[host]" value="{$bot.host}" style="width:100px;"/></td>
	      <td><input type="text" name="values[port]" value="{$bot.port}" style="width:40px;"/></td>
	      <td><input type="password" name="values[password]" value="" style="width:100px;"/></td>
	      <td>{$bot.created}</td>
	      <td style="text-align:right;">
	          <input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary">
	          <a href="{view page='bot_management' params=$params}#bot_{$key - 1}" class="btn btn-primary">{'undo'|gettext}</a>
              </td>
	</form>
	</tr>
	{else}
      <tr id="bot_{$key}">
      <td>{$bot.name}</td>
      <td>{$bot.host}</td>
      <td>{$bot.port}</td>
      <td>**********</td>
      <td>{$bot.created}</td>
      <td style="text-align:right;">
	<a href="{action action=$action.edit_bot type='get' params=$params values=[$bot.id]}#bot_{$key - 1}" class="btn btn-primary">{'edit'|gettext}</a>
	<a href="{action action=$action.delete_bot type='get' params=$params values=[$bot.id]}" class="btn btn-primary">{'del'|gettext}</a>
      </td>
      </tr>
      {/if}
      {/foreach}
      <tr>
      <form method="POST" action="{action action=$action.create_bot type='post' params=$params}">
	      <td><input type="text" name="values[name]" value="" style="width:100px;" placeholder="{'name'|gettext}" /></td>
	      <td><input type="text" name="values[host]" value="" style="width:100px;" placeholder="{'hostname'|gettext}"/></td>
	      <td><input type="text" name="values[port]" value="" style="width:40px;" placeholder="{'port'|gettext}"/></td>
	      <td><input type="password" name="values[password]" value="" style="width:100px;" placeholder="{'password'|gettext}"/></td>
	      <td><input type="hidden" name="action" value="{$action.create_bot}" /></td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="{'add'|gettext}" class="btn btn-primary"></td>
	</form>
	</tr>
      </table>
{/block}

