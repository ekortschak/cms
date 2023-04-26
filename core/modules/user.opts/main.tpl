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

[lang]
<div><a href="?lang=<!VAR:lang!>"><img class="flag" src="LOC_ICO/flags/<!VAR:lang!>.gif" alt="<!VAR:lang!>" /> <!VAR:lang!></a></div>

# ***********************************************************
[nav]
# ***********************************************************
<div>
<div class="dropdown">
	<img class="flag" src="LOC_ICO/flags/CUR_LANG.gif" alt="CUR_LANG" />
	<div class="dropbody" style="min-width: 10px; padding: 1px 4px 2px;">
		<!VAR:langs!>
	</div>
</div>
&nbsp;

<!BTN:reset!>

<!SEC:print!>
<!SEC:csv!>
<!SEC:user!>
<!SEC:manual!>
</div>

# ***********************************************************
[config]
# ***********************************************************
<h4><!DIC:loc!></h4>

<div>
<!BTN:view!>
<!SEC:pedit!>
<!SEC:xedit!>
<!SEC:medit!>
&nbsp;
<!SEC:xfer!>
<!SEC:seo!>
</div>

<h4><!DIC:settings!></h4>

<div>
<!BTN:config!>
<!SEC:config.cms!>
</div>

[config.cms]
<!BTN:xpedit!>
<!BTN:xmedit!>

# ***********************************************************
[edit]
# ***********************************************************
<h4><!DIC:loc!></h4>

<div>
<!BTN:view!>
<!SEC:pedit!>
<!SEC:xedit!>
<!SEC:medit!>
&nbsp;
<!SEC:xfer!>
<!SEC:seo!>
&nbsp;
<!SEC:debug!>
</div>

[tedit]
<!BTN:tedit!>

[pedit]
<!BTN:pedit!>
[xedit]
<!BTN:xedit!>
[medit]
<!BTN:medit!>
[xfer]
<!BTN:xfer!>
[seo]
<!BTN:seo!>

[debug]
<!BTN:debug!>

# ***********************************************************
[admin]
# ***********************************************************
<h4><!DIC:settings!></h4>

<div>
<!BTN:config!>
</div>

# ***********************************************************
[user]
# ***********************************************************

[login]
<!BTN:login!>

[logout]
<!BTN:logout!>

# ***********************************************************
[manual]
# ***********************************************************
<!BTN:manual!>

[print]
<!BTN:print!>

[csv]
<!BTN:csv!>
