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

[vars]
inifile = config/ftp.ini
what = BOOL_NO
pnew = 1
vsrc = VERSION
vdst = VERSION


# ***********************************************************
[main]
# ***********************************************************
<!VAR:choices!>

<div class="rh"><!DIC:confirm!></div>
<div class="confirm">
	<table class="nomargin">
		<tr>
			<td style="padding-left: 0px;"><!DIC:source!></td>
			<td>v<!VAR:vsrc!></td>
			<td><!VAR:source!></td>
		</tr>
		<tr>
			<td style="padding-left: 0px;"><!DIC:target!></td>
			<td>v<!VAR:vdst!></td>
			<td><!SEC:dest!></td>
		</tr>
	</table>

	<hr>
	<div><!SEC:hidden.files!></div>
	<div><!SEC:newer.files!></div>
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
<!VAR:target!>

[dest.remote]
<a href="http://<!VAR:dest!>" target="dest"><!VAR:target!></a>


# ***********************************************************
[backup.1st]
# ***********************************************************
<p><msg>It is recommended to <a href="?btn.xfer=B"&pic.mode=backup>backup</a> the project prior to restoring it!</msg></p>

[backup.1st.de]
<p><msg>Es empfiehlt sich, vorher eine <a href="?btn.xfer=B&pic.mode=backup">Sicherung</a> durchzuführen!</msg></p>


# ***********************************************************
# How to handle newer files
# ***********************************************************
[newer.files]
<!SEC:newer.files.<!VAR:pnew!>!>

[newer.files.0]
<a href="?pnew=1" class="norm">BOOL_NO Protect newer files</a>

[newer.files.0.de]
<a href="?pnew=1" class="norm">BOOL_NO Neuere Dateien schützen</a>

[newer.files.1]
<a href="?pnew=0" class="norm">BOOL_YES Protect newer files</a>

[newer.files.1.de]
<a href="?pnew=0" class="norm">BOOL_YES Neuere Dateien schützen</a>


# ***********************************************************
[info.all]
# ***********************************************************
<br>ALL files will be transferred.

[info.all.de]
<br>ALLE Dateien werden übertragen.


# ***********************************************************
# How to handle hidden files
# ***********************************************************
[hidden.files]
<!VAR:what!> Copy hidden files

[hidden.files.de]
<!VAR:what!> Versteckte Dateien kopieren