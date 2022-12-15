# ***********************************************************
[main]
# ***********************************************************
<!DOCTYPE HTML>

<html lang="CUR_LANG">
<head>
	<title><!VAR:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />
#	<meta name="keywords" content="PRJ_TITLE" />
#	<meta name="description" content="<!VAR:desc!>" />

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
	border: 1px solid navy;
	border-radius: 15px;
	padding: 30px;
	box-shadow: 5px 5px 0px 0px rgba(0, 0, 0, 0.65);
	background: white;
}

body {
	background: rgb(238,238,238);
	font: 12pt normal normal Arial, DejaVu Sans;
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
[layout]
# ***********************************************************
<div class="box">

<table>
	<tr>
		<td style="vertcal-align: middle;"><img src="CMS_URL/img/baustelle.png" width=85 /></td>
		<td width=25>&nbsp;</td>
		<td style="vertcal-align: middle;"><!SEC:msg!></td>
	</tr>
</table>

</div>

[msg]
<h3>Info</h3>
<p>This page is currently under construction.<br>
Please, come back later.</p>

[msg.de]
<h3>Info</h3>
<p>Diese Seite wird zur Zeit überarbeitet.<br>
Bitte probieren Sie es später wieder.</p>
