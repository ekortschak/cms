[include]
LOC_TPL/editor/edit.tpl

[vars]
hgt = 100%
cols = 50

# ***********************************************************
[main]
# ***********************************************************
<div class="collection" style="background-image: url('<!VAR:file!>');">
<img src="ICONS/1x1.gif" width="100%" />
</div>

[alternative]
<div align="center">
<img src="<!VAR:file!>" style="max-width: 100%; max-height: <!VAR:hgt!>; margin: 12px 0px 15px;" />
</div>
