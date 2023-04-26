[register]
LOC_SCR/toc.view.js

[dic]
dat.empty = No data ...

[dic.de]
dat.empty = Keine Daten ...

[vars]
pfx = tv
info = no info provided


[main]
<div class="toc">
<!VAR:items!>
</div>

[debug]
<div class="scroll" style="height: 175px; border: 1px solid lightgrey; resize: vertical;">
<u><i><!VAR:info!></i></u>
<!SEC:main!>
</div>

# ***********************************************************
# helper sections
# ***********************************************************
[qid]
id="<!VAR:pfx!>[<!VAR:index!>]" name="<!VAR:pfx!>_<!VAR:index!>"

[cls]
lev<!VAR:level!>

[stl]
display:<!VAR:vis!>; background-position-Y:<!VAR:pos!>

# ***********************************************************
# folders (arrays)
# ***********************************************************
[folder]
<div <!SEC:qid!> class="dir  <!SEC:cls!>" style="<!SEC:stl!>"> _
<a href="javascript:toggleDiv('<!VAR:pfx!>', '<!VAR:index!>');"> _
<!VAR:title!> _
</a> _
</div>

# ***********************************************************
# data
# ***********************************************************
[value]
<div <!SEC:qid!> class="file <!SEC:cls!>" style="display:<!VAR:vis!>;"> _
<!VAR:title!> = <!VAR:value!> _
</div>

# ***********************************************************
# empty
# ***********************************************************
[empty]
<h3>Info</h3>
<p><!DIC:dat.empty!></p>
