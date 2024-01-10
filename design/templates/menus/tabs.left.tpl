[vars]
os = ""
parm = tab
agent =

vmode = VMODE

# ***********************************************************
[main]
# ***********************************************************
<!SEC:search!>
<!SEC:tedit!>
<!VAR:items!>

[item]
<a href="?vmode=<!VAR:vmode!>&<!VAR:parm!>=<!VAR:link!>">
	<div class="vtab <!VAR:class!>">
		<div class="vertical<!VAR:agent!>"><!VAR:text!></div>
	</div>
</a>

[item.img]
<a href="?<!VAR:parm!>=<!VAR:link!>">
	<div class="vtab <!VAR:class!>">
		<img src="<!VAR:img!>" alt="<!VAR:text!>" />
	</div>
</a>

# ***********************************************************
[search]
# ***********************************************************
<div class="tabicon">
<a href="?vmode=search">
	<img src="LOC_ICO/buttons/search.gif" alt="Search" />
</a>
</div>

[search.return]
<div class="tabicon">
<a href="?vmode=view">
	<img src="LOC_ICO/buttons/search.stop.gif" alt="Back" />
</a>
</div>

# ***********************************************************
[return]
# ***********************************************************
<div class="tabicon">
<a href="?vmode=view">
	<img src="LOC_ICO/buttons/view.png" alt="View" />
</a>
</div>
