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

<div class="modBody">
	<!MOD:joker/search.php!>
</div>
