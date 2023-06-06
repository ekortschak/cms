[dic]
new.tab  = Add a new tab
new.png  = vTab-pics
del.png  = Delete tab pics
node.new = e.g. pages/home
create   = Add
overwrite = Overwrite existing pics
allsets  = Check all TabSets
options  = Options
cur.pic  = Current Image
no.file  = No pic available
cur.file = Location

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


# ***********************************************************
# create a new tab
# ***********************************************************
[add]
<h4><!DIC:new.tab!></h4>

<form action="?" method="post">
<!SEC:oid!>

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
	<a href="?tab.act=add">
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
	<a href="?tab.act=drop" onclick="return confirm('<!DIC:ask.sure!>');">
		<button>BOOL_NO</button>
	</a>
</div>

# ***********************************************************
# further info
# ***********************************************************
[drop]
<h4>Remove this tab</h4>
<ul>
	<li>Open explorer of your operating system</li>
	<li>Remove the folder from the file system</li>
	<li>Refresh display</li>
</ul>

[drop.de]
<h4>Tab löschen</h4>
<ul>
	<li>Explorer des Betriebssystems öffnen</li>
	<li>Ordner löschen</li>
	<li>Anzeige aktualisieren</li>
</ul>

# ***********************************************************
[png.info]
# ***********************************************************
<p>Depending on your browser settings you may need to force reload of the modified pics.
<kbd>Shift</kbd>+<kbd>F5</kbd>
</p>
<hr>

[png.info.de]
<p>Je nach Browser-Einstellungen kann es sein, dass die geänderten Bilder neu geladen werden müssen.
<kbd>Shift</kbd>+<kbd>F5</kbd>
</p>
<hr>
