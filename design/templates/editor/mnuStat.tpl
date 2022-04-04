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
<p><small>file = TOP_PATH/pfs.stat</small></p>

<h4><!DIC:mnu.state!></h4>

<form method="post" action="?">
<table>
#	<tr><td colspan="100%" height=5></td></tr>
<!SEC:act!>
</table>

</form>

# ***********************************************************
# menu options
# ***********************************************************
[act]

[act.freeze]
	<tr>
		<td width=150 style="vertical-align: middle;"><!DIC:mnu.struct!></td>
		<td><button name="mnu_stat" value=1><!DIC:mnu.freeze!></td>
	</tr>

[act.thaw]
	<tr>
		<td width=150 style="vertical-align: middle;"><!DIC:mnu.struct!></td>
		<td><button name="mnu_stat" value=1><!DIC:mnu.thaw!></td>
	</tr>

# ***********************************************************
# help
# ***********************************************************
[info]
<h4>Static menus</h4>

<p>Static menus can speed up page rendering significantly.<br>
<red>Changes apply to all languages.</red></p>

[info.de]
<h4>Statisches Menü</h4>

<p>Statische Menüs können den Seitenaufbau erheblich beschleunigen.<br>
<red>Änderungen betreffen alle Sprachen.</red></p>

