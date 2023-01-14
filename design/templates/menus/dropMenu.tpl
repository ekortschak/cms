[include]
dropBox.tpl

[vars]
class = dropMenu


# ***********************************************************
[main] # multiple options with title
# ***********************************************************
<div class="<!VAR:class!>">
<!VAR:items!>
</div>

[main.box]
<div class="dropdown">
<!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div> &ensp;

[main.one]
<!VAR:current!> &ensp;
