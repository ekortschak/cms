<?php

incCls("editor/dboEdit.php");

// ***********************************************************
$sel = new dboEdit("f");
$sel->edit();

?>

<br>


<h4>Sinnvolle Werte (Entwurf - nicht implementiert)</h4>

<table>
	<tr>
		<th width=50>Typ</th>
		<th>Eingabehilfen</th>
		<th>Anzeigemasken</th>
	</tr>
	<tr>
		<td>int</td>
		<td><ul><li>number <li>range: min - max <li>rating <li>checkbox <li>bool</ul></td>
		<td><ul><li>%d <li>%03d <li>%d pcs</ul></td>
	</tr>
	<tr>
		<td>num</td>
		<td><ul><li>number</ul></td>
		<td><ul><li>%01.2f</ul></td>
	</tr>
	<tr>
		<td>var</td>
		<td><ul><li>text <li>folders: dir <li>files: dir <li>tables <li>fields: tbl <li>dic: ref <li>groups <li>users </ul></td>
		<td><ul><li>&lt;a href="xy">%s&lt;/a> </ul></td>
	</tr>
</table>
