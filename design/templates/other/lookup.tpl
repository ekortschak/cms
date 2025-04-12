[register]
LOC_SCR/mousewatch.js


[vars]
caption = Test
info = [ ??? ]
color = FC_BODY


[lookup]
<refbox style="color: <!VAR:color!>;"><!VAR:caption!> _
<refbody><b><!VAR:key!></b><br><!VAR:info!></refbody> _
</refbox>

[ebook]
<!VAR:caption!>

[doc]
<!VAR:caption!> {dt: <!VAR:info!>}

[pdf]
<lookup><!VAR:caption!> <hint>(<!VAR:info!>)</hint></lookup>
