[include]
design/templates/msgs/sitemap.tpl

[main]
<!SEC:banner!>
<!SEC:help!>
<!SEC:head!>
<!SEC:page!>
<!SEC:tail!>
<!SEC:trailer!>

[xsite]
<!SEC:head!>
<!SEC:page!>
<!SEC:tail!>

[banner]
<div>
<!VAR:banner!>
</div>

[head]
<div>
<!VAR:head!>
</div>

[help.box]
<div class="helpbox">
	<img class="helpbox-button" src="ICONS/help.png" />
	<div class="helpbox-content"><!VAR:help!></div>
</div>

[help]
<p><msg>
<!VAR:help!>
</msg></p>

[page]
<div>
<!VAR:page!>
</div>

[tail]
<div>
<!VAR:tail!>
</div>
[
trailer]
<div>
<!VAR:trailer!>
</div>

# ***********************************************************
[sorry]
# ***********************************************************
<hr>
<!SEC:notyet!>
<hr>

# ***********************************************************
[notyet]
# ***********************************************************
Sorry: this file is not (yet) available in English!

[notyet.de]
Sorry: diese Datei ist in Deutsch (noch) nicht verfügbar!

