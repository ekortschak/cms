[include]
dropBox.tpl


# ***********************************************************
[main] # static info
# ***********************************************************
<div class="dropdown">
<!VAR:items!>
</div> &emsp;

[main.box]
	<button class="dropdown-button"><!SEC:label!>&ensp;▾</button>
<!SEC:content!>

[main.one]
	<button class="dropdown-button"><!SEC:label!></button>


# ***********************************************************
[label]
# ***********************************************************
<div class="micon">
	<div class="ibar"></div>
	<div class="ibar"></div>
	<div class="ibar"></div>
</div>
