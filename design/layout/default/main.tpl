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

	<meta name="scView" content="width=device-width, initial-scale=1" />
#	<meta name="keywords" content="PRJ_TITLE" />
#	<meta name="description" content="<!VAR:desc!>" />

<!SEC:styles!>
<!SEC:scripts!>
</head>

<!SEC:layout!>
</html>

# ***********************************************************
[layout]
# ***********************************************************
<body>
	<div class="modtabs"><!SEC:tabs!></div>
	<div class="modtoc" id="modToc"> <!SEC:toc!> </div>
	<div class="modmbar"><!SEC:mbar!></div>
	<div class="modbody"><!SEC:body!></div>
	<div class="moddeco"><!SEC:deco!></div>
</body>

[styles]
<link rel="StyleSheet" href="CSS_URL?layout=LAYOUT" type="text/css" />
<!MOD:zzz.styles!>

[scripts]
<!MOD:zzz.scripts!>

# ***********************************************************
# horizontal panels
# ***********************************************************
[banner] <!-- banner -->
<!MOD:banner!>

[menu] <!-- menu -->
<!MOD:menu!>

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
<!MOD:toc!>
<!MOD:toc.footer!>
</div>

<div class="container">
<!MOD:toc.blocks!>
</div>

<br/>

# ***********************************************************
[mbar] <!-- middle bar -->
<div style="padding: 15px 40px; font-size: 4pt;">
	<a class="std" href="config.php">&nbsp;</a>
</div>

<br/>

# ***********************************************************
[body] <!-- body -->
<div class="container" id="scView">
<!MOD:msgs!>
<!MOD:body.feedback!>
<!MOD:body!>
</div>

<br/>

# ***********************************************************
[deco] <!-- deco -->
<div class="container conDeco">
<!MOD:deco!><br>
<!MOD:msgs.log!>
</div>

<br/>
