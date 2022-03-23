
[vars]
checked = CHECKED

[dic]
replace = Replace

[dic.de]
replace = Ersetzen


[main]
<form method="post" action="?">
<!VAR:items!>

	<input type="submit" name="act_xlref" value="<!DIC:replace!>" />
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

