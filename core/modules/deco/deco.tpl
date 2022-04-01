[dic]
opts = Options
back = Back
loc = Page editing
conv = Publish data
save = Backup data
xfer = File transfers
settings = Settings

[dic.de]
opts = Optionen
back = Zurück
loc = Seite bearbeiten
conv = Veröffentlichen
save = Sichern
xfer = Dateien übertragen
settings = Einstellungen


# ***********************************************************
[main]
# ***********************************************************
<!-- img src="img/logo.png" /-->
<h1>PRJ_TITLE</h1>

[lang]
<div><a href="?lang=<!VAR:lang!>"><img class="flag" src="core/icons/flags/<!VAR:lang!>.gif" alt="<!VAR:lang!>" /> <!VAR:lang!></a></div>

# ***********************************************************
[nav]
# ***********************************************************
<div>
<div class="dropdown">
	<img class="flag" src="core/icons/flags/CUR_LANG.gif" alt="CUR_LANG" />
	<div class="dropdown-content" style="min-width: 10px; padding: 1px 4px 2px;">
		<!VAR:langs!>
	</div>
</div>
&nbsp;

<!BTN:reset!>
<!BTN:print!>
<!BTN:csv!>

<!BTN:login!>

<!BTN:manual!>
</div>

# ***********************************************************
[config]
# ***********************************************************
<h4><!DIC:settings!></h4>

<div>
<!BTN:config!>
<!BTN:xpedit!>
<!BTN:xmedit!>
&nbsp;
<!BTN:view!>
</div>

# ***********************************************************
[edit]
# ***********************************************************
<h4><!DIC:loc!></h4>

<div>
<!BTN:view!>
<!SEC:pedit!>
<!SEC:medit!>
&nbsp;
<!SEC:xform!>
&nbsp;
<!SEC:debug!>
</div>

[tedit]
<!BTN:tedit!>
[medit]
<!BTN:medit!>
[pedit]
<!BTN:pedit!>
[xform]
<!BTN:xform!>

[debug]
<!BTN:debug!>
#<!BTN:check!>

# ***********************************************************
[admin]
# ***********************************************************
<h4><!DIC:settings!></h4>

<div>
<!BTN:config!>
</div>

# ***********************************************************
[admin.web]
# ***********************************************************
<div>
<!BTN:config!>
</div>

