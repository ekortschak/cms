[register]
core/scripts/tview.js

[dic]
dat.empty = No data ...

[dic.de]
dat.empty = Keine Daten ...

[main]
<div class="toc">
	<!VAR:items!>
</div>

# ***********************************************************
# folders (arrays)
# ***********************************************************
[folder]
<div id="tv[<!VAR:index!>]" data-par="<!VAR:level!>" _
class="dir tv lev<!VAR:level!>" _
style="display:<!VAR:vis!>; background-position-Y:<!VAR:pos!>"> _
<a href="javascript:toggleTv('<!VAR:index!>');"><!VAR:title!></a> _
</div>

# ***********************************************************
# data
# ***********************************************************
[value]
<div id="tv[<!VAR:index!>]" data-par="<!VAR:level!>" _
class="file tv lev<!VAR:level!> <!VAR:sel!>" _
style="display:<!VAR:vis!>;"> _
<!VAR:title!> = <!VAR:value!> _
</div>

# ***********************************************************
# empty
# ***********************************************************
[empty]
<h3>Info</h3>
<p><!DIC:dat.empty!></p>
