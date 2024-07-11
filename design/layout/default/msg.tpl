[vars]
lang = CUR_LANG

pic = baustelle.png
alt = work in progress


# ***********************************************************
[main]
# ***********************************************************
<!DOCTYPE HTML>

<html lang="<!VAR:lang!>">
<head>
	<title><!VAR:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

	<link rel="StyleSheet" href="x.css.php" type="text/css" />
</head>

<!SEC:styles!>
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
	border-radius: BR_MENU;
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
	font-size: 1.25rem;
}

p {
	margin: 0px;
	padding: 0px;
}

button {
	background: linear-gradient(snow, lightgrey);
	border: 1px solid grey;
	border-radius: BR_TEXT;
	padding: 3px 10px;
	cursor: pointer;
}

</style>

[body]
<div class="box">
	<!SEC:msgbox!>
</div>


# ***********************************************************
[msgbox] <!-- layout.stop -->
# ***********************************************************
<table>
	<tr>
		<td><img src="LOC_IMG/<!VAR:pic!>" width=85 alt="<!VAR:alt!>" /></td>
		<td width=25>&nbsp;</td>
		<td><!SEC:msg!></td>
	</tr>
</table>

# ***********************************************************
[msg]
# ***********************************************************
<h3>Info</h3>
<p>An error occurred ...</p>

[msg.de]
<h3>Info</h3>
<p>Diese Seite kann nicht angezeigt werden ...</p>
