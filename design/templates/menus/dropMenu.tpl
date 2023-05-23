[include]
LOC_TPL/menus/dropBox.tpl

[vars]
class = dropMenu
sep = :

# ***********************************************************
[main] # multiple options with title
# ***********************************************************
<div class="<!VAR:class!>" style="text-align: <!VAR:align!>;">
<!VAR:items!>
</div>

[main.box]
<!SEC:combo!>

[main.one]
<!SEC:text!>

[empty]
<div class="dropMenu"><!DIC:no.data!></div>
