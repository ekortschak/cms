
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
[main]
# ***********************************************************
<div class="dropdown">
	<button class="dropdown-button">Snips&ensp;▾</button>
<!SEC:content!>
</div>
