[dic.de]
click = Bitte klicken Sie auf eine Schaltfläche

[dic.de]
click = Please, click a button

[vars]
target = _self


[main]
<div class="flex btnbar">
<!VAR:items!>
</div>

# ***********************************************************
[group]
# ***********************************************************
<div><!VAR:group!></div>

# ***********************************************************
[button]
# ***********************************************************
<a href="<!VAR:link!>" target="<!VAR:target!>">
	<button class="<!VAR:class!>"><!VAR:pic!> <!VAR:caption!></button>
</a>

[button.tip]
<refbox><!SEC:button!>
<refbox-content><!VAR:tip!></refbox-content>
</refbox>

[pic]
<img src="<!VAR:pic!>" />

# ***********************************************************
# navigation
# ***********************************************************
[wrong.btn]
<!DIC:click!>
