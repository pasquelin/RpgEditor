<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<?php if( isset( $modif ) && $modif ) : ?>
		<div class="panel">
            <div id="content_pwd">
                <div class="title_stat_user"><label for="pseudo"><?php echo Kohana::lang( 'user.pseudo' ); ?> :</label></div>
                <div class="info_stat_user"><input type="text" class="input-text" name="pseudo" id="pseudo" value="<?php echo $user->username; ?>" /></div>
            </div>
            <div class="spacer"></div>
            <div id="content_pwd">
                <div class="title_stat_user"><label for="new_pwd"><?php echo Kohana::lang( 'user.new_password' ); ?> :</label></div>
                <div class="info_stat_user"><input type="password" class="input-text" name="new_pwd" id="new_pwd" /></div>
                <div class="spacer"></div>
                <div class="title_stat_user"><label for="repeat_new_pwd"><?php echo Kohana::lang( 'user.verif_password' ); ?> :</label></div>
                <div class="info_stat_user"><input type="password" class="input-text" name="repeat_new_pwd" id="repeat_new_pwd" /></div>
            </div>
				<div class="spacer"></div>
		</div>
<?php endif ?>
<div class="center"><input type="button" value="<?php echo Kohana::lang( 'form.annul' ); ?>" onclick="app.overlay.load('user' )" class="button" /> <input type="button" value="<?php echo Kohana::lang( 'user.modif_password' ); ?>" onclick="savePassword()" class="button" /></div>