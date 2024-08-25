[register]
LOC_SCR/sorter.js

[dic]
sort = Sort entries
howto = Drag and Drop to re-arrange items!
nodata = Nothing to sort ...

[dic.de]
sort = Einträge sortieren
howto = Ziehe die Elemente in die gewünschte Position!
nodata = Keine sortierbaren Einträge ...

[vars]
name = sort.act


# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:sort!></h4>

<small><!DIC:howto!></small>

<form method="post" action="?">
<!SEC:oid!>

	<input type="hidden" name="sort.list" id="slist" />
	<input type="hidden" name="sort.parm" value="<!VAR:sparm!>" />

	<div class="flex flexbottom">
		<div>
			<!VAR:items!>
		</div>
		<div style="padding: 2px 30px;">
			<input type="hidden" name="<!VAR:name!>" value="S" />
			<input type="submit" value="OK" />
		</div>
	</div>
</form>


[item]
<button class="drag block" draggable="true" data-x="<!VAR:cnt!>" data-fso="<!VAR:fso!>" _
	ondragstart="start(event)" ondragover="hover(event)" ondrop="dropped(event)">_
		<!VAR:text!>_
</button>

[nodata]
<msg><!DIC:nodata!></msg>
