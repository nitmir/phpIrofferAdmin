{extends file="base.tpl"} 
{block name="title"}{$bot['name']} - listing{if ($group) != ''} of group {$group}{/if}{/block}
{block name="description"}phpIroffer index page{/block}
{block name="navbar"}
{include file='navbar.tpl' page='bots' subpage='xdl'}
{/block}
{block name="container"}
	<h1>{$bot['name']}</h1>
	<h2>Packs listing{if ($group) != ''} of group {$group}{/if}</h2>
      <table class="table table-striped table-hover">
      <tr>
      <th>n°</th>
      <th>hit</th>
      <th>file</th>
      <th>size</th>
      <th style="text-align:right;">{if ($group) != ''}<a href="?id={$bot['id']}" class="btn btn-primary">back</a></br>{/if}</th>
      </tr>
      {foreach $packs as $key => $pack}
      {if $edit == $key}
      <tr id="pack_{$key}">
      <form method="POST" action="bot_xdl.php?id={$bot['id']}">
		<td>
			<input type="hidden" name="bot_id" value="{$bot['id']}"/>
			<input type="hidden" name="pack_id" value="{$pack['pack']}"/>
			<input type="text" name="pack" value="{$pack['pack']}" style="width:30px;"/>
		</td>
	      <td>{$pack['downloaded']}</td>
	      <td>{$pack['file']}</td>
	      <td>{$pack['size']}</td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="edit" class="btn btn-primary"> <a href="bot_xdl.php?id={$bot['id']}&group={$group}#pack_{$key - 1}" class="btn btn-primary">undo</a></td>
	</form>
	</tr>
	{else}
      <tr id="pack_{$key}">
      <td>{$pack['pack']}</td>
      <td>{$pack['downloaded']}</td>
      <td>{$pack['file']}</td>
      <td>{$pack['size']}</td>
      <td style="text-align:right;"><a href="?id={$bot['id']}&group={$group}&edit={$key}#pack_{$key - 1}" class="btn btn-primary">edit</a> <a href="?id={$bot['id']}&group={$group}&del={$key}" class="btn btn-primary">del</a></td>
      </tr>
      {/if}
      {/foreach}
      </table>
      {if {$groups|@count}>0 }
      <h2>Groups listing</h2>
      <table class="table table-striped table-hover">
      <tr id="group_-1" >
      <th>name</th>
      <th>description</th>
      <th></th>
      </tr>
      {foreach $groups as $key => $group}
      <tr id="group_{$key}">
      <td><a href="?id={$bot['id']}&group={$group['name']}">{$group['name']}</a></td>
      <td>{$group['description']}</td>
      <td style="text-align:right;"><a href="?id={$bot['id']}&editgroup={$key}#group_{$key - 1}" class="btn btn-primary">edit</a></td>
      </tr>
      {/foreach}
      </table>
      {/if}
{/block}

