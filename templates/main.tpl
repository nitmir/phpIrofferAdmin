{extends file="base.tpl"} 
{block name="title"}phpIroffer - desk{/block}
{block name="description"}phpIroffer index page{/block}
{block name="navbar"}
{include file='navbar.tpl' page='home'}
{/block}
{block name="container"}
      <h1>Iroffer Admin</h1>
      <table class="table table-striped table-hover">
      {foreach $bot_list as $b}
      <tr>
      <th>{$b['name']}</th>
      <td><a href="{view page='bot_listing' params=['bot_id' => $b['id'], 'group' => '']}">Pack listing</a></td>
      <td><a href="{view page='files_listing' params=['bot_id' => $b['id'], 'path' => '']}">Add files</a></td>
      <td><a href="{view page='bot_console' params=['bot_id' => $b['id']]}">Run command</a></td>
      </tr>
      {/foreach}
      </table>
{/block}

