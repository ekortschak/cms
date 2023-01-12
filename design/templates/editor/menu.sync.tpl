[vars]
head = <!DIC:confirm!>
title = Sync

what = BOOL_NO

[dic]
confirm = Confirmation required

sync.source = Source
sync.analize = Analize
sync.execute = Execute

[dic.de]
confirm = Bestätigung erforderlich

sync.source = Quelle
sync.analize = Vergleichen
sync.execute = Ausführen


# ***********************************************************
[main]
# ***********************************************************
<h4><red><!VAR:title!></red></h4>

<div class="rh"><!VAR:head!></div>
<div class="confirm">
	<div><!DIC:source!>: <!VAR:source!></div>
	<div><!SEC:dest!></div>

	<hr>
	<div><!SEC:hidden.files!></div>
</div>

<div class="rf" align="right">
	<a href="?sync.act=1"><button><!DIC:sync.analize!></button></a>
	<a href="?sync.act=2"><button><!DIC:sync.execute!></button></a>
</div>

# ***********************************************************
# destination
# ***********************************************************
[dest]
<!SEC:dest.local!>

[dest.local]
&rarr; <!VAR:dest!>

[dest.remote]
&rarr; <a href="http://<!VAR:dest!>" target="dest"><!VAR:dest!></a>


# ***********************************************************
# help
# ***********************************************************
[info]
<h4>Important information</h4>

<p>Files that are listed in <dfn><!VAR:inifile!></dfn> in the section <dfn>[protect]</dfn>
will <b>never</b> be transferred automatically. (e.g. server configuration)</p>

[info.de]
<h4>Wichtiger Hinweis</h4>

<p>Dateien, die in der Datei <dfn><!VAR:inifile!></dfn> in der Sektion <dfn>[protect]</dfn> aufgelistet sind,
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

# ***********************************************************
# How to handle hidden files
# ***********************************************************
[hidden.files]
<!VAR:what!> Copy hidden files

[hidden.files.de]
<!VAR:what!> Versteckte Dateien kopieren
