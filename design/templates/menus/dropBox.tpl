y[dic]
table = Table
field = Field
range = Range

[dic.de]
table = Tabelle
field = Feld
range = Bereich

[vars]
align = left
parm = ref
type = button
current = ???
sep = :


# ***********************************************************
[main] # simple combo box
# ***********************************************************
<!VAR:items!>

[main.box]
<!SEC:uniq!> <!SEC:combo!>

[main.one]
<!SEC:uniq!> <!SEC:button!>

[empty]
-

# ***********************************************************
# common parts
# ***********************************************************
[uniq]
<!VAR:uniq!><!VAR:sep!>

[combo]
<div class="dropdown">
<div class="droptext"><!VAR:current!>COMBO_DOWN</div>
<div class="dropbody"><!VAR:links!></div>
</div>

[link]
<div class="nowrap"><a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:caption!></a></div>

[button]
<button><!VAR:current!></button> &ensp;

[text]
<div class="droptext"><!VAR:current!></div>
