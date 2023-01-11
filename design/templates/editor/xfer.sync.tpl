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
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
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

<p>Files that are listed in <dfn>config/ftp.ini</dfn> in the section <dfn>[protect]</dfn>
will <b>never</b> be transferred automatically. (e.g. server configuration)</p>

[info.de]
<h4>Wichtiger Hinweis</h4>

<p>Dateien, die in der Datei <dfn>config/ftp.ini</dfn> in der Sektion <dfn>[protect]</dfn> aufgelistet sind,
werden <b>nie automatisch</b> übertragen. (z.B. Server-Konfiguration)</p>


# ***********************************************************
[backup.1st]
# ***********************************************************
<p><msg>It is recommended to <a href="?btn.xfer=B"&pic.mode=backup>backup</a> the project prior to restoring it!</msg></p>

[backup.1st.de]
<p><msg>Es empfiehlt sich, vorher eine <a href="?btn.xfer=B&pic.mode=backup">Sicherung</a> durchzuführen!</msg></p>


# ***********************************************************
# How to handle hidden files
# ***********************************************************
[hidden.files]
<!VAR:what!> Copy hidden files

[hidden.files.de]
<!VAR:what!> Versteckte Dateien kopieren
