[dic]
tpl.missing = Missing template
mytpl = Templates involved

[dic.de]
tpl.missing = Vorlage nicht gefunden
mytpl = Beteiligte Vorlagen

[vars]
missing = section 'main' is missing
original = nothing
file =


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<div class="dropdown"><img src="ICONS/buttons/file.missing.png" style="vertical-align: bottom;" alt="file missing"> <!VAR:missing!>
	<div class="dropdown-content">
		<!VAR:baditems!>
	</div>
</div>

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
<li><blue><!VAR:file!></blue></li>

[hist.item]
<li><!VAR:file!></li>
