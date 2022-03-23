[dic]
opts = Options
back = Back
loc = Page editing
conv = Publish data
save = Backup data
xfer = File transfers

[dic.de]
opts = Optionen
back = Zurück
loc = Seite bearbeiten
conv = Veröffentlichen
save = Sichern
xfer = Dateien übertragen


# ***********************************************************
[main]
# ***********************************************************
<!-- img src="img/logo.png" /-->
<h1>PRJ_TITLE</h1>

<div>
<!VAR:langs!>
</div>

[lang]
<a href="?lang=<!VAR:lang!>"><img class="flag" src="core/icons/flags/<!VAR:lang!>.gif" alt="<!VAR:lang!>" /></a>

# ***********************************************************
[nav]
# ***********************************************************
<h4><!DIC:opts!></h4>

<div>
<!BTN:reset!>
<!BTN:search!>
<!BTN:print!>
<!BTN:csv!>
&nbsp;
<!BTN:login!>
</div>

# ***********************************************************
[view]
# ***********************************************************
<h4><!DIC:back!></h4>

<div>
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
<!BTN:check!>

# ***********************************************************
[admin]
# ***********************************************************
<div>
<!BTN:config!>
<!SEC:xedit!>
</div>

<p style="margin-top: 10px;">
<!BTN:manual!>
</p>


[xedit]
<!BTN:xpedit!>
<!BTN:xmedit!>

# ***********************************************************
[admin.web]
# ***********************************************************
<div>
<!BTN:config!>
</div>

