[include]
dropBox.tpl

[vars]
class = localmenu


# ***********************************************************
[main] # multiple options with title
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
	<div class="<!VAR:class!>">
<!VAR:items!>
	</div>
</div>

[main.box]
<div class="dropdown">
<!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div> &ensp;

[main.one]
<!VAR:current!> &ensp;
