[vars]
status = on

[dic]
sure      = Are you sure?

dir.cur   = Current folder
dir.sub   = Sub nodes
dir.all   = All folders
chk.UIDs  = UIDs (Unique identifiers)

node.new  = dir1, dir2, dir3
node.sort = Sort entries
node.hide = Toggle visibility
node.drop = Drop for good
node.move = Change level
node.top  = Top level cannot move

create    = Add
rename    = Rename this folder
check     = Check

[dic.de]
sure      = Sind Sie sicher?

dir.cur   = Aktueller Ordner
dir.sub   = Unterordner
dir.all   = Alle Ordner
chk.UIDs  = UIDs (eindeutige Bezeichner)

node.sort = Einträge sortieren
node.hide = Ein/Ausblenden
node.drop = Endgültig löschen
node.move = Ebene ändern
node.top  = Funktion gesperrt

create    = Erstellen
rename    = Umbennenen
check     = Prüfen


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:nodes!>
</form>

<form method="post" action="?">
<!SEC:creates!>
</form>

<form method="post" action="?">
<!SEC:chknodes!>
</form>

<!SEC:help!>

# ***********************************************************
# folder options
# ***********************************************************
[nodes]
<h4><!DIC:dir.cur!></h4>
<p><small>dir = <!VAR:curloc!></small></p>

<table>
	<tr>
		<td width=250><input name="ren.dir" type="text" value="<!VAR:curdir!>" /></td>
		<td><button name="node_act" value="ren"><!DIC:rename!></button></td>
	</tr>

	<tr><td colspan="100%" height=5></td></tr>
	<tr>
		<td style="vertical-align: middle;"><!DIC:node.drop!></td>
		<td><button name="node_act" value="drop" onclick="return confirm('<!DIC:ask.sure!>');">BOOL_NO</button></td>
	</tr>

	<tr><td colspan="100%" height=5></td></tr>
	<tr>
		<td style="vertical-align: middle;"><!DIC:node.hide!></td>
		<td><button name="node_act" value="hide"><img src="ICONS/menu/bulb_<!VAR:status!>.gif" /></button></td>
	</tr>

	<tr><td colspan="100%" height=5></td></tr>
	<tr>
		<td style="vertical-align: middle;"><!DIC:node.move!></td>
		<td>
<!SEC:nodes.move!>
		</td>
	</tr>
</table>

[nodes.move]
	<button name="node_act" value="out"><b>↖</b></button>
	<button name="node_act" value="min"><b>↘</b></button>

[nodes.top]
	<!DIC:node.top!>

[creates]
<h4><!DIC:dir.sub!></h4>
<table>
	<tr>
		<td width=250><input name="sub.dir" type="text" placeholder="<!DIC:node.new!>" /></td>
		<td><button name="node_act" value="sub"><!DIC:create!></button></td>
	</tr>
</table>

[chknodes]
<h4><!DIC:dir.all!></h4>
<input name="root.dir" type="hidden" value="TAB_HOME">

<table>
	<tr>
		<td width=250 style="vertical-align: middle;"><!DIC:chk.UIDs!></td>
		<td><button name="node_act" value="uid"><!DIC:check!></button></td>
	</tr>
</table>


# ***********************************************************
# further info
# ***********************************************************
[help]
<h4>Move a folder</h4>
<ul>
	<li>Use clipboard</li>
</ul>

<p>or</p>

<ul>
	<li>Open explorer of your operating system</li>
	<li>Move the folder to its new position</li>
	<li>Refresh display</li>
</ul>

[help.de]
<h4>Ordner Verschieben</h4>
<ul>
	<li><a href="?btn.menu=C">Clipboard</a> verwenden</li>
</ul>

<p>oder</p>

<ul>
	<li>Explorer des Betriebssystems öffnen</li>
	<li>Ordner verschieben</li>
	<li>Anzeige aktualisieren</li>
</ul>
