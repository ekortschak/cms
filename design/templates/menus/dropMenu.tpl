[include]
dropBox.tpl

[vars]
class = localmenu


# ***********************************************************
[main] # multiple options without title
# ***********************************************************
<div class="localmenu">
<!VAR:items!>
</div>

[main.box]
<div class="dropdown"><!VAR:current!>&ensp;▾
<!SEC:content!>
</div> &ensp;

[main.one]
<!VAR:current!> &ensp;
