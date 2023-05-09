[dic]
conv = Save as
sure = Sure?
clip = Copy to clipboard
apply = Save

[dic.de]
conv = Speichern als
sure = Sicher?
clip = In Zwischenablage kopieren
apply = Speichern

[vars]
placeholder =


# ***********************************************************
[submit]
# ***********************************************************
<div style="text-align: right; margin: 5px 0px;">
	<a href="?file_act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');">
		<button>BOOL_NO</button>
	</a>

	<input type="hidden" name="orgName" value="<!VAR:file!>" />
	<input type="text" name="filName" value="<!VAR:file!>" class="filename" />

	<button name="file_act" value="save" onclick="exSubmit();">
		<img src="LOC_ICO/buttons/save.png" />
	</button>
</div>

# ***********************************************************
[submit.simple]
# ***********************************************************
<div style="text-align: right; margin: 5px 0px;">
	<input type="hidden" name="filName" value="<!VAR:file!>" />

	<button name="file_act" value="save" onclick="exSubmit();">
		<img src="LOC_ICO/buttons/save.png" />
	</button>
</div>

# ***********************************************************
[ctarea]
# ***********************************************************
<textarea id="content" name="content" class="max" rows="<!VAR:rows!>" _
placeholder="<!VAR:placeholder!>" tabindex=0 _
autocomplete="off" autocorrect="off" autocapitalize="off" _
spellcheck="false"><!VAR:content!></textarea>
