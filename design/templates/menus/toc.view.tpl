[register]
LOC_SCR/toc.view.js

[dic]
dir.empty = Folder is empty ...
no.topic = Select a topic

[dic.de]
dir.empty = Ordner ist leer ...
no.topic = Wähle ein Thema ...


[vars]
topic = TAB_HOME
pfx = toc
hid =
grey =

[main]
<div class="toc">
<!VAR:items!>
</div>

[caption]
#<!VAR:chnum!>
<!VAR:title!>

[link]
<a class="<!VAR:active!>" href="?tpc=<!VAR:topic!>&pge=<!VAR:uid!>"><!SEC:caption!></a>
#<a href="javascript:load('<!VAR:uid!>');"><!VAR:title!></a>

[qid]
id="<!VAR:pfx!>[<!VAR:index!>]"

[cls]
icon lev<!VAR:level!> <!VAR:vis!> <!VAR:hid!> <!VAR:pos!> <!VAR:sel!>

# ***********************************************************
# level 1 entries
# ***********************************************************
[link.root]
<div <!SEC:qid!> class="<!SEC:cls!>"> _
<!SEC:link!> _
</div>

# ***********************************************************
# menu folders
# ***********************************************************
[link.both]
<div <!SEC:qid!> class="dir <!SEC:cls!>"> _
<!SEC:link!>_
</div>

[link.menu]
<div <!SEC:qid!> class="dir <!SEC:cls!>"> _
<a href="javascript:toggleDiv('<!VAR:pfx!>', <!VAR:index!>);"><!SEC:caption!></a> _
</div>

# ***********************************************************
# content links
# ***********************************************************
[link.file]
<div <!SEC:qid!> class="file <!SEC:cls!>"> _
<!SEC:link!> _
</div>

# ***********************************************************
# static files
# ***********************************************************
[static.dir]
<div <!SEC:qid!> data-par="<!VAR:level!>" class="dir <!SEC:cls!>" _
	<a class="<!VAR:active!>" href="<!VAR:sname!>"><!SEC:caption!></a>
</div>

[static.file]
<div <!SEC:qid!> data-par="<!VAR:level!>" class="file <!SEC:cls!>" _
	<a class="<!VAR:active!>" href="<!VAR:sname!>"><!SEC:caption!></a>
</div>

# ***********************************************************
# unlinked items
# ***********************************************************
[link.none]
<div><!VAR:title!></div>

# ***********************************************************
# empty
# ***********************************************************
[empty]
<h3>Info</h3>
<p><!DIC:dir.empty!></p>

[no.topic]
<p>&bull; <!DIC:no.topic!></p>
