
[vars]
checked = CHECKED
lang = CUR_LANG

[dic]
replace = Replace

[dic.de]
replace = Ersetzen


[main]
<h4><!SEC:refs!></h4>

<form method="post" action="?">
<!VAR:items!>
<hr>
	<div class="flex">
		<!SEC:hint!>
		<input type="submit" name="act_xlref" value="<!DIC:replace!>" />
	</div>
</form>

[item]
<div>
	<input type="checkbox" name="ref" value="<!VAR:ref!>" <!VAR:checked!> />
	<div class="dropdown"><!VAR:ref!>
		<div class="dropdown-content" style="max-wdith: 700px;">
			<!VAR:cur!> ... <hr> <!VAR:new!>
		</div>
	</div>
</div>



[refs]
<p>Bible passages to be replaced</p>

[refs.de]
<p>Zu ersetztende Bibelverse</p>



[hint]
<msg><b>Info</b>: Changes will affect <dfn><!VAR:lang!>.htm</dfn> &nbsp;</msg>

[hint.de]
<msg><b>Info</b>: Änderungen betreffen <dfn><!VAR:lang!>.htm</dfn> &nbsp;</msg>


[protected]
<h4>Info</h4>
<p>File is write protected ...</p>

[protected.de]
<h4>Info</h4>
<p>Datei ist schreibgeschützt ...</p>
