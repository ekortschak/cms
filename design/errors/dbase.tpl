[vars]
module = mysqli
dbase = DB_FILE


# ***********************************************************
[tan.outdated]
# ***********************************************************
<p><b>Invalid TAN</b></p>
<ul>
<li>TAN is outdated (timeout).</li>
</ul>

[tan.outdated.de]
<p><b>TAN ungültig</b></p>
<ul>
<li>TAN ist nicht mehr gültig (Zeitablauf).</li>
</ul>

# ***********************************************************
[tan.conflict]
# ***********************************************************
<p><b>TAN - conflict</b></p>
<ul>
<li>Only one transaction can be open at any time.</li>
</ul>

[tan.conflict.de]
<p><b>TAN - Konflikt</b></p>
<ul>
<li>Es kann immer nur eine offene Transaktion geben.</li>
</ul>

# ***********************************************************
[mysqli.module]
# ***********************************************************
<p><b>Module missing</b>: <!VAR:module!></p>
<ul>
<li>Check php.ini for loaded modules</li>
</ul>

[mysqli.module.de]
<p><b>Modul nicht geladen</b>: <!VAR:module!></p>
<ul>
<li>Überprüfe php.ini auf zu ladende Module.</li>
</ul>

# ***********************************************************
[db.connection]
# ***********************************************************
<p><b>Database not accessible</b>: Table '<!VAR:parm!>'</p>
<ul>
<li>Check if the database module is installed.</li>
<li>Check config/dbase.ini</li>
</ul>

[db.connection.de]
<p><b>Datenbank nicht verfügbar</b>: Tabelle '<!VAR:parm!>'</p>
<ul>
<li>Überprüfe, ob das Datenbank-Modul installiert ist.</li>
<li>Überprüfe config/dbase.ini</li>
</ul>
