[dic.de]
click = Bitte klicken Sie auf eine Schaltfläche

[dic.de]
click = Please, click a button

[vars]
target = _self


[main]
<div class="btnbar">
<!VAR:items!>
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
	<button class="icon"><img src="ICONS/buttons/view.png" alt="View" /></button>
</a>

[wrong.btn]
<!DIC:click!>
