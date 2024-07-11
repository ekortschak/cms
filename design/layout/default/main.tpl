
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
	<title><!SEC:title!></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="expires" content="0" />

#	<meta name="robots" content="noindex">
	<meta name="device" content="width=device-width, initial-scale=1" />
#	<meta name="keywords" content="PRJ_TITLE" />
#	<meta name="description" content="<!VAR:desc!>" />

<!SEC:styles!>
<!SEC:scripts!>
</head>

<body>
<!SEC:frame!>
</body>

</html>

[frame]
<div class="flex">
<!SEC:layout!>
</div>

# ***********************************************************
# last to execute
# ***********************************************************
[styles]
<link rel="StyleSheet" href="x.css.php?style=SSHEET" type="text/css" />
<!MOD:zzz/styles!>

[scripts]
<!MOD:zzz/scripts!>

[title]
<!VAR:title!>

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<div class="modTabs"><!SEC:tabs!></div>
<div class="modToc" ><!SEC:toc!> </div>
<div class="modMbar"><!SEC:mbar!></div>
<div class="colMain"><!SEC:page!></div>
<div class="modBord"><!SEC:bord!></div>
<div class="modOpts"><!SEC:opts!></div>

[page]
<div class="joker"><!SEC:joker!></div>
<div class="titBody"><!SEC:topics!></div>
<div class="titBody"><!SEC:head!></div>
<div class="modBody"><!SEC:body!></div>


# ***********************************************************
# horizontal panels
# ***********************************************************
[joker] <!-- escape for small viewports -->
<!MOD:joker!>

[topics]
<!MOD:body/topics!>

[menu] <!-- banner -->
#<!MOD:menu!>

[status] <!-- status -->
#<!MOD:app/status!>

# ***********************************************************
# vertical panels
# ***********************************************************
[tabs] <!-- tabs -->
<div style="padding: 7px 0px;">
<!MOD:tabs!>
</div>

# ***********************************************************
[toc] <!-- toc -->
<!MOD:toc/banner!>
<!MOD:toc/topics!>
<!MOD:toc/current!>
<!MOD:toc!>
<!MOD:toc/blocks!>
<!MOD:toc/status!>

# ***********************************************************
[mbar] <!-- middle bar -->
[bord] <!-- border right -->

# ***********************************************************
[head] <!-- sticky info -->
<!MOD:body/head!>
<!MOD:body/feedback!>

[body] <!-- body -->
<!MOD:body!>

# ***********************************************************
[opts] <!-- opts -->
<!MOD:app/info!>
<!MOD:user/opts!>
<!MOD:user/tags!>
<!MOD:msgs!>
<!MOD:debug/timer!>
