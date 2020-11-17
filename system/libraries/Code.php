<?php
class Code_Core
{
	public function editeur ( $id = 'code', $code = false, $heigh = 350 )
	{
		$css = url::base().'css/';
		$v = false;
		
		$v .= '<script src="'.url::base().'js/codemirror/codemirror.js" type="text/javascript"></script>'."\n";
		
		$v .= '<div style="border: 1px solid #999; padding: 3px; background-color: #F8F8F8">'."\n";
		$v .= '<textarea id="'.$id.'" name="'.$id.'" style="width:100%; height:'.$heigh.'px;">'.$code.'</textarea>'."\n";
		$v .= '</div>'."\n";
		$v .= '<script type="text/javascript">'."\n";
		$v .= 'var editor = CodeMirror.fromTextArea(\''.$id.'\', {'."\n";
		$v .= 'height: "'.$heigh.'px",'."\n";
		$v .= 'parserfile: ["parsexml.js","parsecss.js","tokenizejavascript.js","parsejavascript.js","tokenizephp.js","parsephp.js","parsephphtmlmixed.js"],'."\n";
		$v .= 'stylesheet: ["'.$css.'xmlcolors.css", "'.$css.'jscolors.css", "'.$css.'csscolors.css", "'.$css.'phpcolors.css"],'."\n";
		$v .= 'path: "'.url::base().'/js/codemirror/",'."\n";
		$v .= 'continuousScanning: 300'."\n";
		$v .= '});'."\n";
		$v .= '</script>'."\n";
		
		return $v;
	}
}
?>