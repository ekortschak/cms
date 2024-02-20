[include]
LOC_TPL/menus/dropBox.tpl

[main.one]
<div class="h2" style="padding: 3px 5px 0px;"><!VAR:current!></div>

# ***********************************************************
# common parts
# ***********************************************************
[combo]
<div class="dropdown">
<button><!VAR:current!>COMBO_DOWN</button>
<div class="dropbody"><!VAR:links!></div>
</div>
