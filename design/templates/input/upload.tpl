[dic]
mSize   = Max. file size
fdest   = Destination
ftypes  = Allowed file types
exist   = Existing files
owrite  = Overwrite
go      = Upload now!

[dic.de]
mSize   = Max. Dateigröße
fdest   = Zielordner
ftypes  = Zulässige Dateitypen
exist   = Bestehende Dateien
owrite  = überschreiben
go      = Jetzt hochladen!


# ***********************************************************
[vars]
# ***********************************************************
mSize  = 1500
fdest  = .files
ftypes = pdf, csv


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" enctype="multipart/form-data">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

<table>
	<tr>
		<td class="selHead"><!DIC:fdest!></td>
		<td class="selData"><!VAR:fdest!></td>
	</tr>
	<tr>
		<td class="selHead"><!DIC:ftypes!></td>
		<td class="selData"><!VAR:ftypes!></td>
	</tr>
	<tr>
		<td class="selHead" width=170><!DIC:mSize!></td>
		<td class="selData"><!VAR:mSize!> MB</td>
	</tr>
	<tr>
		<td class="selHead"><!DIC:exist!></td>
		<td class="selData">
			<input type="hidden"   name="replace" value=0 />
			<input type="checkbox" name="replace" value=1 CHECKED class="cb" />
			<!DIC:owrite!>
		</td>
	</tr>
</table>


<h5>Select file(s)</h5>
<dl>
<!VAR:files!>
</dl>

<p align="right">
	<input type="submit" name="upload.act" value="<!DIC:go!>" />
</p>

</form>

# ***********************************************************
[files]
# ***********************************************************
	<dt><!VAR:desc!></dt>
	<dd>
		<input type="file"   name="file[<!VAR:index!>]" value="" size="55" />
		<input type="hidden" name="ren[<!VAR:index!>]"  value="<!VAR:rename!>" /><br>
		&nbsp; &nbsp; <hint>will be renamed to: <!VAR:rename!></hint>
	</dd>
