[include]
LOC_TPL/editor/edit.tpl


# ***********************************************************
[main]
# ***********************************************************
<form id="inlineEdit" method="post" action="?">
<!SEC:oid!>

	<textarea id="content" name="content"><!VAR:content!></textarea>
	<script src="CK5_URL/ckeditor.js"></script>

<style>
.ck-editor__editable_inline {
    max-height: 500px;
}
</style>

<script>
	ClassicEditor
		.create( document.querySelector( '\#content' ), {
//			toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
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
