[dic]
con = FTP-Connection
chk = Check configuration
refresh = Refresh Status

[dic.de]
con = FTP-Verbindung
chk = Einstellungen
refresh = Erneut prüfen


[test.rep]
<div class="dropdown">
<msg><!DIC:con!> = <!VAR:status!> <span style="border-left: 1px solid grey; margin-left: 25px; padding: 0px 5px;">&ensp;▾</span></msg>
<div class="dropdown-content">
	<a href="?ftp=reset"><!DIC:refresh!></a>
	<a href="config.php?tab=setup/config&pge=config&btn.const=F"><!DIC:chk!></a>
	<hr>
	<p style="padding: 0px 5px;">ini = <!VAR:inifile!></p>
</div>
</div>
