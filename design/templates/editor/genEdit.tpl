[register]
core/scripts/inline.js
core/scripts/keys.js

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


# ***********************************************************
[submit]
# ***********************************************************
	<div style="text-align: right; margin: 5px 0px;">
		<a href="?file_act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');">
			<dmbtn>BOOL_NO</dmbtn>
		</a>

		<input type="hidden" name="orgName" value="<!VAR:file!>" />
		<input type="text" name="filName" value="<!VAR:file!>" class="filename" />

		<button name="file_act" value="save" class="icon" onclick="exSubmit();">
			<img src="core/icons/buttons/save.png" />
		</button>
	</div>
