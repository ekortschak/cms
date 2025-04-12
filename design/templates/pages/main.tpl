[include]
LOC_TPL/msgs/sitemap.tpl

# ***********************************************************
[main]
# ***********************************************************
<!SEC:banner!>
<!SEC:help!>
<!SEC:head!>
<!SEC:content!>
<!SEC:tail!>
<!SEC:trailer!>

# ***********************************************************
[banner]
# ***********************************************************
<div><!VAR:banner!></div>

[head]
<div><!VAR:head!></div>

[help]
<div class="helpbox noprint">
	<img src="LOC_ICO/help.png" />
	<div class="helpbox-content"><!VAR:help!></div>
</div>

# ***********************************************************
[content]
# ***********************************************************
<div id="scView"><!VAR:page!></div>

[tail]
<div><!VAR:tail!></div>

[trailer]
<div><!VAR:trailer!></div>

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

