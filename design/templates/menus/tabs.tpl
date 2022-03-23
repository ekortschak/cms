[register]
core/scripts/mobile.js

[vars]
os = ""
parm = tab
dir = vertical

# ***********************************************************
[main]
# ***********************************************************
<!SEC:bmenu!>
<!SEC:search!>
<!SEC:tedit!>
<!VAR:items!>

[item]
<a href="?<!VAR:parm!>=<!VAR:link!>&vmode=<!VAR:mode!>">
	<vtab class="<!VAR:class!>">
		<div class="<!VAR:dir!><!VAR:os!>"><!VAR:text!></div>
	</vtab>
</a>

[item.img]
<a href="?<!VAR:parm!>=<!VAR:link!>&vmode=<!VAR:mode!>">
	<vtab class="<!VAR:class!>">
		<img src="<!VAR:img!>" alt="<!VAR:text!>" />
	</vtab>
</a>

# ***********************************************************
[bmenu]
# ***********************************************************
<vtab class="micon" onclick="showMenu();">
	<div class="ibar"></div>
	<div class="ibar"></div>
	<div class="ibar"></div>
</vtab>

# ***********************************************************
[search]
# ***********************************************************
<a href="?vmode=search">
	<vtab>
        <img src="core/icons/buttons/search.gif" alt="Search" />
	</vtab>
</a>

[return]
<a href="?vmode=view">
	<vtab>
        <img src="core/icons/buttons/search.stop.gif" alt="Back" />
	</vtab>
</a>

# ***********************************************************
[tedit]
# ***********************************************************
<div align="center" style="margin-bottom: 7px;">
<a href="?vmode=tedit">
	<img src="core/icons/buttons/edit.tab.png" alt="TabEdit" />
</a>
</div>

[tview]
<div align="center" style="margin-bottom: 7px;">
<a href="?vmode=view">
	<img src="core/icons/buttons/view.png" alt="View" />
</a>
</div>
