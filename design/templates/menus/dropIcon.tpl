[include]
LOC_TPL/menus/dropBox.tpl


# ***********************************************************
[main] # static info
# ***********************************************************
<div>
<div class="micon">
	<div class="ibar"></div>
	<div class="ibar"></div>
	<div class="ibar"></div>
</div>
<!VAR:items!>
</div> &ensp;

[main.box]
<div class="dropdown">
<div class="droptext">COMBO_DOWN</div>
<div class="dropbody"><!VAR:links!></div>
</div>

[main.one]
<!SEC:main.box!>
