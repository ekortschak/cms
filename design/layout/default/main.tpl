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
<script>
	window.location = "\#vANCHOR";
</script>

<!MOD:zzz.scripts!>


# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" id="modToc"> <!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="modBody"><!SEC:body!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>

# ***********************************************************
# horizontal panels
# ***********************************************************
[banner] <!-- banner -->
<!MOD:app.banner!>

[menu] <!-- menu -->
<!MOD:menu!>

[trailer] <!-- banner -->
<!MOD:app.status!>

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
<!MOD:toc.status!>
</div>

<div class="container">
<!MOD:toc.blocks!>
</div>

# ***********************************************************
[mbar] <!-- middle bar -->
<div style="padding: 15px 40px; font-size: 4pt;">
	<a class="std" href="config.php">&nbsp;</a>
</div>

# ***********************************************************
[body] <!-- body -->
<div class="hedBody">
<!MOD:body.head!>
</div>

<div class="container" id="scView">
<!MOD:body.feedback!>
<!MOD:body!>
</div>

# ***********************************************************
[opts] <!-- opts -->
<div class="container conOpts">
<!MOD:app.info!>
<!MOD:user.opts!>
<!MOD:user.tags!>
<!MOD:msgs!>
</div>
