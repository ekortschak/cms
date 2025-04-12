[dic]
toc = Table of Contents
fnote = End Notes

[dic.de]
toc = Inhaltsverzeichnis
fnote = Endnoten

[vars]
page = 0

# ***********************************************************
[main.toc]
# ***********************************************************
<h1><!VAR:topic!></h1>
<p>Glaubst du wirklich, was du sagst?</p>

<table width="100%">
<!VAR:items!>
</table>

# ***********************************************************
[toc]
# ***********************************************************
[toc.lev1]
<tr>
<td><p class="toc1"><!VAR:cap!></p></td>
<td align="right"><p class="pge1"><!VAR:page!></p></td>
</tr>

[toc.lev2]
<tr>
<td><p class="toc2"><!VAR:cap!></td>
<td align="right"><p class="pge2"><!VAR:page!></p></td>
</tr>

[toc.levx]
<tr>
<td><p class="tocx"><!VAR:cap!></td>
<td align="right"><p class="pgex"><!VAR:page!></p></td>
</tr>

# ***********************************************************
[main.fnote]
# ***********************************************************
PAGE_BREAK

<h1><!DIC:fnote!></h1>
<!VAR:items!>
<br>

# ***********************************************************
[fnote]
# ***********************************************************
<div><sup><fnote><!VAR:idx!></fnote></sup> <b><!VAR:key!></b><br><!VAR:val!></div>
