[include]
LOC_LAY/LAYOUT/main.tpl

[register]
LOC_SCR/metakeys.js

# ***********************************************************
[body] <!-- body.seo -->
# ***********************************************************
<div class="container">
<!MOD:edit.seo!>

<div class="cold" id="pgeView" contenteditable="true" spellcheck="false">
<!MOD:body!>
</div>

<script type="text/javascript" language="JavaScript1.2">
	obj = document.getElementById("pgeView");
	obj.addEventListener("keydown", function(e) { e = doKeys(e); });
</script>

</div>
