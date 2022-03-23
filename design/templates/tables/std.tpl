[vars]
lines = 25
sql = Select * from ?

[dic]
nocols = No columns to display!
page = Page

[dic.de]
nocols = Keine Spalten zum Anzeigen!
page = Seite

# ***********************************************************
[main]
# ***********************************************************
<div class="fullwidth">
	<table class="navi">
<!VAR:body!>
	</table>
<!SEC:TFoot!>
</div>

# ***********************************************************
[Heading]
# ***********************************************************
<h4><!VAR:title!></h4>

# ***********************************************************
[TRows]
# ***********************************************************
	<tr class="<!VAR:class!>">
		<!VAR:data!>
		<td width="100%">&nbsp;</td>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<!VAR:data!>
		<th width="100%">&nbsp;</th>
	</tr>

[TSums]

# ***********************************************************
[THead]
# ***********************************************************
		<th nowrap align="<!VAR:align!>"><!VAR:head!></th>

[TData]
		<td nowrap align="<!VAR:align!>"><!VAR:value!></td>

[TFoot]
<table width="100%">
    <tr class="rf">
        <td><!SEC:stats!>&nbsp;</td>
        <td align="right" nowrap><!SEC:nav!></td>
	</tr>
</table>

# ***********************************************************
[Nav]
# ***********************************************************
<a href="?oid=<!VAR:oid!>&cur=<!VAR:cur!>&act=f"><img src="core/icons/move/First.gif" /></a>
<a href="?oid=<!VAR:oid!>&cur=<!VAR:cur!>&act=p"><img src="core/icons/move/Left.gif"  /></a>
<a href="?oid=<!VAR:oid!>&cur=<!VAR:cur!>&act=n"><img src="core/icons/move/Right.gif" /></a>
<a href="?oid=<!VAR:oid!>&cur=<!VAR:cur!>&act=l"><img src="core/icons/move/Last.gif"  /></a>

[stats]
<!DIC:page!> <!VAR:1st!> / <!VAR:cnt!>

[show.sql]
<div class="dropdown">SQL
	<div class="dropdown-content"><!VAR:sql!></div>
</div>

# ***********************************************************
[Break]
# ***********************************************************
	<tr height=1 bgcolor="maroon">
		<td colspan="100%"></td>
	</tr>
