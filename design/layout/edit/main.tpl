[include]
design/layout/default/main.tpl


# ***********************************************************
[main]
# ***********************************************************
<!DOCTYPE HTML>

<html lang="CUR_LANG">
<head>
	<title><!VAR:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

	<meta name="robots" content="noindex">
	<meta name="scView" content="width=device-width, initial-scale=1" />
#	<meta name="keywords" content="PRJ_TITLE" />
#	<meta name="description" content="<!VAR:desc!>" />

<!SEC:styles!>
<!SEC:scripts!>
</head>

<!SEC:layout!>
</html>

[styles]
<link rel="StyleSheet" href="CSS_URL?layout=default&reset=1" type="text/css" />
<!MOD:zzz.styles!>
