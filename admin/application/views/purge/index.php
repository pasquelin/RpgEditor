<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>

<form id="form1" name="form1" method="post" action="<?php echo url::base( TRUE ).'purge/send'; ?>">
		<article class="module width_full relative">
				<header>
						<h3 class="tabs_involved"><?php echo Kohana::lang( 'purge.title' ); ?></h3>
				</header>
				<div class="module_content">
						<p><?php echo Kohana::lang( 'purge.desc' ); ?></p>

						<table width="100%" border="0" cellpadding="5" cellspacing="1" class="table-list">
								<tr class="odd">
										<td width="20">
												<input type="checkbox" name="article" id="article"  value="1" />
										</td>
										<td><label for="article"><?php echo Kohana::lang( 'purge.article' ); ?></label></td>
								</tr>
								<tr class="even">
										<td>
												<input type="checkbox" name="bot" id="bot" value="1" />
										</td>
										<td><label for="bot"><?php echo Kohana::lang( 'purge.bot' ); ?></label></td>
								</tr>
								<tr class="odd">
										<td>
												<input type="checkbox" name="map" id="map"  value="1" />
										</td>
										<td><label for="map"><?php echo Kohana::lang( 'purge.map' ); ?></label></td>
								</tr>
								<tr class="even">
										<td>
												<input type="checkbox" name="object" id="object"  value="1" />
										</td>
										<td><label for="object"><?php echo Kohana::lang( 'purge.object' ); ?></label></td>
								</tr>
								<tr class="odd">
										<td>
												<input type="checkbox" name="quete" id="quete"  value="1" />
										</td>
										<td><label for="quete"><?php echo Kohana::lang( 'purge.quete' ); ?></label></td>
								</tr>
								<tr class="even">
										<td>
												<input type="checkbox" name="sort" id="sort"  value="1" />
										</td>
										<td><label for="sort"><?php echo Kohana::lang( 'purge.sort' ); ?></label></td>
								</tr>
								<tr class="odd">
										<td>
												<input type="checkbox" name="caract_user" id="caract_user"  value="1" />
										</td>
										<td><label for="caract_user"><?php echo Kohana::lang( 'purge.user_stat' ); ?></label></td>
								</tr>
								<tr class="even">
										<td>
												<input type="checkbox" name="user" id="user"  value="1" />
										</td>
										<td><label for="user"><?php echo Kohana::lang( 'purge.user' ); ?></label></td>
								</tr>
						</table>
				</div>
				<footer>
						<div class="submit_link">
								<input type="submit" value="<?php echo Kohana::lang( 'purge.submit' ); ?>" class="button button-normal alt_btn" id="buttonSubmitEmailing" style="margin-right:5px" />
						</div>
				</footer>
				<div class="clear"></div>
		</article>
</form>