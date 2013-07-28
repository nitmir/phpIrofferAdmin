    <ul class="nav nav-tabs">
    <li{nav_active name="xdl" page="$subpage"}><a href="{view page='bot_listing' params=$params group=''}">{'Packs listing'|gettext}</a></li>
    <li{nav_active name="listul" page="$subpage"}><a href="{view page='files_listing' params=$params path=''}">{'Add files'|gettext}</a></li>
    <li{nav_active name="command" page="$subpage"}><a href="{view page='bot_console' params=$params}">{'Console'|gettext}</a></li>
    </ul>