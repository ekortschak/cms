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
	<meta name="device" content="width=device-width, initial-scale=1" />
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
<link rel="StyleSheet" href="x.css.php?layout=LAYOUT" type="text/css" />
<!MOD:zzz.styles!>

[scripts]
<!MOD:zzz.scripts!>


# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="joker"  ><!SEC:joker!></div>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" ><!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="modBody"><!SEC:body!></div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>

# ***********************************************************
# horizontal panels
# ***********************************************************
[joker] <!-- escape for small viewports -->
<!MOD:css.joker!>

[menu] <!-- banner -->
#<!MOD:menu!>

[status] <!-- status -->
#<!MOD:app.status!>

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
<!MOD:toc!>
</div>

<div class="container">
<!MOD:toc.blocks!>
</div>

# ***********************************************************
[mbar] <!-- middle bar -->

# ***********************************************************
[body] <!-- body -->
<div class="conHead">
<!MOD:body.head!>
</div>

<div class="container" id="scView">
<!MOD:body.feedback!>
<!MOD:body!>
</div>

# ***********************************************************
[bord] <!-- border right -->

# ***********************************************************
[opts] <!-- opts -->
<div class="container conOpts">
<!MOD:app.info!>
<!MOD:user.opts!>
<!MOD:user.tags!>
<!MOD:msgs!>
<!MOD:debug.timer!>
</div>
