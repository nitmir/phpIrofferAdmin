{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="base.tpl"}
{block name="title"}phpIroffer - bots management{/block}
{block name="description"}{/block}
{block name="navbar"}
{include file='navbar.tpl' page='admin'}
{/block}
{block name="container"}
    <h1>{'Iroffer User'|gettext}</h1>
    <h2>{'My infos'|gettext}</h2>
      <table class="table table-striped table-hover">
      {if $params.action == $action.edit_user && $params.values.0 == 'personal'}
        <form method="post" action="{action action=$action.edit_user type='post' params=$params}">
            <tr>
            <th>{'Name'|gettext}</th>
            <td>
                <input type="hidden" name="action" value="{$action.edit_user}"/>
                <input type="hidden" name="values[id]" value="{$user->id()}"/>
                <input type="hidden" name="values_old[name]" value="{$user->name()}"/>
                <input type="test" name="values[name]" value="{$user->name()}"/>
            </td>
            </tr>
            <tr>
                <th>{'Email'|gettext}</th>
                <td>
                    <input type="hidden" name="values_old[email]" value="{$user->email()}"/>
                    <input type="text" name="values[email]" value="{$user->email()}"/>
                </td>
            </tr>
            <tr>
                <th>{'Password'|gettext}</th>
                <td>
                    <input type="password" name="values[password1]" value="" style="width:100px;" placeholder="{'password'|gettext}"/><br/>
                    <input type="password" name="values[password2]" value="" style="width:100px;" placeholder="{'confirmation'|gettext}"/>
                </td>
            </tr>
            <tr><th>{'Last login'|gettext}</th><td>{$user->last_login()}</td></tr>
            <tr><th>{'Created'|gettext}</th><td>{$user->created()}</td></tr>
            <tr>
                <th></th>
                <td style="text-align:right;">
                    <input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary"/>
                    <a href="{view page='users' params=$params}" class="btn btn-primary">{'undo'|gettext}</a>
                </td>
            </tr>
        </form>
      {else}
      <tr><th>{'Name'|gettext}</th><td>{$user->name()}</td></tr>
      <tr><th>{'Email'|gettext}</th><td>{$user->email()}</td></tr>
      <tr><th>{'Password'|gettext}</th><td>*****</td></tr>
      <tr><th>{'Last login'|gettext}</th><td>{$user->last_login()}</td></tr>
      <tr><th>{'Created'|gettext}</th><td>{$user->created()}</td></tr>
      <tr><th></th><td style="text-align:right;"><a href="{action action=$action.edit_user type='get' params=$params values=['personal']}" class="btn btn-primary">{'edit'|gettext}</a></td></tr>
      {/if}
      </table>
      {if $user->right() == 'ADMIN' }
      <h2>{'User list'|gettext}</h2>
      <table class="table table-striped table-hover">
      <tr id="user_-1" >
      <th>{'Name'|gettext}</th>
      <th>{'Email'|gettext}</th>
      <th>{'Password'|gettext}</th>
      <th>{'Last login'|gettext}</th>
      <th>{'Created'|gettext}</th>
      <th>{'Rights'|gettext}</th>
      <th></th>
      </tr>
      {foreach $user_list as $key => $user}
      {if $params.action == $action.edit_user && $params.values.0 == $user->id()}
      <tr id="user_{$key}">
      <form method="post" action="{action action=$action.edit_user type='post' params=$params}">
        <td>
                        <input type="hidden" name="action" value="{$action.edit_user}"/>
            <input type="hidden" name="values[id]" value="{$user->id()}"/>
            <input type="hidden" name="values_old[name]" value="{$user->name()}"/>
            <input type="text" name="values[name]" value="{$user->name()}" style="width:100px;"/>
        </td>
          <td>
            <input type="hidden" name="values_old[email]" value="{$user->email()}" style="width:100px;"/>
            <input type="text" name="values[email]" value="{$user->email()}" style="width:100px;"/>
        </td>
          <td>
            <input type="password" name="values[password1]" value="" style="width:100px;" placeholder="{'password'|gettext}"/><br/>
            <input type="password" name="values[password2]" value="" style="width:100px;" placeholder="{'confirmation'|gettext}"/>
          </td>
        <td>{$user->last_login()}</td>
        <td>{$user->created()}</td>
          <td>
            <input type="hidden" name="values_old[right]" value="{$user->right()}" style="width:100px;" placeholder="{'password'|gettext}"/>
            <select name="values[right]">
            {foreach $config.level as $right}
            <option{if $user->right() == $right} selected{/if}>{$right}</option>
            {/foreach}
            </select>
          </td>
          <td style="text-align:right;"><input type="submit" name="submit" value="{'edit'|gettext}" class="btn btn-primary"> <a href="{view page='users' params=$params}#user_{$key - 1}" class="btn btn-primary">{'undo'|gettext}</a></td>
    </form>
    </tr>
    {elseif $params.action == $action.manage_user_bot && $params.values.0 == $user->id()}
    <tr id="user_{$key}">
    <td><a href="{view page='users' params=$params}#user_{$key - 1}">{$user->name()}</a></td>
      <td>{$user->email()}</td>
      <td>**********</td>
      <td>{$user->last_login()}</td>
      <td>{$user->created()}</td>
      <td>{$user->right()}</td>
      <td style="text-align:right;"></td>
    </tr>
    <form method="post" action="{action action=$action.manage_user_bot type='post' params=$params}">
    <tr>
    <td colspan="5"/>
    <input type="hidden" name="action" value="{$action.manage_user_bot}" />
    <input type="hidden" name="values[user]" value="{$user->id()}" />
    <input type="hidden" name="values[ancre]" value="{$key - 1}" />
    <ul class="column triple">
      {foreach $params.all_bots as $bot}
      <li>
          {if isset($params.user_bots[$bot->id()])}
              <input type="hidden" name="values_old[bots][]" value="{$bot->id()}" />
              <input type="checkbox" name="values[bots][]" value="{$bot->id()}" checked />
          {else}
            <input type="checkbox" name="values[bots][]" value="{$bot->id()}"/>
          {/if}
          {$bot->name()}
      </li>
      {/foreach}
    </ul>
    <td style="text-align:right;" colspan="2">
    <input type="submit" name="submit" value="{'save'|gettext}" class="btn btn-primary"/>
    <a href="{view page='users' params=$params}#user_{$key - 1}" class="btn btn-primary">{'close'|gettext}</a>
   </td>
    </td>
    </tr>
    </form>
    {else}
      <tr id="user_{$key}">
      <td><a href="{action action=$action.manage_user_bot type='get' params=$params values=[$user->id()]}#user_{$key - 1}" title="{"Manage user's bots"|gettext}">{$user->name()}</a></td>
      <td>{$user->email()}</td>
      <td>**********</td>
      <td>{$user->last_login()}</td>
      <td>{$user->created()}</td>
      <td>{$user->right()}</td>
      <td style="text-align:right;">
          <a href="{action action=$action.edit_user type='get' params=$params values=[$user->id()]}#user_{$key - 1}" class="btn btn-primary">{'edit'|gettext}</a>
          <a href="{action action=$action.delete_user type='get' params=$params values=[$user->id()]}" class="btn btn-primary" onclick="return confirm('{{{'Delete user %s?'|gettext}|sprintf:$user->name()}|escape:javascript}')">{'del'|gettext}</a></td>
      </tr>
      {/if}
      {/foreach}
      <tr>
      <form method="post" action="{action action=$action.create_user type='post' params=$params}">
          <td>
                  <input type="hidden" name="action" value="{$action.create_user}"/>
                  <input type="text" name="values[name]" value="" style="width:100px;" placeholder="{'name'|gettext}"/>
              </td>
          <td><input type="text" name="values[email]" value="" style="width:100px;" placeholder="{'email'|gettext}"/></td>
          <td>
            <input type="password" name="values[password1]" value="" style="width:100px;" placeholder="{'password'|gettext}"/><br/>
            <input type="password" name="values[password2]" value="" style="width:100px;" placeholder="{'confirmation'|gettext}"/>
          </td>
          <td colspan="3"></td>
          <td style="text-align:right;"><input type="submit" name="submit" value="{'Add'|gettext}" class="btn btn-primary"/></td>
    </form>
    </tr>
      </table>
      {/if}
{/block}

