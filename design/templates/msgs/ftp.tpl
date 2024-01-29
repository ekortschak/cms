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
<msg><!VAR:ftpstate!> <!DIC:con!> COMBO_DOWN</msg>
<div class="dropbody">
	<a href="?ftp=reset"><!DIC:refresh!></a>
	<a href="config.php?tab=setup/config&pge=config&btn.const=F"><!DIC:chk!></a>
</div>
</div>
