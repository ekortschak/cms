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


# ***********************************************************
[main]
# ***********************************************************
<!SEC:nav.toc!>

<div style="margin: -15px 0px 12px;">
	<h3><!DIC:search!></h3>
</div>

<form method="post" action="?">
<!VAR:range!>

	<input type="text" name="search" value="<!VAR:search!>" placeholder="<!DIC:sinfo!>" style="width: calc(100% - 12px);" />

	<div align="right">
		<input type="submit" name="search,act" value="OK" />
	</div>
</form>

<h4><!DIC:result!></h4>
<!VAR:result!>


# ***********************************************************
[result]
# ***********************************************************
<!VAR:items!>

[nav.toc]
<div style="float: right;">
	<a href="?vmode=view"><button class="icon"><img src="ICONS/buttons/view.png" align="right" /></button></a>
</div>

[topic]
<div style="white-space: nowrap;"><h5><!VAR:topic!></h5></div>

[item]
<div style="white-space: nowrap;"><a href="?search.topic=<!VAR:dir!>&search.dir=<!VAR:key!>"><!VAR:title!></a></div>


# ***********************************************************
[preview]
# ***********************************************************
<h3><!DIC:prevw!></h3>

[prv.goto]
<div style="float: right;">
	<a href="?vmode=view&tpc=<!VAR:topic!>&pge=<!VAR:page!>">
		<button class="icon"><img src="ICONS/buttons/view.png" alt="View"></button>
	</a>
</div>
<div style="float: right; margin-right: 5px;">
	<a href="?search.reset=1">
		<button class="icon">BOOL_NO</button>
	</a>
</div>

[prv.topic]
<div class="submenu">
<img src="ICONS/buttons/view.png" style="vertical-align: bottom;" alt="view"> <a href="?vmode=view&tpc=<!VAR:topic!>&pge=<!VAR:page!>"><!VAR:titel!></a>
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
<!SEC:info!>
<!SEC:info.text!>

[info]
<h4>How to use</h4>
<ul>
	<li>Enter a search term into the text field.</li>
	<li>Click OK.</li>
	<li>Select an item from the results list.</li>
</ul>

[info.de]
<h4>Anleitung</h4>
<ul>
	<li>Gib einen Suchbegriff in das Textfeld ein.</li>
	<li>Drücke OK.</li>
	<li>Wähle einen Eintrag in der Ergebnisliste.</li>
</ul>

# ***********************************************************
[info.text]
# ***********************************************************
<h4>Search patterns</h4>
<table>
	<tr class="rh"><th>Pattern</th>                  <th></th><th>will find any text containing ...</th></tr>
	<tr class="rw"><td class="pre">+str or str</td>  <td></td><td>any occurrence of str</td></tr>
	<tr class="rw"><td class="pre">-str</td>         <td></td><td>anything but str</td></tr>
	<tr class="rw"><td class="pre"> str1 str2</td>   <td></td><td>all of these strings</td></tr>
	<tr class="rw"><td class="pre"> str1|str2</td>   <td></td><td>any of these strings (no blanks!)</td></tr>
	<tr class="rw"><td class="pre">-str1|str2</td>   <td></td><td>none of these strings (no blanks!)</td></tr>
	<tr class="rw"><td class="pre">^str or Str</td>  <td></td><td>any string beginning with str</td></tr>
	<tr class="rw"><td class="pre"> str^</td>        <td></td><td>any string ending with str</td></tr>
	<tr class="rw"><td class="pre">^str^ or Str^</td><td></td><td>the exact word</td></tr>
	<tr class="rw"><td class="pre">"str1 str2"</td>  <td></td><td>the exact character sequence</td></tr>
</table>

[info.text.de]
<h5>Suchbegriffe</h5>
<table>
	<tr class="rh"><th>Muster</th>                   <th></th><th>findet Textstellen ...</th></tr>
	<tr class="rw"><td class="pre">+str bzw. str</td><td></td><td>die str beinhalten</td></tr>
	<tr class="rw"><td class="pre">-str</td>         <td></td><td>die str nicht beinhalten</td></tr>
	<tr class="rw"><td class="pre"> str1 str2</td>   <td></td><td>mit allen angegebenen Zeichenketten</td></tr>
	<tr class="rw"><td class="pre"> str1|str2</td>   <td></td><td>mit zumindest einer der Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td class="pre">-str1|str2</td>   <td></td><td>ohne die angegebenen Zeichenketten (keine Leerzeichen!)</td></tr>
	<tr class="rw"><td class="pre">^str bzw. Str</td><td></td><td>in denen Wörter mit str beginnen</td></tr>
	<tr class="rw"><td class="pre"> str^</td>        <td></td><td>in denen Wörter mit str enden</td></tr>
	<tr class="rw"><td class="pre">^str^ bzw. Str^</td><td></td><td>in denen das angegebene Wort vorkommt</td></tr>
	<tr class="rw"><td class="pre">"str1 str2"</td>  <td></td><td>in denen die angegebene Wortfolge vorkommt</td></tr>
</table>
