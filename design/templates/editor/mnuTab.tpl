[dic.de]
new.tab  = Tab hinzufügen
new.png  = Neue Tab-Bilder
del.png  = Tab-Bilder entfernen
node.new = z.B: pages/home
create   = Erstellen
overwrite = Überschreibe bestehende Bilder
allsets  = Überprüfe alle TabSets
options  = Optionen
cur.pic  = Aktuelles Bild
no.file  = Keine Bilder vorhanden
cur.file = Dateiname
preview  = Vorschau

[dic]
new.tab  = Add a new tab
new.png  = vTab-pics
del.png  = Delete vTab-pics
node.new = e.g. pages/home
create   = Add
overwrite = Overwrite existing pics
allsets  = Check all TabSets
options  = Options
cur.pic  = Current Image
no.file  = No pic available
cur.file = Location
preview  = Preview

# ***********************************************************
# create a new tab
# ***********************************************************
[add.tab]
<h4><!DIC:new.tab!></h4>
<form action="?" method="post">
<table>
	<tr>
		<td width=230><input name="tab.dir" type="text" placeholder="<!DIC:node.new!>" /></td>
		<td><input type="submit" name="tab.act" value="<!DIC:create!>" /></td>
	</tr>
</table>
</form>

# ***********************************************************
# tab to png
# ***********************************************************
[add.png]
<div><!DIC:no.file!></div>

<hr>

<div align="right">
	<!DIC:new.png!>
	<a href="?tab.add=<!VAR:tab!>">
		<button><!DIC:create!></button>
	</a>
</div>

[del.png]
<table>
	<tr>
		<td><img src="<!VAR:file!>" /></td>
		<td style="vertical-align: middle;"><!DIC:cur.file!>:<br>&emsp; <!VAR:file!></td>
	</tr>
</table>

<hr>

<div align="right">
	<!DIC:del.png!>
	<a href="?tab.drop=<!VAR:tab!>" onclick="return confirm('<!DIC:ask.sure!>');">
		<button>BOOL_NO</button>
	</a>
</div>

# ***********************************************************
# further info
# ***********************************************************
[help]
<h4>Remove this tab</h4>
<ul>
	<li>Open explorer of your operating system</li>
	<li>Remove the folder from the file system</li>
	<li>Refresh display</li>
</ul>

[help.de]
<h4>Tab löschen</h4>
<ul>
	<li>Explorer des Betriebssystems öffnen</li>
	<li>Ordner löschen</li>
	<li>Anzeige aktualisieren</li>
</ul>
