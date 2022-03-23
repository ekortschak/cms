[vars]
caption = Test
info = Any description ...
color = FC_BODY

[lookup.abbr]
<abbr title="<!VAR:info!>"><!VAR:caption!></abbr><nolf>

[lookup]
<refbox style="color: <!VAR:color!>;">
<!VAR:caption!>_
<refbox-content><!VAR:info!></refbox-content>
</refbox><nolf>

[doc]
<!VAR:caption!> {dt: <!VAR:info!>}<nolf>

[pdf]
<lookup><!VAR:caption!> <hint>(<!VAR:info!>)</hint></lookup>

[bing]
<refbox bing=1><!VAR:caption!>
<refbox-content><a href="<!VAR:link!>" target="bing"><!VAR:info!></a><br>
📌&nbsp;<!VAR:autor!>
</refbox-content>
</refbox><nolf>
