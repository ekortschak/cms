[dic]
back = Back
view = Viewing modes
edit = Editing modes
conv = Publish data
save = Backup data
xfer = File transfers
settings = Maintenance
pres = Presentation

[dic.de]
back = Zurück
view = Ansicht
edit = Bearbeiten
conv = Veröffentlichen
save = Sichern
xfer = Dateien übertragen
settings = Wartung
pres = Präsentation


# ***********************************************************
[nav]
# ***********************************************************
<div>
<div class="dropdown">
	<img class="flag" src="LOC_ICO/flags/CUR_LANG.gif" alt="CUR_LANG" />
	<div class="dropbody" style="min-width: 5rem; padding: 1px 4px 2px;">
		<!VAR:langs!>
	</div>
</div>
&nbsp;

<!BTN:reset!>
<!BTN:home!>
<!SEC:config!>

<!SEC:user!>
<!SEC:manual!>
</div>

[lang]
<div><a href="?lang=<!VAR:lang!>"><img class="flag" src="LOC_ICO/flags/<!VAR:lang!>.gif" alt="<!VAR:lang!>" /> <!VAR:lang!></a></div>

# ***********************************************************
[view]
# ***********************************************************
<div class="h4"><!DIC:view!></div>
<div>
<!BTN:view!> <!SEC:pres!> <!SEC:csv!> <!SEC:print!>
</div>

# ***********************************************************
[edit]
# ***********************************************************
<div class="h4"><!DIC:edit!></div>
<div>
<!SEC:medit!> <br>
<!SEC:pedit!> <!SEC:xlate!> <!SEC:seo!> <br>
<!SEC:xedit!> <!SEC:debug!>
</div>

# ***********************************************************
[admin]
# ***********************************************************
<div class="h4"><!DIC:settings!></div>
<div>
<!SEC:xfer!>
</div>

# ***********************************************************
# modules
# ***********************************************************
[pres]   <!BTN:pres!>
[print]  <!BTN:print!>
[csv]    <!BTN:csv!>
[manual] <!BTN:manual!>

[pedit]  <!BTN:pedit!>
[xedit]  <!BTN:xedit!>
[medit]  <!BTN:medit!> <!BTN:mprops!>
[seo]    <!BTN:seo!>
[xlate]  <!BTN:xlate!>

[config] <!BTN:config!>
[home]   <!BTN:home!>
[xfer]   <!BTN:xfer!>

[debug]  <!BTN:debug!>

# ***********************************************************
[user]
# ***********************************************************
# will either be login or logout

[login]  <!BTN:login!>
[logout] <!BTN:logout!>
