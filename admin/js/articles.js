$(function(){
	
		$('#cutIntro').click(function(){
				InsertHTML('article');
		});
	
});

function InsertHTML(editor) 
{	
		var oEditor = FCKeditorAPI.GetInstance(editor);
	
		if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
				oEditor.InsertHtml( '<hr id="system-readmore" />' ) ;
}