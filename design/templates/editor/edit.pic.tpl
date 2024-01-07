[include]
LOC_TPL/editor/edit.tpl

[vars]
hgt = 100%
cols = 50

# ***********************************************************
[main]
# ***********************************************************
<img class="max" src="<!VAR:file!>" width="100%" />

[alternative]
<div align="center">
<img src="<!VAR:file!>" style="max-width: 100%; max-height: <!VAR:hgt!>; margin: 12px 0px 15px;" />
</div>

