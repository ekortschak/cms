[include]
LOC_TPL/menus/dropBox.tpl

[main.one]
<!SEC:main.box!>

# ***********************************************************
# common parts
# ***********************************************************
[combo]
<div class="dropdown">
<button><!VAR:current!>COMBO_DOWN</button>
<div class="dropbody"><!VAR:links!></div>
</div>
