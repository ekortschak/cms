[include]
#/design/templates/menus/dropbox.tpl

# ***********************************************************
# common parts
# ***********************************************************
[content]
<div class="dropdown-content">
	<!VAR:links!>
</div>

[link]
<div><a href="javascript:exIns('<!VAR:value!>');"><!VAR:caption!></a></div>

# ***********************************************************
[combo]
# ***********************************************************
<div class="dropdown">
	<button class="dropdown-button">Snips &nbsp; ▾</button>
<!SEC:content!>
</div>
