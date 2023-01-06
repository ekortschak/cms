[vars]
sep =


# ***********************************************************
[main] # multiple options with title
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
	<div class="localmenu">
<!VAR:items!>
	</div>
</div>

[main.box]
<!VAR:uniq!><!VAR:sep!>
<div class="dropdown"><!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div> &emsp;

[main.one]
<!VAR:uniq!><!VAR:sep!> <!VAR:current!> &ensp;
