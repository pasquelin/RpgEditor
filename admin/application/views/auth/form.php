<div id="main">
		<div class="module contenerLogin">
				<header>
						<h3 class="tabs_involved"><?php echo Kohana::lang( 'logger.title_connect' ); ?></h3>
				</header>
				<form method="post" action="<?php echo url::base( TRUE ); ?>login" name="form" id="form" >
						<div class="module_content">
								<p><?php echo Kohana::lang( 'logger.desc_connect' ); ?></p>
								<fieldset>
										<?php echo html::image('images/template/lock.png', array( 'class' => 'imgLock')); ?>
										<label class="form-label" for="username"><?php echo Kohana::lang( 'logger.label_identify' ); ?> : </label>
										<input name="username" id="username" type="text" style="width: 70%; margin-bottom: 20px;" />										
										<label class="form-label" for="password"><?php echo Kohana::lang( 'logger.label_password' ); ?> : </label>
										<input name="password" id="password" type="password" style="width: 70%;  margin-bottom: 10px;" />
								</fieldset>
						</div>
						<footer>
								<div class="submit_link">
										<input type="reset" value="Reset">
										<input type="submit" value="<?php echo Kohana::lang( 'logger.label_button' ); ?>"  class="alt_btn">
								</div>
						</footer>
				</form>
		</div>
</div>