{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="xdl"}{/block}
{block name="bot_title"}listing{if ($group) != ''} of group {$group}{/if}{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
<script language="javascript">
function get_info(pack) {
	var json = null;
    $.ajax({
        url: "get_info.php",
        type: 'get',
        async: false,
        data: { id: "{$bot['id']}", pack: pack },
        success: function(data) {
            json = $.parseJSON(data);
        } 
     });
	return json;
}

function newgroup(fld,len,idx) {
        if ((idx+1)==len) {
            var other='';
            other=prompt("{'Please indicate a new group name:'|gettext}");
            fld.options[idx].value=other;
            fld.options[idx].style.textAlign = 'left'
            fld.options[idx].text=other;
            fld.options[idx+1] = new Option("** {'New group'|gettext} **", '');
            fld.options[idx+1].style.textAlign = 'center'
        }
    }
function group(pack, file){
    var info = get_info(pack);
    if(info){
        var div= ''+
        '<div id="add_to_group">'+
            '<form class="form-horizontal" method="POST" action="{action action=$action.edit_pack type='post' params=$params}" id="edit_form">'+
                '<input name="action" type="hidden" value="{$action.edit_pack}"/>'+
                '<input name="pack_id" type="hidden" value="'+pack+'"/>'+
                '<input name="bot_id" type="hidden" value="{$bot['id']}"/>'+
                '<input name="old_group" type="hidden" value="{if ($group) != ''}{$group}{else}MAIN{/if}"/>'+
                '<input name="old_pack_description" type="hidden" value="'+ file + '"/>'+
                '<table class="table table-striped table-hover">'+
                    '<tr><th colspan="2"><span id="sendname">'+info['sendname']+'</span></th></tr>'+
                    '<tr>'+
                        '<th>{'pack:'|gettext}</th>'+
                        '<td><input name="pack" type="text" value="'+ pack + '" style="width:95%"/></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>{'Description:'|gettext}</th>'+
                        '<td><input name="pack_description" type="text" value="'+ file + '" style="width:95%"/></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>{'Groups:'|gettext}</th>'+
                        '<td>'+
                            '<select name="group" onchange="newgroup(this,this.options.length,this.options.selectedIndex)" style="width:95%">'+
                                '<option{if '' == $group} selected{/if} value="MAIN">{"None"|gettext}</option>'+
                                {foreach $groups as $g}
                                '<option{if $g["name"] == $group} selected{/if}>{$g["name"]}</option>'+
                                {/foreach}
                                '<option  value="" style="text-align: center;">** {"New group"|gettext} **</option>'+
                            '</select>'+
                        '</td>'+
                    '</tr>'+
                    '<tr class="hide-little-height">'+
                        '<th>{'CRC 32:'|gettext}</th>'+
                        '<td>'+info['crc32']+'</td>'+
                    '</tr>'+
                    '<tr class="hide-little-height">'+
                        '<th>{'md5 sum:'|gettext}</th>'+
                        '<td>'+info['md5sum']+'</td>'+
                    '</tr>'+
                    '<tr class="hide-little-height">'+
                        '<th>{'Last Modified:'|gettext}</th>'+
                        '<td>'+info['last modified']+'</td>'+
                    '</tr>'+
                    '<tr class="hide-little-height">'+
                        '<th id="file_path_th">{'Path:'|gettext}</th>'+
                        '<td><div style="overflow-x:auto;white-space:nowrap;height:40px" id="file_path">'+info['filename']+'</div></td>'+
                    '</tr>'+
                '</table>' + 
            '</form>'+
        '</div>';
    } else {
        var div = '{'error getting pack informations'|gettext}';
    }

    bootbox.dialog(div, [ 
        {
            "label" : "{'Save'|gettext}",
            "class" : "btn-primary",
            "callback": function() {
                document.forms["edit_form"].submit();
            }
        },
        {
            "label" : "{'Cancel'|gettext}",
            "class" : "btn-primary"
        },
    ]);
    $('#file_path').css("width", $("#sendname").width() - $("#file_path_th").width() + "px");
}
</script>
    <h2>{if ($group) != ''}{'Packs listing of group %s'|gettext|sprintf:{$group}}{else}{'Packs listing'|gettext}{/if}</h2>
        <table class="table table-striped table-hover">
            <tr id="pack_-1">
                <th>n°</th>
                <th>{'hit'|gettext}</th>
                <th>{'description'|gettext}</th>
                <th>{'size'|gettext}</th>
                <th style="text-align:right;">{if ($group) != ''}<a href="{view page='bot_listing' params=$params group=''}" class="btn btn-primary">{'back'|gettext}</a></br>{/if}</th>
            </tr>
            {foreach $packs as $key => $pack}
                <tr id="pack_{$key}">
                    <td><a href="#pack_{{$key} - 1}" title="{'detail'|gettext}">{$pack['pack']}</a></td>
                    <td>{$pack['downloaded']}</td>
                    <td>{$pack['file']}</td>
                    <td>{$pack['size']}</td>
                    <td style="text-align:right;white-space:nowrap;">
                        <a class="btn btn-primary" onclick="group({$pack['pack']}, '{$pack['file']}')" >{'edit'|gettext}</a>
                        <a href="{action action=$action.delete_pack type='get' params=$params param=$pack.pack}" class="btn btn-primary" title="{'Remove pack from the bot'|gettext}" onclick="return confirm('{'Removing pack #%s - %s [%s] ?'|gettext|sprintf:{$pack['pack']}:{$pack['file']}:{$pack['size']}}')">del</a>
                    </td>
                </tr>
            {/foreach}
            {if ($group) != ''}
            <tr>
            <td style="text-align:right;" colspan="5"><a href="?id={$bot['id']}&amp;delall={$group}" class="btn btn-danger" title="{'Delete group and all contening packs'|gettext}" onclick="return confirm('{'Removing all packs of group %s?'|gettext|sprintf:{$group}}')">{'delete all packs'|gettext}</a></td>
            </tr>
            {/if}
        </table>
    {if $group == '' && {$groups|@count} > 0}
        <h2>{'Groups listing'|gettext}</h2>
        <table class="table table-striped table-hover">
        <tr id="group_-1" >
            <th>{'name'|gettext}</th>
            <th>{'description'|gettext}</th>
            <th></th>
        </tr>
        {foreach $groups as $key => $group}
            {if $params.action == $action.edit_group && $params.param == $group.name }
                <tr id="group_{$key}">
            <form method="POST" action="{action action=$action.edit_group type='post' params=$params}">
                <td>
                    <input type="hidden" name="bot_id" value="{$bot['id']}"/>
                    <input type="hidden" name="group_old_name" value="{$group['name']}"/>
                    <input class="input-medium" type="text" name="group_name" value="{$group['name']}" style="width:150px;heigth:200px" placeholder="{'name'|gettext}"/>
                </td>
                <td>
                    <input type="hidden" name="group_old_description" value="{$group['description']}"/>
                    <input class="input-medium" type="text" name="group_description" value="{$group['description']}" style="width:100%;" placeholder="{'description'|gettext}"/>
                </td>
                <td style="text-align:right;"><input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary"> <a href="{view page='bot_listing' params=$params}#group_{$key - 1}" class="btn btn-primary">{'undo'|gettext}</a></td>
            </form>
                </tr>
            {else}
                <tr id="group_{$key}">
                    <td><a href="{view page='bot_listing' params=$params group=$group.name}">{$group['name']}</a></td>
                    <td>{$group['description']}</td>
                    <td style="text-align:right;">
                        <a href="{action action=$action.edit_group type='get' params=$params param=$group.name}#group_{$key - 1}" class="btn btn-primary" title="{'Change group name or description'|gettext}">{'edit'|gettext}</a>
                        <a href="{action action=$action.delete_group type='get' params=$params param=$group.name}#group_{$key - 1}" class="btn btn-primary" title="{'Move packs to no group'|gettext}" onclick="return confirm('{'Deleting %s ?\nThis will put all packs in no group'|gettext|sprintf:{$group['name']}}')">{'del'|gettext}</a>
                    </td>
                </tr>
            {/if}
        {/foreach}
    {/if}
{/block}

