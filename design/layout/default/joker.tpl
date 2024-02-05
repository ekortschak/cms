[include]
LOC_LAY/LAYOUT/main.tpl

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="colMain">
		<!SEC:body!>
	</div>
</body>


# ***********************************************************
[body] <!-- body.search -->
# ***********************************************************
<div class="joker"><!SEC:joker!></div>

<div style="padding: 3px 20px 0px;">
	<!MOD:user/opts!>
	<!MOD:user/tags!>
</div>
