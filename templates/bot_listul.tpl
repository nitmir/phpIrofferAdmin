{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="listul"}{/block}
{block name="bot_title"}{'File listing'|gettext}{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
	{if $params.path=='/'}{$params.path=''}{/if}
	<h2>{'File listing'|gettext}</h2>
	<h4>{$params.path}</h4>
      <table class="table table-striped table-hover">
      <tr>
      <th>{'name'|gettext}</th>
      <th>{'size'|gettext}</th>
      <th></th>
      </tr>
      {if $params.path != ''}<tr><td><a href="{view page='files_listing' params=$params path="{$params.path|dirname}"}">..</a></td><td/><td/></tr>{/if}
      {foreach $files as $key => $file}
      <tr id="pack_{$key}">
      {if $file['size'] == '=DIR=' }
      <td><a href="{view page='files_listing' params=$params path="{$params.path}/{$file.name}"}">{$file['name']}</a></td>
      <td> - </td>
      <td style="text-align:right;">
	<a href="{action action=$action.delete_dir type='get' params=$params param="{$params.path}/{$file.name}"}" class="btn btn-primary" title="{'Remove every pack found in %s'|gettext|sprintf:{$file['name']}}" onclick="return confirm('{'Remove every pack found in %s?'|gettext|sprintf:{$file['name']}}')">del</a>
	<a href="{action action=$action.add_dir type='get' params=$params param="{$params.path}/{$file.name}"}" class="btn btn-primary" title="{'Add every file in %s'|gettext|sprintf:{$file['name']}}" onclick="return confirm('{'Add every file in %s?'|gettext|sprintf:{$file['name']}}')">add</a>
     </td>
      {else}
      <td>{$file.name}</td>
      <td>{$file.size}</td>
      <td style="text-align:right;"><a href="{action action=$action.add_file type='get' params=$params param="{$params.path}/{$file.name}"}" class="btn btn-primary">add</a></td>
      {/if}
      
      </tr>
      {/foreach}
      </table>
{/block}

