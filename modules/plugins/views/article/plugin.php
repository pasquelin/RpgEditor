<?php	defined(	'SYSPATH'	)	OR	die(	'No direct access allowed.'	);	?>

<?php	if(	$data->image	)	:	?>
		<div class="avatarAction" id="avatarAction" style="background-image:url('<?php	echo	url::base();	?>images/modules/<?php	echo	$data->image;	?>');"></div>
<?php	endif	?>
<div class="contenerActionStat">
		<h1><?php	echo	$article->title;	?></h1>
		<?php	echo	article::edit_user($article->article, $username);	?> 
</div>
<div class="spacer"></div>
