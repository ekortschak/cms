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
<!SEC:menu.box!>

[main.one]
<!SEC:menu.one!>


# ***********************************************************
[compact] # multiple options with title
# ***********************************************************
<div class="localmenu">
<!VAR:items!>
</div>

[compact.box]
<div class="dropdown"><!VAR:current!>&ensp;▾
<!SEC:content!>
</div> &ensp;

[compact.one]
<!VAR:current!> &ensp;
