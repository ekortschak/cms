[dic]
replace = Replace
current = currently

[dic.de]
replace = Ersetzen
current = derzeit


[main]
<h4><!SEC:refs!></h4>

<form method="post" action="?">
<!SEC:oid!>

<!VAR:items!>
<hr>
	<div class="flex">
		<p>&nbsp;</p>
		<input type="submit" name="act.xlref" value="<!DIC:replace!>" />
	</div>
</form>

[item]
<div>&bull; <!VAR:ref!> &rarr; <!VAR:new!></div>



[refs]
<p>External references to be replaced</p>

[refs.de]
<p>Zu ersetztende externe Referenzen</p>



[protected]
<h4>Info</h4>
<p>File is write protected ...</p>

[protected.de]
<h4>Info</h4>
<p>Datei ist schreibgeschützt ...</p>
