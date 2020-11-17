<?php
class Fck_Core
{
	public function editeur ( $name, $value = '', $height = '500px', $width = '100%'  )
	{
		require_once 'js/fckeditor/fckeditor.php';
		$oFCKeditor = new FCKeditor( $name );
		
		$oFCKeditor->BasePath = url::base().'js/fckeditor/';
		$oFCKeditor->Value = $value;
		$oFCKeditor->Config['EnterMode'] = 'br';
		$oFCKeditor->Config['AutoDetectLanguage'] = false;
		$oFCKeditor->Config['DefaultLanguage'] = 'fr';
		$oFCKeditor->Config["UserFilesAbsolutePath"] = url::base().'images/';
		$oFCKeditor->Config["UserFilesPath"] = url::base().'images/';
		$oFCKeditor->Config["SkinPath"] = $oFCKeditor->BasePath . 'editor/skins/default/';
		$oFCKeditor->SmileyPath = $oFCKeditor->BasePath . 'editor/images/smiley/msn/';
		$oFCKeditor->Height = $height;
		$oFCKeditor->Width = $width;
		$oFCKeditor->FormatOutput = true;
		$oFCKeditor->FormatSource = true;
		$oFCKeditor->Create();
	}
}
?>