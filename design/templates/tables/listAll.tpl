[include]
design/templates/tables/std.tpl

# ***********************************************************
[main]
# ***********************************************************
<p>
	<div class="fullwidth">
<table border=0>
    <!VAR:body!>
</table>
	</div>
</p>

# ***********************************************************
[TRows]
# ***********************************************************
	<tr class="<!VAR:class!>">
		<!VAR:data!>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<!VAR:data!>
	</tr>
