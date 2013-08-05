{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="listul"}{/block}
{block name="bot_title"}{'File listing'|gettext}{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
<script type="text/javascript">
//<![CDATA[
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
function add_dir(path, dir){
        var div= ''+
        '<div>'+
            '<form class="form-horizontal" method="POST" action="{action action=$action.add_dir type='post' params=$params}" id="add_dir_form">'+
                '<input name="action" type="hidden" value="{$action.add_dir}"/>'+
                '<input name="values[dir]" type="hidden" value="'+path + '/' + dir+'"/>'+
                '<table class="table table-striped table-hover">'+
                    '<tr>'+
                        '<th colspan="3"><span id="sendname">'+path + '/' + dir+'</span></th>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="white-space: nowrap">{'Add every file in directory:'|gettext}</td>'+
                        '<td><input name="values[add_type]" type="radio" value="ADDDIR"/></td><td></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="white-space: nowrap">{'Add new file in directory:'|gettext}</td>'+
                        '<td><input name="values[add_type]" type="radio" value="ADDNEW" style="width:95%"/></td><td></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td style="white-space: nowrap">{'Add new file in directory to group:'|gettext}</td>'+
                        '<td style="width:10px"><input name="values[add_type]" type="radio" value="ADDGROUP" style="width:95%" id="add_dir_group"/></td>'+
                        '<td>'+
                            '<select name="values[group]" onchange="newgroup(this,this.options.length,this.options.selectedIndex)" onclick="document.getElementById(\'add_dir_group\').checked = true"style="width:95%">'+
                                '<option></option>'+
                                {foreach $groups as $g}
                                '<option>{$g["name"]}</option>'+
                                {/foreach}
                                '<option  value="" style="text-align: center;">** {"New group"|gettext} **</option>'+
                            '</select>'+
                        '</td>'+
                    '</tr>'+
                '</table>' +
            '</form>'+
        '</div>';

    bootbox.dialog(div, [
        {
            "label" : "{'Save'|gettext}",
            "class" : "btn-primary",
            "callback": function() {
                document.forms["add_dir_form"].submit();
            }
        },
        {
            "label" : "{'Cancel'|gettext}",
            "class" : "btn-primary"
        },
    ]);
    $('#file_path').css("width", Math.max($("#sendname").width(), 530) - $("#file_path_th").width() + "px");
}
//]]>
</script>
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
    <a href="{action action=$action.delete_dir type='get' params=$params values=["{$params.path}/{$file.name}"]}" class="btn btn-primary" title="{'Remove every pack found in %s'|gettext|sprintf:{$file['name']}}" onclick="return confirm('{'Remove every pack found in %s?'|gettext|sprintf:{$file['name']}}')">{'del'|gettext}</a>
    <a href="#" class="btn btn-primary" title="{'Add every file in %s'|gettext|sprintf:{$file['name']}}" onclick="add_dir('{$params.path}', '{$file['name']}')">{'add'|gettext}</a>
     </td>
      {else}
      <td>{$file.name}</td>
      <td>{$file.size}</td>
      <td style="text-align:right;"><a href="{action action=$action.add_file type='get' params=$params values=["{$params.path}/{$file.name}"]}" class="btn btn-primary">{'add'|gettext}</a></td>
      {/if}

      </tr>
      {/foreach}
      </table>
{/block}

