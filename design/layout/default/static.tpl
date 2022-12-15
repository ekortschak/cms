[include]
design/layout/LAYOUT/main.tpl

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

	<link rel="StyleSheet" href="site.css" type="text/css" />
<!SEC:styles!>
<!SEC:scripts!>
</head>

<!SEC:layout!>
</html>

# ***********************************************************
[toc] <!-- toc -->
<div class="container conToc">
<!MOD:toc!>
</div>

# ***********************************************************
[body] <!-- body -->
<div class="container">
<!MOD:body!>
</div>

# ***********************************************************
[opts] <!-- opts -->
&nbsp;
