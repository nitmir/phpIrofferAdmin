{extends file="navbar_base.tpl"} 
{block name="navbar_link"}main.php{/block}
{block name="navbar_buttons"}
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li{nav_active name='home' page="$page"}><a href="main.php">Home </a></li>
              <li{nav_active name='admin' page="$page" class='dropdown'}>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<i class="caret"></i></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="admin_users.php">User information</a></li>
			<li><a href="admin_bots.php">Manage Bots</a></li>
			{if $user['right'] == 'ADMIN' }<li><a href="admin_bots_users.php">Assign bots to users</a></li>{/if}
		</ul>
		</li>
		<li{nav_active name='bots' page="$page" class='dropdown'}>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bots<i class="caret"></i></a>
		<ul class="dropdown-menu" role="menu">
		{foreach $bot_list as $b}
		    <li{nav_active name="{$b['id']}" page="{$bot['id']}" class="dropdown-submenu"}>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$b['name']}</a>
			<ul class="dropdown-menu" role="menu">
				<li{nav_active name="{$b['id']}xdl" page="{$bot['id']}$subpage"}><a href="bot_xdl.php?id={$b['id']}">Packs listing</a></li>
				<li{nav_active name="{$b['id']}listul" page="{$bot['id']}$subpage"}><a href="bot_listul.php?id={$b['id']}">Add files</a></li>
				<li{nav_active name="{$b['id']}command" page="{$bot['id']}$subpage"}><a href="bot_command.php?id={$b['id']}">Run a command</a></li>
			</ul>
		    </li>
		{/foreach}
		</ul>
		</li>
		<li style="text-align:right;"><a href="?logout=1" class="logout_link" ><i class="icon-off icon-white"></i> Logout</a></li>
            </ul>
	    
          </div><!--/.nav-collapse -->
{/block}