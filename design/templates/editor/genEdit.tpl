[register]
core/scripts/inline.js

[dic]
conv = Save as
not.editable = File not editable!
sure = Sure?
step = Step
clip = Copy to clipboard
apply = Save
xlate = Translation

xdic.copy = How to proceed
xdic.copy = <a href="javascript:clip();">Copy</a> textarea to clipboard (Textfeld wird automatisch geleert)
xdic.paste = Paste copied text into online <a href="https://translate.google.com/" target="xlate">translator</a>.
xdic.return = Paste translated text into textarea above. <kbd>Ctrl</kbd><kbd>v</kbd>
xdic.edit = <a href="?pic.editor=html">Edit</a> translation

[dic.de]
conv = Speichern als
not.editable = Datei ist nicht zum Bearbeiten vorgesehen!
sure = Sicher?
step = Schritt
clip = In Zwischenablage kopieren
apply = Speichern
xlate = Übersetzung

xdic.head = Anleitung
xdic.copy = Textfeld <a href="javascript:clip();">kopieren</a> (Textfeld wird automatisch geleert)
xdic.paste = Kopierten Text in online <a href="https://translate.google.com/" target="xlate">Übersetzer</a> einfügen.
xdic.return = Übersetzten Text in das Textfeld einfügen. <kbd>Strg</kbd><kbd>v</kbd>
xdic.edit = Übersetzung <a href="?pic.editor=html">nachbearbeiten</a>

[vars]
rows = 45


# ***********************************************************
[submit]
# ***********************************************************
	<div style="text-align: right;">
		<a href="?file_act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');">
			<dmbtn><maroon>&cross;</maroon></dmbtn>
		</a>

		<input type="hidden" name="orgName" value="<!VAR:file!>" />
		<input type="text" name="filName" value="<!VAR:file!>" class="filename" />

		<button name="file_act" value="save" class="icon" onclick="exSubmit();">
			<img src="core/icons/buttons/save.png" />
		</button>
	</div>

# ***********************************************************
[mime]
# ***********************************************************
#<p><!DIC:not.editable!></p>
<embed id="pic" src="<!VAR:file!>" width="100%" height=500 />

<form method="post" action="?">
<!SEC:submit!>
</form>

# ***********************************************************
[text]
# ***********************************************************
<form id="inlineEdit" method="post" action="?">
	<textarea id="txtEdit" tabindex=0 name="content" class="tarea" rows="<!VAR:rows!>" _
		spellcheck="false"><!VAR:content!></textarea>
<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	doStore();

	obj = document.getElementById("txtEdit");
	obj.addEventListener("keydown", function(e) { e = doKeys(e); });
</script>

# ***********************************************************
[code]
# ***********************************************************
<div class="cold"><!VAR:content!></div>

[code.xl]
<p><a href="?pic.editor=html">edit</a></p>
<div class="cold"><!VAR:content!></div>


# ***********************************************************
[xdic]
# ***********************************************************
<h4><!DIC:xdic.head!></h4>

<form id="inlineEdit" method="post" action="?">
	<table>
		<tr>
			<td class="selHead"><!DIC:step!> 1:</td>
			<td class="selData"><!DIC:xdic.copy!>
			</td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 2:</td>
			<td class="selData"><!DIC:xdic.paste!></td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 3:</td>
			<td class="selData"><!DIC:xdic.return!></td>
		</tr><tr>
			<td class="selHead">&nbsp;</td>
			<td class="selData">
				<textarea id="txtEdit" name="content" class="tarea" rows="7" _
					spellcheck="false"><!VAR:content!></textarea>
			</td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 4:</td>
			<td class="selData">
				<!DIC:xlate!>
				<input type="submit" name="act_xlate" value="<!DIC:apply!>" />
			</td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 5:</td>
			<td class="selData"><!DIC:xdic.edit!>
		</tr>
	</table>
</form>

# ***********************************************************
[html]
# ***********************************************************
<form id="inlineEdit" method="post" action="?file_act=save">
	<div id="divEdit" class="cold" tabindex=0 contenteditable="true" spellcheck="false" onfocus="this.className='hot';" _
		onblur="this.className='cold';" onkeydown="doStore();">
		<!VAR:content!>
	</div>

	<div id="curEdit" class="inedit"> _
		<textarea id="txtEdit" name="content" class="tarea" rows="<!VAR:rows!>" spellcheck="false" onkeydown="doStore();"></textarea>
	</div>

<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	doStore();

	obj = document.getElementById("divEdit");
	obj.addEventListener("keydown", function(e) { e = doKeys(e); });

	obj = document.getElementById("txtEdit");
	obj.addEventListener("keydown", function(e) { e = doKeys(e); });

// **********************************************************
// key events
// **********************************************************
	function doKeys(e) {
		if (! e.ctrlKey) return;

		switch (e.key) {
			case "b": case "f": addTag("b"); break;
			case "i": case "k": addTag("i"); break;
			case "u":           addTag("u"); break;
			case "s": break;
			default: return;
		}
		e.preventDefault();
		e.stopPropagation();
		e.returnValue = false;

		if (e.key == "s") exSubmit();
		return e;
	}
</script>


# ***********************************************************
[ck4]
# ***********************************************************
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="core/scripts/ck4.editor.js"></script>

<form id="inlineEdit" method="post" action="?">
	<textarea id="txtEdit" name="content" tabindex=0 class="tarea" rows="<!VAR:rows!>" spellcheck="false"><!VAR:content!></textarea>
<!SEC:submit!>
</form>

<script language="javascript">
	CKEDITOR.replace("content", {
		customConfig: '/cms/core/scripts/ck4.config.js'
	});
</script>

<style>
	.cke_wrapper {
		padding: 15px !IMPORTANT;
	}
</style>

# ***********************************************************
[ck5]
# ***********************************************************
<form id="inlineEdit" method="post" action="?">
	<textarea id="txtEdit" name="content" id="editor"><!VAR:content!></textarea>
	<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>

<style>
.ck-editor__editable_inline {
    max-height: 500px;
}
</style>

    <script>
        ClassicEditor
            .create( document.querySelector( '\#txtEdit' ), {
//				toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
 				heading: {
					options: [
						{ model: 'paragraph', title: 'Paragraph' },
  						{ model: 'heading1', view: 'h1', title: 'Heading 1' },
						{ model: 'heading2', view: 'h2', title: 'Heading 2' },
						{ model: 'heading3', view: 'h3', title: 'Heading 3' },
						{ model: 'heading4', view: 'h4', title: 'Heading 4' },
						{ model: 'heading5', view: 'h5', title: 'Heading 5' },
						{ model: 'heading6', view: 'h6', title: 'Heading 6' },
					]
				}
			} )
            .catch( error => {
                console.error( error );
            } );
    </script>

<!SEC:submit!>
</form>

# ***********************************************************
[pic]
# ***********************************************************
<div align="center">
<img src="<!VAR:file!>" style="max-width: 100%; max-height: 300px; margin: 12px 0px 15px;" />
</div>

<div align="right">
<form method="post" action="?">
	<input type="hidden" name="pic_act" value="<!VAR:file!>">
	<input type="text" name="pic_new" value="<!VAR:file!>" class="filename" />
	<button class="icon" onclick="exSubmit();"><img src="core/icons/buttons/save.png" /></button>
</form>
</div>
