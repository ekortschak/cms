[include]
LOC_TPL/input/selROnly.tpl

[register]
core/scripts/imageMap.js

# ***********************************************************
[input.img] # currently one line pix only !
# ***********************************************************
<div class="rating" id="div.<!VAR:fname!>" style="background-position-Y: <!VAR:pos!>px;">
	<input type="hidden" id="<!VAR:fname!>" name="<!VAR:fname!>" value="<!VAR:curVal!>" />
	<img id="img.<!VAR:fname!>" src="LOC_ICO/1x1.gif"
		width=100 height=15 onload="createMap('<!VAR:fname!>', 20, 20);" />
</div>
