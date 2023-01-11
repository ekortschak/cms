[dic]
lang  = english, en

[dic.de]
lang  = deutsch, de

[vars]
title = PRJ_TITLE


# ***********************************************************
[main]
# ***********************************************************
<!DOCTYPE HTML>

<html lang="CUR_LANG">
<head>
	<title><!VAR:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

#	<meta name="robots" content="noindex">
	<meta name="scView" content="width=device-width, initial-scale=1" />
#	<meta name="keywords" content="PRJ_TITLE" />
#	<meta name="description" content="<!VAR:desc!>" />

<!SEC:styles!>
<!SEC:scripts!>
</head>

<!SEC:layout!>
</html>

# ***********************************************************
# last to execute
# ***********************************************************
[styles]
<link rel="StyleSheet" href="CSS_URL?layout=LAYOUT" type="text/css" />
<!MOD:zzz.styles!>

[scripts]
<!MOD:zzz.scripts!>


# ***********************************************************
[layout]
# ***********************************************************
<body>
	<div class="modtabs"><!SEC:tabs!></div>
	<div class="modtoc" id="modToc"> <!SEC:toc!> </div>
	<div class="modmbar"><!SEC:mbar!></div>
	<div class="modbody"><!SEC:body!></div>
	<div class="modopts"><!SEC:opts!></div>
</body>

# ***********************************************************
# horizontal panels
# ***********************************************************
[banner] <!-- banner -->
<!MOD:app.banner!>

[menu] <!-- menu -->
<!MOD:menu!>

[trailer] <!-- banner -->
<!MOD:app.trailer!>

# ***********************************************************
# vertical panels
# ***********************************************************
[tabs] <!-- tabs -->
<div class="container" style="padding: 7px 0px;">
<!MOD:tabs!>
</div>

# ***********************************************************
[toc] <!-- toc -->
<div class="container conToc" id="maindow">
<!MOD:toc.banner!>
<!MOD:toc.topics!>
<!MOD:toc.current!>
<!MOD:toc!>
<!MOD:toc.footer!>
</div>

<div class="container">
<!MOD:toc.blocks!>
</div>

<br>

# ***********************************************************
[mbar] <!-- middle bar -->
<div style="padding: 15px 40px; font-size: 4pt;">
	<a class="std" href="config.php">&nbsp;</a>
</div>

<br>

# ***********************************************************
[body] <!-- body -->
<div class="container" id="scView">
<!MOD:body.head!>
<!MOD:body.feedback!>
<!MOD:body!>
</div>

<br>

# ***********************************************************
[opts] <!-- opts -->
<div class="container conOpts">
<!MOD:app.info!>
<!MOD:user.opts!>
<!MOD:msgs!>
<!MOD:msgs.log!>
</div>

<br>
