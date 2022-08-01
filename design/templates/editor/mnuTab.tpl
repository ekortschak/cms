[dic.de]
new.tab  = Tab hinzufügen
new.png  = Neue Tab-Bilder erstellen
del.png  = Tab-Bilder entfernen
node.new = z.B: pages/home
create   = Erstellen
overwrite = Überschreibe bestehende Bilder
allsets  = Überprüfe alle TabSets
options  = Optionen
view     = Aktuelles Bild
no.file  = Kein Bild vorhanden
cur.file = Dateiname

[dic]
new.tab  = Add a new tab
new.png  = Create vTab-pics
del.png  = Delete vTab-pics
node.new = e.g. pages/home
create   = Add
overwrite = Overwrite existing pics
allsets  = Check all TabSets
options  = Options
view     = Current Image
no.file  = No pic available
cur.file = File name

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
<h4><!DIC:new.png!></h4>

<form action="?" method="post">
	<input type="hidden"   name="tab.name" value=<!VAR:tab!> />
	<input type="hidden"   name="tab.rep" value=0 />
	<input type="checkbox" name="tab.rep" value=1 <!VAR:checked!> class="cb" />
	<!DIC:overwrite!>

	&nbsp; &nbsp;

#	<input type="hidden"   name="tab.all" value=0 />
#	<input type="checkbox" name="tab.all" value=1 <!VAR:checked!> class="cb" />
#	<!DIC:allsets!><br/>

	<input type="submit" name="tab.act" value="<!DIC:create!>" />
</form>

[del.png]
<h4><!DIC:options!></h4>

<table>
	<tr>
		<td width=175 style="vertical-align: middle;"><!DIC:del.png!></td>
		<td>
			<a href="?tab.drop=<!VAR:tab!>" onclick="return confirm('<!DIC:ask.sure!>');">
				<dmbtn><maroon>&cross;</maroon></dmbtn>
			</a>
		</td>
	</tr>
</table>

[show.png]
<h4><!DIC:view!></h4>
<div><!DIC:cur.file!>: &nbsp; &nbsp; &nbsp;
	<img src="<!VAR:file!>/tab.png" />
</div>

[show.png.none]
<h4><!DIC:view!></h4>
<p><!DIC:no.file!></p>

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
