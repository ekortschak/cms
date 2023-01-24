[vars]
class = dropMenu
sep =

# ***********************************************************
[main] # multiple options with title
# ***********************************************************
<div class="<!VAR:class!>">
<!VAR:items!>
</div>

[main.box]
<!VAR:uniq!><!VAR:sep!>
<div class="dropdown">
<!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div> &ensp;

[main.one]
<!VAR:uniq!><!VAR:sep!> <!VAR:current!> &ensp;
