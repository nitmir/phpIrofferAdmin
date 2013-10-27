{*
* This file is part of phpIrofferAdmin.
*
* (c) 2013 Valentin Samir
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*}
{extends file="base.tpl"}
{block name="title"}phpIroffer - {'login'|gettext}{/block}
{block name="description"}phpIroffer login page{/block}
{block name="navbar"}
{include file='navbar_base.tpl'}
{/block}
{block name="container"}
      <form class="form-signin" method="post" action="{action type='post' action=$action.login params=[]}">
        <h2 class="form-signin-heading">{'Please sign in'|gettext}</h2>
        <input type="text" class="input-block-level" placeholder="{'Login'|gettext}" name="iroffer_username"/>
        <input type="password" class="input-block-level" placeholder="{'Password'|gettext}" name="iroffer_password"/>
        <button class="btn btn-large btn-primary" type="submit">{'Sign in'|gettext}</button>
      </form>
{/block}

