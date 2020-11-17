<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="user_info">
    <div id="user_hp"><?php echo graphisme::BarreGraphique($user->hp, $user->hp_max, 250, Kohana::lang('user.hp'), 'hp'); ?></div>
    <div id="user_oxygen"><?php echo graphisme::BarreGraphique(10, 100, 250, null, 'oxygen'); ?></div>
</div>

<div id="user_argent"><?php echo number_format($user->argent) . ' pt' . ($user->argent > 1 ? 's' : ''); ?></div>

<div id="user_ammo"><?php echo number_format($user->ammo); ?></div>