[vars]
layout = ???
lang = CUR_LANG

# ***********************************************************
[main]
# ***********************************************************
<!DOCTYPE HTML>

<html lang="<!VAR:lang!>">
<head>
	<title><!VAR:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

<!SEC:styles!>
</head>

<!SEC:layout!>
</html>

# ***********************************************************
[styles]
# ***********************************************************
<style>
.box {
	position: fixed;
	top: 30%;
	left: 50%;
	transform: translate(-50%, 0px);
	border: 1px solid grey;
	border-radius: 15px;
	padding: 30px;
	box-shadow: 5px 5px 0px 0px rgba(0, 0, 0, 0.65);
	background: white;
}

body {
	background: gainsboro;
	color: black;
	font: 12pt normal normal Arial, Liberation Sans;
}
h3, h4 {
	color: navy;
	margin: 0px 0px 5px;
	padding: 0px;
}

p {
	margin: 0px;
	padding: 0px;
}
</style>

# ***********************************************************
[layout] <!-- layout.stop -->
# ***********************************************************
<div class="box">

<table>
	<tr>
		<td><img src="LOC_IMG/baustelle.png" width=85 /></td>
		<td width=25>&nbsp;</td>
		<td><!SEC:msg!></td>
	</tr>
</table>

</div>

[msg]
<h3>Info</h3>
<p>An error occurred ...</p>

[msg.de]
<h3>Info</h3>
<p>Diese Seite kann nicht angezeigt werden ...</p>
