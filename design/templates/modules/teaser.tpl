[register]
core/scripts/teaser.js

[vars]
#timer = 5000
pix = 'img/wappen.gif'
pic = img/wappen.gif

[main]

<script language="javascript">
	FaderFramework.init({
		id: "teaser",
		images: [<!VAR:pix!>]
	});
</script>

<div class="teaser">
	<img id="teaser" src="<!VAR:pic!>" width=<!VAR:width!>>
</div>
