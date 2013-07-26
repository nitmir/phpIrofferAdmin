{extends file="base.tpl"} 
{block name="title"}phpIroffer - bots management{/block}
{block name="description"}{/block}
{block name="navbar"}
{include file='navbar.tpl' page='admin'}
{/block}
{block name="container"}
	<h1>Iroffer Users</h1>
	<h2>My infos</h2>
      <table class="table table-striped table-hover">
      <tr><th>Name</th><td>{$user['name']}</td></tr>
      <tr><th>Email</th><td>{$user['email']}</td></tr>
      <tr><th>Password</th><td>*****</td></tr>
      <tr><th>Last login</th><td>{$user['last_login']}</td></tr>
      <tr><th>Created</th><td>{$user['created']}</td></tr>
      <tr><th></th><td style="text-align:right;"><a href="?edit=personal" class="btn btn-primary">edit</a></td></tr>
      </table>
      {if $user['right'] == 'ADMIN' }
      <h2>User list</h2>
      <table class="table table-striped table-hover">
      <tr id="user_0" >
      <th>Name</th>
      <th>Email</th>
      <th>Password</th>
      <th>Last login</th>
      <th>Created</th>
      <th></th>
      </tr>
      {foreach $user_list as $key => $user}
      {if $edit == $key}
      <tr id="user_{$key}">
      <form method="POST" action="admin_users.php">
		<td>
			<input type="hidden" name="user_id" value="{$user['id']}"/>
			<input type="text" name="name" value="{$user['name']}" style="width:100px;"/>
		</td>
	      <td><input type="text" name="email" value="{$user['email']}" style="width:100px;"/></td>
	      <td>
			<input type="password" name="password1" value="" style="width:100px;" placeholder="password"/><br/>
			<input type="password" name="password2" value="" style="width:100px;" placeholder="confirmation"/>
	      </td>
		<td>{$user['last_login']}</td>
		<td>{$user['created']}</td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="edit" class="btn btn-primary"> <a href="admin_users.php#user_{$key - 1}" class="btn btn-primary">undo</a></td>
	</form>
	</tr>
	{else}
      <tr id="user_{$key}">
      <td>{$user['name']}</td>
      <td>{$user['email']}</td>
      <td>**********</td>
      <td>{$user['last_login']}</td>
      <td>{$user['created']}</td>
      <td style="text-align:right;"><a href="?edit={$key}#user_{$key - 1}" class="btn btn-primary">edit</a> <a href="?del={$key}" class="btn btn-primary">del</a></td>
      </tr>
      {/if}
      {/foreach}
      <tr>
      <form method="POST" action="admin_bots.php">
	      <td><input type="text" name="name" value="" style="width:100px;" placeholder="name"/></td>
	      <td><input type="text" name="email" value="" style="width:100px;" placeholder="email"/></td>
	      <td>
			<input type="password" name="password1" value="" style="width:100px;" placeholder="password"/><br/>
			<input type="password" name="password2" value="" style="width:100px;" placeholder="confirmation"/>
	      </td>
	      <td></td>
	      <td></td>
	      <td style="text-align:right;"><input type="submit" name="submit" value="add" class="btn btn-primary"></td>
	</form>
	</tr>
      </table>
      {/if}
{/block}

