[dic]
tpl.missing = Missing template
mytpl = Templates involved

[dic.de]
tpl.missing = Vorlage nicht gefunden
mytpl = Beteiligte Vorlagen

[vars]
history = Info: section 'main' is missing ...
file =


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<div class="dropdown"><img src="ICONS/buttons/file.missing.png" style="vertical-align: bottom;" alt="load error"> <!VAR:tplfile!>COMBO_DOWN
	<div class="dropdown-content">
		<!VAR:history!>
	</div>
</div>

# ***********************************************************
[item.1]
# ***********************************************************
<div><!VAR:item!></div>

[item.0]
<div><red><!VAR:item!></red></div>


# ***********************************************************
[history]
# ***********************************************************
<div class="dropdown pre">&spades;
	<div class="dropdown-content">
		<h4><!DIC:mytpl!></h4>
		<ul>
		<!VAR:items!>
		</ul>
	</div>
</div>

[hist.last]
<li><blue><!VAR:item!></blue></li>

[hist.item]
<li><!VAR:item!></li>
