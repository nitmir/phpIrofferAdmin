{extends file="base.tpl"} 
{block name="title"}{$bot['name']} - files list{/block}
{block name="description"}phpIroffer index page{/block}
{block name="navbar"}
{include file='navbar.tpl' page='bots' subpage='listul'}
{/block}
{block name="container"}
	<h1>{$bot['name']}</h1>
	<h2>File listing</h2>
	<h4>{$path}</h4>
      <table class="table table-striped table-hover">
      <tr>
      <th>name</th>
      <th>size</th>
      <th></th>
      </tr>
      <tr><td><a href="?id={$bot['id']}&path={$path_parent}">..</a></td><td/><td/></tr>
      {foreach $files as $key => $file}
      <tr id="pack_{$key}">
      {if $file['size'] == '=DIR=' }
      <td><a href="?id={$bot['id']}&path={$path}/{$file['name']}">{$file['name']}</a></td>
      <td> - </td>
      <td style="text-align:right;"><a href="?id={$bot['id']}&deldir={$path}/{$file['name']}" class="btn btn-primary">del</a> <a href="?id={$bot['id']}&adddir={$path}/{$file['name']}" class="btn btn-primary">add</a></td>
      {else}
      <td>{$file['name']}</td>
      <td>{$file['size']}</td>
      <td style="text-align:right;"><a href="?id={$bot['id']}&add={$path}/{$file['name']}" class="btn btn-primary">add</a></td>
      {/if}
      
      </tr>
      {/foreach}
      </table>
{/block}

