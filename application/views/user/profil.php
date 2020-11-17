<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ); ?>

<div class="panel">
		<div class="content_stat_user">
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.id'); ?> : </div>
						<div class="info_stat_user"><?php echo $user->id; ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.mail'); ?> : </div>
						<div class="info_stat_user"><?php echo $user->email; ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.pseudo'); ?> : </div>
						<div class="info_stat_user"><?php echo $user->username; ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.nb_connect'); ?> : </div>
						<div class="info_stat_user"><?php echo $user->logins; ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.last_connect'); ?> : </div>
						<div class="info_stat_user"><?php echo date::FormatDate( date::unix2mysql( $user->last_login ) ); ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.last_action'); ?> : </div>
						<div class="info_stat_user"><?php echo date::FormatDate( date::unix2mysql( $user->last_action ) ); ?></div>
						<div class="spacer"></div>
				</div>
				<div class="row_stat_user">
						<div class="title_stat_user"><?php echo Kohana::lang('user.ip'); ?> : </div>
						<div class="info_stat_user"><?php echo $user->ip; ?></div>
						<div class="spacer"></div>
				</div>
		</div>
		<div class="spacer"></div>
</div>

<div class="center"><input type="button" value="<?php echo Kohana::lang( 'template.modif' ); ?>" onclick="app.overlay.load('user/show/update' )" class="button" /><input type="button" value="<?php echo Kohana::lang( 'template.close' ); ?>" onclick="app.overlay.close()" class="button" /></div>