{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="xdl"}{/block}
{block name="bot_title"}listing{if ($group) != ''} of group {$group}{/if}{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
<script language="javascript">
function newgroup(fld,len,idx) {
        if ((idx+1)==len) {
            var other='';
            other=prompt("Please indicate a new group name:");
            fld.options[idx].value=other;
            fld.options[idx].style.textAlign = 'left'
            fld.options[idx].text=other;
            fld.options[idx+1] = new Option('** New group **', '');
            fld.options[idx+1].style.textAlign = 'center'
        }
    }
function group(pack, file){
var div= '<div id="add_to_group">'+
    '<form class="form-horizontal" method="POST" action="bot_xdl.php?id={$bot["id"]}&amp;group={$group}" id="add_to_group_form">'+
        '<fieldset><legend style="white-space:nowrap;">' + file + '</legend>'+
        '<input name="group_pack_id" type="hidden" value="'+pack+'"/>'+
        '<input name="bot_id" type="hidden" value="{$bot['id']}"/>'+
        '<div class="control-group">'+
        '<label class="control-label" >Groups : </label>'+
        '<div class="controls"><select name="group_pack_select" onchange="newgroup(this,this.options.length,this.options.selectedIndex)">'+
        '<option{if '' == $group} selected{/if} value="MAIN">None</option>'+
    {foreach $groups as $g}
    '<option{if $g["name"] == $group} selected{/if}>{$g["name"]}</option>'+
    {/foreach}
    '<option  value="" style="text-align: center;">** New group **</option>'+
    '</select></div></div>'+
    '</fieldset>'+
    '</form>'+
    '</div>'

bootbox.dialog(div, [ {
"label" : "Save",
"class" : "btn-primary",
"callback": function() {
document.forms["add_to_group_form"].submit();
}
},{
"label" : "Cancel",
"class" : "btn-primary"
},]);
}
</script>
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
                        <form method="POST" action="bot_xdl.php?id={$bot['id']}&amp;group={$group}">
                            <td>
                                <input type="hidden" name="bot_id" value="{$bot['id']}"/>
                                <input type="hidden" name="pack_id" value="{$pack['pack']}"/>
                                <input type="text" name="pack" value="{$pack['pack']}" style="width:30px;"/>
                            </td>
                            <td>{$pack['downloaded']}</td>
                            <td>{$pack['file']}</td>
                            <td>{$pack['size']}</td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="edit" class="btn btn-primary"> <a href="bot_xdl.php?id={$bot['id']}&amp;group={$group}#pack_{$key - 1}" class="btn btn-primary">undo</a></td>
                        </form>
                    </tr>
                {else}
                    <tr id="pack_{$key}">
                        <td><a href="pack.php?bot={$bot['id']}&amp;pack={$pack['pack']}" title="detail">{$pack['pack']}</a></td>
                        <td>{$pack['downloaded']}</td>
                        <td>{$pack['file']}</td>
                        <td>{$pack['size']}</td>
                        <td style="text-align:right;">
                            <a href="?id={$bot['id']}&amp;group={$group}&amp;edit={$key}#pack_{$key - 1}" class="btn btn-primary" title="Change the pack number">edit</a>
                            <a class="btn btn-primary" onclick="group({$pack['pack']}, '{$pack['file']}')" title="Change the pack group">group</a>
                            <a href="?id={$bot['id']}&amp;group={$group}&amp;delpack={$pack['pack']}" class="btn btn-primary" title="Remove pack from the bot" onclick="return confirm('Removing pack #{$pack['pack']} - {$pack['file']} [{$pack['size']}] ?\n')">del</a>
                        </td>
                    </tr>
                {/if}
            {/foreach}
            {if ($group) != ''}
            <tr>
            <td style="text-align:right;" colspan="5"><a href="?id={$bot['id']}&amp;delall={$group}" class="btn btn-danger" title="Delete group and all contening packs" onclick="return confirm('Removing all packs of group {$group} ?\n')">delete all packs</a></td>
            </tr>
            {/if}
        </table>
    {if $group == '' && {$groups|@count} > 0}
        <h2>Groups listing</h2>
        <table class="table table-striped table-hover">
        <tr id="group_-1" >
            <th>name</th>
            <th>description</th>
            <th></th>
        </tr>
        {foreach $groups as $key => $group}
            {if $editgroup == $key }
                <tr id="group_{$key}">
            <form method="POST" action="bot_xdl.php?id={$bot['id']}">
                <td>
                    <input type="hidden" name="bot_id" value="{$bot['id']}"/>
                    <input type="hidden" name="group_old_name" value="{$group['name']}"/>
                    <input class="input-medium" type="text" name="group_name" value="{$group['name']}" style="width:150px;heigth:200px" placeholder="name"/>
                </td>
                <td>
                    <input type="hidden" name="group_old_description" value="{$group['description']}"/>
                    <input class="input-medium" type="text" name="group_description" value="{$group['description']}" style="width:100%;" placeholder="description"/>
                </td>
                <td style="text-align:right;"><input type="submit" name="submit" value="edit" class="btn btn-primary"> <a href="bot_xdl.php?id={$bot['id']}#group_{$key - 1}" class="btn btn-primary">undo</a></td>
            </form>
                </tr>
            {else}
                <tr id="group_{$key}">
                    <td><a href="?id={$bot['id']}&amp;group={$group['name']}">{$group['name']}</a></td>
                    <td>{$group['description']}</td>
                    <td style="text-align:right;">
                        <a href="?id={$bot['id']}&amp;editgroup={$key}#group_{$key - 1}" class="btn btn-primary" title="Change group name dans description">edit</a>
                        <a href="?id={$bot['id']}&amp;delgroup={$group['name']}#group_{$key - 1}" class="btn btn-primary" title="Move packs to no group" onclick="return confirm('Deleting {$group['name']} ?\nThis will put all packs in no group')">del</a>
                    </td>
                </tr>
            {/if}
        {/foreach}
    {/if}
<div style="display:none">
    <div id="add_to_group">
    <form method="POST" action="bot_xdl.php?id={$bot["id"]}&amp;group={$group}">
    <input type="hidden" value=""/>
    <select>
    {foreach $groups as $g}
    <option{if $g["name"] == $group} selected{/if}>{$g["name"]}</option>
    {/foreach}
    </select>
    <input type="text" />
    </form>
    </div>
</div>
{/block}

