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
width = 125
current = ???
sep = :

tspace = 0
bspace = 1


# ***********************************************************
# common parts
# ***********************************************************
[content]
<div class="dropdown-content">
<!VAR:links!>
</div>

[link]
<div><a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:caption!></a></div><dolf>

# ***********************************************************
[main] # simple combo box
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<!VAR:items!>
</div>

[main.box]
<div class="dropdown">
<button><!VAR:current!>COMBO_DOWN</button>
<!SEC:content!>
</div>

[main.one]
<button><!VAR:current!></button>

# ***********************************************************
[inline]
# ***********************************************************
<!VAR:items!>

[inline.box]
<div class="dropdown">
<!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div>

[inline.one]
<!VAR:current!>
