[vars]
frameHeight = 250
frameWidth = 400
width = 70

# ***********************************************************
[main]
# ***********************************************************
<table>
    <tr>
        <td align="center" style="padding: 20px 20px 10px 0px;">
		<iframe name="pv" src="<!VAR:viewer!>?img=<!VAR:first!>"
			width="<!VAR:frameWidth!>" height="<!VAR:frameHeight!>"
			frameborder=0 scrolling="no">
		</iframe>
        </td>

        <td>
		<h3><!VAR:title!></h3>

		<div style="display:inline; overflow: auto;">
			<!VAR:thumbs!>
		</div>
	</td>

    </tr>
</table>

# ***********************************************************
[files]
# ***********************************************************
<ul>
<!VAR:folders!>
</ul>

[file]
<li><a href="<!VAR:viewer!>?img=<!VAR:url!>" target="pv"><!VAR:text!></a>

# ***********************************************************
[folder]
# ***********************************************************
<OPTION value=<!DIR:path!>><!DIR:text!></OPTION>


