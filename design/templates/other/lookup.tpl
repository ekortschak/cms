[register]
LOC_SCR/mousewatch.js


[vars]
caption = Test
info = [ ??? ]
color = FC_BODY


[lookup]
<refbox style="color: <!VAR:color!>;"><!VAR:caption!>
<refbody><b><!VAR:key!></b><br><!VAR:info!></refbody>
</refbox><nolf>

[xsite]
<!VAR:caption!><nolf>

[doc]
<!VAR:caption!> {dt: <!VAR:info!>}<nolf>

[pdf]
<lookup><!VAR:caption!> <hint>(<!VAR:info!>)</hint></lookup>
