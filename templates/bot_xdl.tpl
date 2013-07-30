{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="xdl"}{/block}
{block name="bot_title"}listing{if ($params.group) != ''} of group {$params.group}{/if}{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
<script language="javascript">
function get_info(pack) {
    var json = null;
    $.ajax({
        url: "{$ROOT}get_info.php",
        type: 'get',
        async: false,
        data: { bot_id: "{$params.bot.id}", pack: pack },
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
                {foreach ['bot_id', 'group'] as $key}
                '<input name="values_old[{$key}]" type="hidden" value="{$params[$key]}"/>'+
                {/foreach}
                '<input name="values_old[pack]" type="hidden" value="'+pack+'"/>'+
                '<input name="values_old[description]" type="hidden" value="'+ file + '"/>'+
                '<table class="table table-striped table-hover">'+
                    '<tr><th colspan="2"><span id="sendname">'+info['sendname']+'</span></th></tr>'+
                    '<tr>'+
                        '<th>{'pack:'|gettext}</th>'+
                        '<td><input name="values[pack]" type="text" value="'+ pack + '" style="width:95%"/></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>{'Description:'|gettext}</th>'+
                        '<td><input name="values[description]" type="text" value="'+ file + '" style="width:95%"/></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<th>{'Groups:'|gettext}</th>'+
                        '<td>'+
                            '<select name="values[group]" onchange="newgroup(this,this.options.length,this.options.selectedIndex)" style="width:95%">'+
                                '<option{if '' == $params.group} selected{/if} value="MAIN">{"None"|gettext}</option>'+
                                {foreach $groups as $g}
                                '<option{if $g["name"] == $params.group} selected{/if}>{$g["name"]}</option>'+
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
    {if {$packs|@count} > 0 }
    <h2>{if ($params.group) != ''}{'Packs listing of group %s'|gettext|sprintf:{$params.group}}{else}{'Packs listing'|gettext}{/if}</h2>
        <table class="table table-striped table-hover">
            <tr id="pack_-1">
                <th>n°</th>
                <th>{'hit'|gettext}</th>
                <th>{'description'|gettext}</th>
                <th>{'size'|gettext}</th>
                <th style="text-align:right;">{if ($params.group) != ''}<a href="{view page='bot_listing' params=$params group=''}" class="btn btn-primary">{'back'|gettext}</a></br>{/if}</th>
            </tr>
            {foreach $packs as $key => $pack}
                <tr id="pack_{$key}">
                    <td><a href="#pack_{{$key} - 1}" title="{'detail'|gettext}">{$pack['pack']}</a></td>
                    <td>{$pack['downloaded']}</td>
                    <td>{$pack['file']}</td>
                    <td>{$pack['size']}</td>
                    <td style="text-align:right;white-space:nowrap;">
                        <a class="btn btn-primary" onclick="group({$pack['pack']}, '{$pack.file|escape:javascript}')" >{'edit'|gettext}</a>
                        <a href="{action action=$action.delete_pack type='get' params=$params values=[$pack.pack]}" class="btn btn-primary" title="{'Remove pack from the bot'|gettext}" onclick="return confirm('{'Removing pack #%s - %s [%s] ?'|gettext|sprintf:{$pack['pack']}:{$pack['file']}:{$pack['size']}}')">del</a>
                    </td>
                </tr>
            {/foreach}
            {if ($params.group) != ''}
            <tr>
            <td style="text-align:right;" colspan="5"><a href="{action action=$action.delete_all_pack_from_group type='get' params=$params values=[$params.group]}" class="btn btn-danger" title="{'Delete group and all contening packs'|gettext}" onclick="return confirm('{'Removing all packs of group %s?'|gettext|sprintf:{$params.group}}')">{'delete all packs'|gettext}</a></td>
            </tr>
            {/if}
        </table>
        {/if}
    {if $params.group == '' && {$groups|@count} > 0}
        <h2>{'Groups listing'|gettext}</h2>
        <table class="table table-striped table-hover">
        <tr id="group_-1" >
            <th>{'name'|gettext}</th>
            <th>{'description'|gettext}</th>
            <th></th>
        </tr>
        {foreach $groups as $key => $group}
            {if $params.action == $action.edit_group && $params.values.0 == $group.name }
                <tr id="group_{$key}">
            <form method="POST" action="{action action=$action.edit_group type='post' params=$params}">
                {foreach ['name' => $group.name, 'description' => $group.description] as $k => $value}
                <td>
                    <input type="hidden" name="values_old[{$k}]" value="{$value}"/>
                    <input class="input-medium" type="text" name="values[{$k}]" value="{$value}" style="width:100%;heigth:200px" placeholder="{$k|gettext}"/>
                </td>
                {/foreach}
                <td style="text-align:right;">
                    <input type="hidden" name="action" value="{$action.edit_group}"/>
                    <input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary">
                    <a href="{view page='bot_listing' params=$params}#group_{$key - 1}" class="btn btn-primary">{'undo'|gettext}</a>
                </td>
            </form>
                </tr>
            {else}
                <tr id="group_{$key}">
                    <td><a href="{view page='bot_listing' params=$params group=$group.name}">{$group['name']}</a></td>
                    <td>{$group['description']}</td>
                    <td style="text-align:right;">
                        <a href="{action action=$action.edit_group type='get' params=$params values=[$group.name]}#group_{$key - 1}" class="btn btn-primary" title="{'Change group name or description'|gettext}">{'edit'|gettext}</a>
                        <a href="{action action=$action.delete_group type='get' params=$params values=[$group.name]}#group_{$key - 1}" class="btn btn-primary" title="{'Move packs to no group'|gettext}" onclick="return confirm('{'Deleting %s ?\nThis will put all packs in no group'|gettext|sprintf:{$group['name']}}')">{'del'|gettext}</a>
                    </td>
                </tr>
            {/if}
        {/foreach}
    {/if}
{/block}

