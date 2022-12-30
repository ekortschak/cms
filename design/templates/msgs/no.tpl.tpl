[vars]
original = nothing
file =

[dic]
tpl.missing = Missing template
mytpl = Templates involved

[dic.de]
tpl.missing = Vorlage nicht gefunden
mytpl = Beteiligte Vorlagen


# ***********************************************************
[main]
# ***********************************************************
<!SEC:notpl!>

[notpl]
<div class="dropdown"><img src="ICONS/buttons/file.missing.png" />
	<div class="dropdown-content">
		<!DIC:tpl.missing!>: <!VAR:file!>
	</div>
</div>

[dbg]
<div class="dropdown">&spades;
	<div class="dropdown-content">
		<pre><!VAR:items!></pre>
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
