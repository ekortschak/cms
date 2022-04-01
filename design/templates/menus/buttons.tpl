[dic.de]
click = Bitte klicken Sie auf eine Schaltfläche

[dic.de]
click = Please, click a button

[vars]
tspace = 0
bspace = 2
target = _self


[main]
<div class="btnbar" style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<!VAR:items!></td>
</div>

# ***********************************************************
[button]
# ***********************************************************
<a href="<!VAR:link!>" target="<!VAR:target!>">
	<button class="<!VAR:class!>"><!VAR:pic!> <!VAR:caption!></button>
</a>

[button.tip]
<refbox>
<!SEC:button!>
<refbox-content><!VAR:tip!></refbox-content>
</refbox>

[pic]
<img src="<!VAR:pic!>" />

# ***********************************************************
# navigation
# ***********************************************************
[item.view]
<a href="APP_CALL?vmode=view">
	<button class="icon"><img src="core/icons/buttons/view.png" alt="View" /></button>
</a>

[wrong.btn]
<!DIC:click!>
