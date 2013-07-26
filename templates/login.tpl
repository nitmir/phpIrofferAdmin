{extends file="base.tpl"} 
{block name="title"}phpIroffer - login{/block}
{block name="description"}phpIroffer login page{/block}
{block name="navbar"}
{include file='navbar_base.tpl'}
{/block}
{block name="container"}
      <form class="form-signin" method="POST" action="main.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="Login" name="iroffer_username">
        <input type="password" class="input-block-level" placeholder="Password" name="iroffer_password">
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
{/block}

