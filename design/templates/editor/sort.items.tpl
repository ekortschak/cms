[register]
LOC_SCR/sorter.js

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

<small><b>Info</b>: <!DIC:howto!></small>

<form method="post" action="?">
	<input type="hidden" name="slist" id="slist" />
	<input type="hidden" name="sparm" value="<!VAR:sparm!>" />

	<div class="flexleft flexbottom">
		<div>
			<!VAR:items!>
		</div>
		<div style="padding: 2px 30px;">
			<input type="submit" name="sort.act" value="OK" style="padding:0px 20px;" />
		</div>
	</div>
</form>


[item]
<button class="drag block" draggable="true" data-x="<!VAR:cnt!>" data-fso="<!VAR:fso!>" _
	ondragstart="start(event)" ondragover="hover(event)" ondrop="dropped(event)">_
		<!VAR:text!>_
</button>

[nodata]
<p><!DIC:nodata!></p>
