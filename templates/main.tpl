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
      <td><a href="bot_xdl.php?id={$b['id']}">Pack listing</a></td>
      <td><a href="bot_listul.php?id={$b['id']}">Add files</a></td>
      <td><a href="bot_command.php?id={$b['id']}">Run command</a></td>
      </tr>
      {/foreach}
      </table>
{/block}

