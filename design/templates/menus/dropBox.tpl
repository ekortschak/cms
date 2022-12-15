[dic]
table = Table
field = Field
range = Range

[dic.de]
table = Tabelle
field = Feld
range = Bereich

[vars]
qid = dropbox
parm = ref
type = button
width = 125
current = ???

tspace = 0
bspace = 3


# ***********************************************************
# common parts
# ***********************************************************
[content]
<div class="dropdown-content">
<!VAR:links!>
</div>

[link]
<div><a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:caption!></a></div>

# ***********************************************************
[main] # simple combo box
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<!VAR:items!>
</div>

[main.box]
<div class="dropdown">
	<button class="dropdown-button"><!VAR:current!>&emsp;▾</button>
<!SEC:content!>
</div> &emsp;

[main.one]
<button><!VAR:current!></button> &emsp;

# ***********************************************************
[inline]
# ***********************************************************
<!VAR:items!>

[inline.box]
<!SEC:main.box!>

[inline.one]
<!SEC:main.one!>

# ***********************************************************
[menu] # multiple options with title
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
	<div class="localmenu">
<!VAR:items!>
	</div>
</div>

[menu.box]
<!VAR:uniq!>:
<div class="dropdown"><!VAR:current!>&nbsp; ▾
<!SEC:content!>
</div> &emsp;

[menu.one]
<!VAR:uniq!>: <!VAR:current!> &emsp;
