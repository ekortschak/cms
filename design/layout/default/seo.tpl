[include]
design/layout/LAYOUT/main.tpl

[register]
core/scripts/metakeys.js

# ***********************************************************
[body] <!-- body -->
# ***********************************************************
<div class="container">
<!MOD:msgs!>
<!MOD:edit.seo!>

#<div id="pgeView" class="cold" contenteditable="true" spellcheck="false">
#<!MOD:body!>
#</div>

#<script type="text/javascript" language="JavaScript1.2">
#	obj = document.getElementById("pgeView");
#	obj.addEventListener("keydown", function(e) { e = doKeys(e); });
#</script>

</div>

<br>
