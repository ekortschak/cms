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
