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
	<!SEC:langs!>
</div>
&nbsp;

<!BTN:reset!>
<!BTN:home!>
<!SEC:config!>

<!SEC:user!>
<!SEC:manual!>

</div>

[langs]
<div class="dropbody" style="min-width: 5rem; padding: 1px 4px 2px;"><!VAR:langs!></div>

[no.langs]


[lang]
<div><a href="?lang=<!VAR:lang!>"><img class="flag" src="LOC_ICO/flags/<!VAR:lang!>.gif" alt="<!VAR:lang!>" /> <!VAR:lang!></a></div>

# ***********************************************************
[view]
# ***********************************************************
<div class="h4"><!DIC:view!></div>
<div>
<!BTN:view!> <!SEC:csv!> <!SEC:print!> <br>
<!SEC:search!> <!SEC:pres!>
</div>

# ***********************************************************
[edit]
# ***********************************************************
<div class="h4"><!DIC:edit!></div>
<div>
<!SEC:tedit!>
<!SEC:medit!>
<!SEC:pedit!>
<!SEC:xedit!>
<!SEC:ebook!>
</div>

# ***********************************************************
[admin]
# ***********************************************************
<div class="h4"><!DIC:settings!></div>
<div>
<!SEC:xfer!>
<!SEC:debug!>
</div>

# ***********************************************************
# modules
# ***********************************************************
[pres]   <!BTN:pres!>
[print]  <!BTN:print!>
[csv]    <!BTN:csv!>
[manual] <!BTN:manual!>
[search] <!BTN:search!>

[tedit]  <!BTN:tedit!> <!BTN:topic!>  <br>
[medit]  <!BTN:medit!> <!BTN:mprops!> <br>
[pedit]  <!BTN:pedit!> <!SEC:xlate!> <!SEC:seo!> <!SEC:iedit!> <br>
[iedit]  <!BTN:iedit!>
[xedit]  <!BTN:xedit!>
[ebook]  <!BTN:ebook!>
[xlate]  <!BTN:xlate!>
[seo]    <!BTN:seo!>

[config]
 <!BTN:config!>
[home]   <!BTN:home!>
[xfer]   <!BTN:xfer!>

[debug]  <!BTN:debug!>
[nobug]  <!BTN:debug.clear!>

# ***********************************************************
[user]
# ***********************************************************
# will either be login or logout

[login]  <!BTN:login!>
[logout] <!BTN:logout!>
