[dic]
click = Please, click a button

[dic.de]
click = Bitte klicken Sie auf eine Schaltfläche

[vars]
target = ah


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
	<button class="<!VAR:class!> <!VAR:hilite!>"><!VAR:pic!> <!VAR:caption!></button>
</a>

[button.tip]
<!SEC:button!>
#<div class="dropdown"><!SEC:button!>
#<div class="dropbody"><!VAR:tip!></div>
#</div>

[pic]
<img src="<!VAR:pic!>" />

[link]
<a href="<!VAR:link!>" target="<!VAR:target!>">
	<button class="<!VAR:class!>"><!VAR:caption!></button>
</a>

# ***********************************************************
# navigation
# ***********************************************************
[wrong.btn]
<!DIC:click!>
