[dic]
search = Search
result = Search results
sinfo  = Search text
short  = Search text<br><small>&ensp; &rarr; min. 2 characters</small>
empty  = Search returned no results
nosel  = Select an entry from the result list
prevw  = Preview
stop   = Stop search
show   = Show

[dic.de]
search = Suche
result = Suchergebnisse
sinfo  = Suchtext
short  = Suchtext<br><small>&ensp; &rarr; min. 2 Buchstaben</small>
empty  = Suche ergab keine Treffer
nosel  = Wähle einen Eintrag aus der Ergebnisliste
prevw  = Vorschau
stop   = Suche beenden
show   = Zeige

[vars]
search =
result =
help   = 1


# ***********************************************************
[main]
# ***********************************************************
<div class="h3"><!DIC:search!></div>
<form method="post" action="?">
<!SEC:oid!>
<!VAR:range!>

	<input type="text" name="search.what" value="<!VAR:search!>" placeholder="<!DIC:sinfo!>" style="width: 100%;" />

	<div class="flex">
		<div class="dmbtn"><!SEC:help!></div>

		<div align="right">
			<a href="?search.reset=1"><div class="dmbtn">BOOL_NO</div></a>
			<input type="submit" name="search.act" value="OK" />
		</div>
	</div>
</form>

[intro]
<font color="black">

[extro]
</font>

# ***********************************************************
[result]
# ***********************************************************
<!VAR:items!>

[nav.toc]
<a href="?vmode=view"><button><img src="LOC_ICO/buttons/view.png" align="right" /></a>

[topic]
<div class="nowrap"><h5><!VAR:topic!></h5></div>

[item]
<div class="nowrap"><a href="?vmode=search&search.tpc=<!VAR:dir!>&search.dir=<!VAR:key!>"><!VAR:title!></a></div>


# ***********************************************************
[preview]
# ***********************************************************
<h4><!DIC:result!></h4>

[prv.goto]
<div style="float: right; margin-top: -7px;">
	<a href="?vmode=view&tpc=<!VAR:topic!>&pge=<!VAR:page!>">
		<button><img src="LOC_ICO/buttons/view.png" alt="View"></button>
	</a>
</div>

[prv.topic]
<div class="submenu">
<img src="LOC_ICO/buttons/view.png" alt="view"> <a href="?vmode=view&tpc=<!VAR:topic!>&pge=<!VAR:page!>"><!VAR:titel!></a>
</div>

[item.sep]
<hr class="search">

# ***********************************************************
[err.empty]
# ***********************************************************
<!SEC:preview!>
<div><!DIC:empty!></div>

[err.nosel]
<!SEC:preview!>
<div><!DIC:nosel!></div>

[err.short]
<div><!DIC:short!></div>


# ***********************************************************
[none]
# ***********************************************************
<div class="mobile">
<!SEC:info!>
<!SEC:howto!>
</div>

[info]
<div class="h3">How to use</div>
<ul>
	<li>Enter a search term into the text field.</li>
	<li>Click OK.</li>
</ul>

<h5>Important</h5>
<ul>
	<li>The search is not case sensitive!</li>
</ul>

[info.de]
<div class="h3">Anleitung</div>
<ul>
	<li>Gib einen Suchbegriff in das Textfeld ein.</li>
	<li>Drücke OK.</li>
</ul>

<h5>Wichtig</h5>
<ul>
	<li>Die Suche unterscheidet nicht zwischen Groß- und Kleinschreibung!</li>
</ul>

# ***********************************************************
[help]
# ***********************************************************
<a href="?search.help=1"><img src="LOC_ICO/buttons/info.png">

[nohelp]
<a href="?search.help=0"><img src="LOC_ICO/buttons/infoClear.png">


# ***********************************************************
[howto]
# ***********************************************************
<h4>Search patterns</h4>
<table>
	<tr class="rh"><th>Pattern</th>                  <th>will find any text containing ...</th></tr>
	<tr class="rw"><td class="pre">+str or str</td>  <td>any occurrence of str</td></tr>
	<tr class="rw"><td class="pre">-str</td>         <td>anything but str</td></tr>
	<tr class="rw"><td class="pre"> str1 str2</td>   <td>all of these strings</td></tr>
	<tr class="rw"><td class="pre"> str1|str2</td>   <td>any of these strings (no blanks!)</td></tr>
	<tr class="rw"><td class="pre">-str1|str2</td>   <td>none of these strings (no blanks!)</td></tr>
	<tr class="rw"><td class="pre">^str or Str</td>  <td>any string beginning with str</td></tr>
	<tr class="rw"><td class="pre"> str^</td>        <td>any string ending with str</td></tr>
	<tr class="rw"><td class="pre">^str^ or Str^</td><td>the exact word</td></tr>
	<tr class="rw"><td class="pre">"str1 str2"</td>  <td>the exact character sequence</td></tr>
</table>

[howto.de]
<h5>Suchbegriffe</h5>
<table>
	<tr class="rh"><th>Muster</th>                   <th>findet Textstellen ...</th></tr>
	<tr class="rw"><td class="pre">+str bzw. str</td><td>die str beinhalten</td></tr>
	<tr class="rw"><td class="pre">-str</td>         <td>die str nicht beinhalten</td></tr>
	<tr class="rw"><td class="pre"> str1 str2</td>   <td>mit allen angegebenen Zeichenketten</td></tr>
	<tr class="rw"><td class="pre"> str1|str2</td>   <td>mit zumindest einer der Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td class="pre">-str1|str2</td>   <td>ohne die angegebenen Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td class="pre">^str bzw. Str</td><td>in denen Wörter mit str beginnen</td></tr>
	<tr class="rw"><td class="pre"> str^</td>        <td>in denen Wörter mit str enden</td></tr>
	<tr class="rw"><td class="pre">^str^ bzw. Str^</td><td>in denen das angegebene Wort vorkommt</td></tr>
	<tr class="rw"><td class="pre">"str1 str2"</td>  <td>in denen die angegebene Wortfolge vorkommt</td></tr>
</table>
