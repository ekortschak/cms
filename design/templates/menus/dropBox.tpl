[dic]
table = Table
field = Field
range = Range

[dic.de]
table = Tabelle
field = Feld
range = Bereich

[vars]
parm = ref
type = button
current = ???
sep = :


# ***********************************************************
[main] # simple combo box
# ***********************************************************
<!VAR:items!>

[main.box]
<div class="dropdown">
<button><!VAR:current!>COMBO_DOWN</button>
<!SEC:content!>
</div>

[main.one]
<button><!VAR:current!></button>


# ***********************************************************
# common parts
# ***********************************************************
[content]
<div class="dropdown-content">
<!VAR:links!>
</div>

[link]
<div><a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:caption!></a></div><dolf>

