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
<script>
function get_status(bot_id, span_id){
$.get('{$ROOT}run_command.php', { bot_id: bot_id, command: "STATUS" })
.done(function(data) {
document.getElementById(span_id).innerHTML=data.substring(data.indexOf("\n"));
});
}
function get_info(bot_id){
$.get('{$ROOT}run_command.php', { bot_id: bot_id, command: "BOTINFO" })
.done(function(data) {
alert(data.substring(data.indexOf("\n")));
});
}
</script>
    <script type="text/javascript">
        $(document).ready(function(){
        $('#main_table').dataTable(dataTablesDefaultsParams({
          "aoColumns": [
            { "bSortable": false },
            { "bSortable": false, "bSearchable": false },
            { "bSortable": false, "bSearchable": false },
            { "bSortable": false, "bSearchable": false }
          ],
          "iDisplayLength": 10
        }));
      });
    </script>
      <h1>{'Iroffer Admin'|gettext}</h1>
      <h2>{'Links to bots admin'|gettext}</h2>
      <table class="table table-striped table-hover" id="main_table">
      {foreach $user->bots() as $b}
      <tr>
      <th>{$b->name()}</th>
      <td><a href="{view page='bot_listing' params=['bot_id' => $b->id(), 'group' => '']}">{'Packs listing'|gettext}</a></td>
      <td><a href="{view page='files_listing' params=['bot_id' => $b->id(), 'path' => '']}">{'Add files'|gettext}</a></td>
      <td><a href="{view page='bot_console' params=['bot_id' => $b->id()]}">{'Console'|gettext}</a></td>
      </tr>
      {/foreach}
      </table>
      <br/>
      <h2>{'Bots status'|gettext}</h2>
	<table class="table table-striped table-hover" id="main_table2">
      {foreach $user->bots() as $b}
      <tr>
      <th onclick="get_info({$b->id()})"><a href="#" title="{'detailed info'|gettext}">{$b->name()}</a></th>
      <td><span id="bot_status_{$b->id()}"></span><script>get_status({$b->id()}, 'bot_status_{$b->id()}');</script></td>
      <td onclick="get_status({$b->id()}, 'bot_status_{$b->id()}');"><a href="#" class="icon-refresh icon-black" title="{'refresh status'|gettext}"></a></td>
      </tr>
      {/foreach}
      </table>
{/block}

