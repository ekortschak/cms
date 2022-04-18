[vars]
sync = 1

[dic]
mnu.state = Toggle menu status
mnu.access = Data exchange
mnu.compare = Activate
mnu.reset = Deactivate

[dic.de]
mnu.state = Status ändern
mnu.access = Datenaustausch
mnu.compare = Freigeben
mnu.reset = Sperren


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?sync=<!VAR:sync!>">
<hr>
<table>
#	<tr><td colspan="100%" height=5></td></tr>
<!SEC:act!>
</table>
<hr>

</form>

# ***********************************************************
# menu options
# ***********************************************************
[act]
<!SEC:act.analize!>

[act.analize]
	<tr>
		<td width=150 style="vertical-align: middle;"><!DIC:mnu.access!></td>
		<td><button name="mnu_stat" value=1><!DIC:mnu.compare!></td>
	</tr>

[act.reset]
	<tr>
		<td width=150 style="vertical-align: middle;"><!DIC:mnu.access!></td>
		<td><button name="mnu_stat" value=1><!DIC:mnu.reset!></td>
	</tr>

# ***********************************************************
# help
# ***********************************************************
[info]
<h4>Important information</h4>

<p>Files that are listed in <dfn>config/ftp.ini</dfn> in the section <dfn>[protect]</dfn>
will <b>never</b> be transferred automatically. (e.g. server configuration)</p>

[info.de]
<h4>Wichtiger Hinweis</h4>

<p>Dateien, die in der Datei <dfn>config/ftp.ini</dfn> in der Sektion <dfn>[protect]</dfn> aufgelistet sind,
werden <b>nie automatisch</b> übertragen. (z.B. Server-Konfiguration)</p>


# ***********************************************************
[cms]
# ***********************************************************
<h4>Important information</h4>

<p><b>ALL files will be transferred!</b><br>
This includes all config files for the CMS-directory should not be used for project files.</p>


<h4>Warning</h4>

<p>This feature will replace your current CMS by its newest version.<br>
This may induce problems.</p>

<p><red>Make sure to backup your current system prior to the update!</red></p>


[cms.de]
<h4>Wichtiger Hinweis</h4>

<p><b>ALLE Dateien werden übertragen!</b><br>
Das schließt auch die Konfigurationsdateien ein, denn das CMS-Verzeichnis selbst sollte nicht für eigene Projekte verwendet werden.</p>


<h4>Warnung</h4>

<p>Diese Funktion ersetzt ihr aktuelles CMS durch die neueste Version.<br>
Dadurch kann es zu Problemen kommen.</p>

<p><red>Sichern Sie vor dem Update ihr aktuelles System!</red></p>



