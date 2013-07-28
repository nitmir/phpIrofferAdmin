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
      {if $edit == $key}
      <tr id="bot_{$key}">
      <form method="POST" action="admin_bots.php">
		<td>
			<input type="hidden" name="bot_id" value="{$bot['id']}"/>
			<input type="text" name="name" value="{$bot['name']}" style="width:100px;"/>
		</td>
	      <td><input type="text" name="host" value="{$bot['host']}" style="width:100px;"/></td>
	      <td><input type="text" name="port" value="{$bot['port']}" style="width:40px;"/></td>
	      <td><input type="password" name="password" value="" style="width:100px;"/></td>
	      <td>{$bot['created']}</td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary"> <a href="admin_bots.php#bot_{$key - 1}" class="btn btn-primary">{'undo'|gettext}</a></td>
	</form>
	</tr>
	{else}
      <tr id="bot_{$key}">
      <td>{$bot['name']}</td>
      <td>{$bot['host']}</td>
      <td>{$bot['port']}</td>
      <td>**********</td>
      <td>{$bot['created']}</td>
      <td style="text-align:right;"><a href="?edit={$key}#bot_{$key - 1}" class="btn btn-primary">{'edit'|gettext}</a> <a href="?del={$key}" class="btn btn-primary">{'del'|gettext}</a></td>
      </tr>
      {/if}
      {/foreach}
      <tr>
      <form method="POST" action="admin_bots.php">
		<td><input type="text" name="name" value="" style="width:100px;" placeholder="{'name'|gettext}" /></td>
	      <td><input type="text" name="host" value="" style="width:100px;" placeholder="{'hostname'|gettext}"/></td>
	      <td><input type="text" name="port" value="" style="width:40px;" placeholder="{'port'|gettext}"/></td>
	      <td><input type="password" name="password" value="" style="width:100px;" placeholder="{'password'|gettext}"/></td>
	      <td></td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="{'add'|gettext}" class="btn btn-primary"></td>
	</form>
	</tr>
      </table>
{/block}

