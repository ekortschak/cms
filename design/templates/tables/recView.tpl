[include]
LOC_TPL/tables/std.tpl

# ***********************************************************
[TRows]
# ***********************************************************
	<tr class="<!VAR:class!>">
		<td nowrap align="center">
			<a href="?oid=<!VAR:oid!>&rec=<!VAR:recid!>">
				<img src="ICONS/db/edit.gif" />
			</a>
		</td>
		<!VAR:data!>
	</tr>

[TCols]
	<tr class="<!VAR:class!>">
		<th nowrap align="center">
			<a href="?oid=<!VAR:oid!>&rec=-1">
				<img src="ICONS/db/new.gif" />
			</a>
		</th>
		<!VAR:data!>
	</tr>
