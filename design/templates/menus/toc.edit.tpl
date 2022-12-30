[include]
LOC_TPL/menus/toc.view.tpl

[dic]
topic = Applies to whole topic
abstract = Abstract ...

[dic.de]
topic = Betrifft gesamtes Thema
abstract = Abstract ...

# ***********************************************************
# menu folders
# ***********************************************************
[link.both]
<!SEC:link.menu!>

[link.menu]
	<div class="dir mnu lev<!VAR:level!> <!VAR:sel!> <!VAR:hid!>" _
		style="display:<!VAR:vis!>; background-position-Y:<!VAR:pos!>"> _
		<!SEC:link!>
    </div>

# ***********************************************************
# content links
# ***********************************************************
[link.file]
	<div _
		class="file mnu lev<!VAR:level!> <!VAR:sel!> <!VAR:hid!>" _
		style="display:<!VAR:vis!>;"> _
		<!SEC:link!>
    </div>

# ***********************************************************
# whole topic
# ***********************************************************
[topic]
<p><msg><!DIC:topic!></msg></p>
