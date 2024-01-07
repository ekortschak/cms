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
<div <!SEC:qid!> class="dir <!SEC:cls!>"> _
	<!SEC:link!> _
</div>

[link.redir]
<div <!SEC:qid!> class="dir <!SEC:cls!>"> _
	<a class="<!VAR:active!>" href="?tpc=<!VAR:topic!>&pge=<!VAR:uid!>"> _
		<div class="redir"><b><!VAR:title!></b></div> _
	</a>
</div>

[link.redir file]
<div <!SEC:qid!> class="file <!SEC:cls!>"> _
	<a class="<!VAR:active!>" href="?tpc=<!VAR:topic!>&pge=<!VAR:uid!>"> _
		<div class="redir"><b><!VAR:title!></b></div> _
	</a> _
</div>

# ***********************************************************
# content links
# ***********************************************************
[link.file]
<div <!SEC:qid!> class="file <!SEC:cls!>"> _
	<!SEC:link!> _
</div>

# ***********************************************************
# whole topic
# ***********************************************************
[topic]
<p><msg><!DIC:topic!></msg></p>
