{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="listul"}{/block}
{block name="bot_title"}Add files{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
	<h2>File listing</h2>
	<h4>{$path}</h4>
      <table class="table table-striped table-hover">
      <tr>
      <th>name</th>
      <th>size</th>
      <th></th>
      </tr>
      {if $path!=''}<tr><td><a href="?id={$bot['id']}&path={$path_parent}">..</a></td><td/><td/></tr>{/if}
      {foreach $files as $key => $file}
      <tr id="pack_{$key}">
      {if $file['size'] == '=DIR=' }
      <td><a href="?id={$bot['id']}&amp;path={$path}/{$file['name']}">{$file['name']}</a></td>
      <td> - </td>
      <td style="text-align:right;">
	<a href="?id={$bot['id']}&amp;deldir={$path}/{$file['name']}&amp;path={$path}" class="btn btn-primary" title="Remove every pack found in {$file['name']}" onclick="return confirm('Remove every pack found in {$file['name']} ?')">del</a>
	<a href="?id={$bot['id']}&amp;adddir={$path}/{$file['name']}&amp;path={$path}" class="btn btn-primary" title="Add every file in {$file['name']}" onclick="return confirm('Add every file in {$file['name']}')">add</a>
     </td>
      {else}
      <td>{$file['name']}</td>
      <td>{$file['size']}</td>
      <td style="text-align:right;"><a href="?id={$bot['id']}&amp;add={$path}/{$file['name']}&amp;path={$path}" class="btn btn-primary">add</a></td>
      {/if}
      
      </tr>
      {/foreach}
      </table>
{/block}

