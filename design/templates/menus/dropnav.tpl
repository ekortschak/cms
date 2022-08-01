[include]
dropbox.tpl

[vars]
boxhead = Kapitel

# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="navi" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="localmenu">
				<!VAR:items!>
			</div>
		</td>
<!SEC:nav!>
	</tr>
</table>
</div>

[main.box]
<div class="dropdown"><!VAR:current!>&nbsp; ▾
<!SEC:content!>
</div>

[main.one]
<!VAR:current!>

# ***********************************************************
[nav]
# ***********************************************************
<td class="nopad" width=5></td>
<td class="nopad" width=10 align="right"><!SEC:nav.left!></td>
<td class="nopad" width=5></td>
<td class="nopad" width=10 align="right"><!SEC:nav.right!></td>

[nav.null]
<div class="localmenu">
	<span style="padding: 0px 11px 0px 12px;">&emsp;</span>
</div>

[nav.left]
<a class="localicon" href="?<!VAR:parm!>=<!VAR:prev!>">
	<div style="padding: 0 10px;">&ltrif;</div>
</a>

[nav.right]
<a class="localicon" href="?<!VAR:parm!>=<!VAR:next!>">
	<div style="padding: 0 10px;">&rtrif;</div>
</a>

# ***********************************************************
[toc]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="localmenu">
				<!VAR:items!>
			</div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=26 align="center">
			<div class="localmenu">
				<a style="color: white; vertical-align: top; font-family: monospace;" href="?vmode=topics">?</a>
			</div>
		</td>
	</tr>
</table>
</div>

[topic.box]
<div class="dropdown">
	<span style="padding: 5px 0px 0px 7px;"><!VAR:current!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[topic.one]
<span style="padding: 5px 0px 0px 7px;"><!VAR:current!></span>

# ***********************************************************
[fixed]
# ***********************************************************
<!SEC:main!>

[fixed.box]
<div class="dropdown">
	<span style="padding: 5px 0px 0px 7px;"><!VAR:boxhead!>&nbsp; ▾</span>
<!SEC:content!>
</div>

[fixed.one]
<span style="padding: 5px 0px 0px 7px;"><!VAR:boxhead!></span>
