[vars]

[dic]
mnu.state = Toggle menu status
mnu.struct = Menu structure
mnu.freeze = Freeze
mnu.thaw = Thaw

[dic.de]
mnu.state = Status ändern
mnu.struct = Menüstruktur
mnu.freeze = Einfrieren
mnu.thaw = Auftauen


# ***********************************************************
[main]
# ***********************************************************
<!SEC:info!>
<p><small>file = static/TAB_HOME/pfs.stat</small></p>

<h4><!DIC:mnu.state!></h4>

<form method="post" action="?">
<!SEC:oid!>

<table>
<!SEC:act!>
</table>
</form>

# ***********************************************************
# menu options
# ***********************************************************
[act]

[act.freeze]
	<tr>
		<td width=150><!DIC:mnu.struct!></td>
		<td><button name="mnu.stat" value=1><!DIC:mnu.freeze!></td>
	</tr>

[act.thaw]
	<tr>
		<td width=150><!DIC:mnu.struct!></td>
		<td><button name="mnu.stat" value=1><!DIC:mnu.thaw!></td>
	</tr>

# ***********************************************************
# help
# ***********************************************************
[info]
<h4>Static menus</h4>

<p>Static menus can speed up initial page rendering significantly.<br>
<red>Changes apply to all languages.</red></p>

[info.de]
<h4>Statisches Menü</h4>

<p>Statische Menüs können den erstmaligen Seitenaufbau erheblich beschleunigen.<br>
<red>Änderungen betreffen alle Sprachen.</red></p>

