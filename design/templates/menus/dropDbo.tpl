[include]
LOC_TPL/menus/dropMenu.tpl

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
<!SEC:uniq!> <!SEC:combo!>

[main.one]
<!SEC:uniq!> <!VAR:current!> &ensp;
