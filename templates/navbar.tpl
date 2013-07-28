{extends file="navbar_base.tpl"} 
{block name="navbar_link"}{view page='main' params=$params}{/block}
{block name="navbar_buttons"}
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li{nav_active name='home' page="$page"}><a href="{view page='main' params=$params}">{'Home'|gettext}</a></li>
              <li{nav_active name='admin' page="$page" class='dropdown'}>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{'Parameters'|gettext}<i class="caret"></i></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="admin_users.php">{'User information'|gettext}</a></li>
			<li><a href="admin_bots.php">{'Manage Bots'|gettext}</a></li>
			{if $user['right'] == 'ADMIN' }<li><a href="admin_bots_users.php">{'Assign bots to users'|gettext}</a></li>{/if}
		</ul>
		</li>
		<li{nav_active name='bots' page="$page" class='dropdown'}>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{'Bots'|gettext}<i class="caret"></i></a>
		<ul class="dropdown-menu" role="menu">
		{foreach $bot_list as $b}
		    <li{nav_active name="{$b['id']}" page="{$bot['id']}" class="dropdown-submenu"}>
			<a href="{view page='bot_listing' params=$params group='' bot_id={$b['id']}}" class="dropdown-toggle" data-toggle="dropdown-submenu">{$b['name']}</a>
			<ul class="dropdown-menu" role="menu">
				<li{nav_active name="{$b['id']}xdl" page="{$bot['id']}$subpage"}><a href="{view page='bot_listing' params=$params group='' bot_id={$b['id']}}">{'Packs listing'|gettext}</a></li>
				<li{nav_active name="{$b['id']}listul" page="{$bot['id']}$subpage"}><a href="{view page='files_listing' params=$params path='' bot_id={$b['id']}}">{'Add files'|gettext}</a></li>
				<li{nav_active name="{$b['id']}command" page="{$bot['id']}$subpage"}><a href="{view page='bot_console' params=$params bot_id={$b['id']}}">{'Console'|gettext}</a></li>
			</ul>
		    </li>
		{/foreach}
		</ul>
		</li>
		<li style="text-align:right;"><a href="?logout=1" class="logout_link" ><i class="icon-off icon-white"></i> {'Logout'|gettext}</a></li>
            </ul>
	    
          </div><!--/.nav-collapse -->
{/block}