[register]
core/scripts/sorter.js

[dic]
sort = Sort entries
howto = Drag and Drop to re-arrange items!
nodata = Nothing to sort ...

[dic.de]
sort = Einträge sortieren
howto = Elemente in die gewünschte Position ziehen!
nodata = Keine sortierbaren Einträge ...


# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:sort!></h4>

<p><b>Info</b>: <!DIC:howto!></p>

<form method="post" action="?">
	<input type="hidden" name="slist" id="slist" />
	<input type="hidden" name="sparm" value="<!VAR:sparm!>" />

	<div style="display: inline-block;">
	<ul>
		<!VAR:items!>
	</ul>
	</div>

	<p align="right">
		<input type="submit" name="sort.act" value="OK" style="padding:0px 20px;" />
	</p>
</form>


[item]
		<li class="drag" draggable="true" data-x="<!VAR:cnt!>" data-fso="<!VAR:fso!>" _
			ondragstart="start(event)" ondragover="hover(event)" ondrop="dropped(event)">_
				<!VAR:text!>_
		</li>

[nodata]
<p><!DIC:nodata!></p>
