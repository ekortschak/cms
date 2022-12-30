[include]
LOC_LAY/default/offline.tpl


# ***********************************************************
[layout]
# ***********************************************************
<div class="box">

<table>
	<tr>
		<td style="vertcal-align: middle;"><img src="CMS_URL/img/timeout.png" width=85 /></td>
		<td width=25>&nbsp;</td>
		<td style="vertcal-align: middle;"><!SEC:msg!></td>
	</tr>
</table>

</div>


[msg]
<h3>Info</h3>
<p>Your session has timed out!<br>
(timeout = TIMEOUT minutes)<p>

<br>

<div align="right">
	<a href="?vmode=view"><button>Restart</button></a>
</div>

[msg.de]
<h3>Info</h3>
<p>Die Sitzung ist abgelaufen!<br>
(Timeout = TIMEOUT Minuten)</p>

<br>

<div align="right">
	<a href="?vmode=view"><button>Neustart</button></a>
</div>

