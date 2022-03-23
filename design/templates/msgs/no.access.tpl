[include]
design/dictionary/CUR_LANG/login.dic

[vars]
user  = CUR_USER

[dic]
nodb     = This feature requires a database!
nocon    = No connection to database!
nousr    = You are not logged in!
chk.cfg	 = Check configuration

[dic.de]
nodb     = Diese Funktion setzt eine Datenbank voraus!
nocon    = Keine Verbindung zur Datenbank!
nousr    = Sie sind derzeit nicht angemeldet!
chk.cfg	 = Konfiguration prüfen


# ***********************************************************
[nocon]
# ***********************************************************
<msg><!DIC:nocon!></msg><br>

# ***********************************************************
[nodb]
# ***********************************************************
<msg><!DIC:nodb!><br>
<a href="config.php?tab=setup/config&pge=config&btn.const=D"><!DIC:chk.cfg!></a>
</msg>
# &bull; config: USE&lowbar;DB = 0

# ***********************************************************
[nouser]
# ***********************************************************
<msg><!DIC:nousr!><br>
&rarr; <!DIC:do.login!></msg><br>

[noauth]
<msg><!DIC:nousr!></msg><br>

# ***********************************************************
[nofile]
# ***********************************************************
<msg>Select a page from the menu.</msg>

[nofile.de]
<msg>Wählen Sie eine Seite aus dem Inhaltsverzeichnis.</msg>
