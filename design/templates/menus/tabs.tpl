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
	<div class="vtab <!VAR:class!>">
		<div class="<!VAR:dir!><!VAR:os!>"><!VAR:text!></div>
	</div>
</a>

[item.img]
<a href="?<!VAR:parm!>=<!VAR:link!>&vmode=<!VAR:mode!>">
	<div class="vtab <!VAR:class!>">
		<img src="<!VAR:img!>" alt="<!VAR:text!>" />
	</div>
</a>

# ***********************************************************
[bmenu]
# ***********************************************************
<div class="vtab micon" onclick="showMenu();">
	<div class="ibar"></div>
	<div class="ibar"></div>
	<div class="ibar"></div>
</div>

# ***********************************************************
[search]
# ***********************************************************
<a href="?vmode=search">
	<div class="vtab">
        <img src="ICONS/buttons/search.gif" alt="Search" />
	</div>
</a>

[return]
<a href="?vmode=view">
	<div class="vtab">
        <img src="ICONS/buttons/search.stop.gif" alt="Back" />
	</div>
</a>

# ***********************************************************
[tedit]
# ***********************************************************
<div align="center" style="margin-bottom: 7px;">
<a href="?vmode=tedit">
	<img src="ICONS/buttons/edit.tab.png" alt="TabEdit" />
</a>
</div>

[tview]
<div align="center" style="margin-bottom: 7px;">
<a href="?vmode=view">
	<img src="ICONS/buttons/view.png" alt="View" />
</a>
</div>
