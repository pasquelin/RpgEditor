<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="barTop"></div>
<h1>Enigma Cube</h1>
<div id="logo">
    <img src="<?php echo url::base(); ?>images/template/logo.png" width="964" height="119"/>
</div>
<div id="description">
    <p>Votre navigateur ne vous permet pas d’utiliser ce site.<br/>Si vous souhaitez y accéder, veuillez utiliser l'un des deux navigateurs proposés ci-dessous
        :</p>
    <ul>
        <li><img src="<?php echo url::base(); ?>images/template/chrome.png"/> <a href="http://www.google.fr/intl/fr/chrome/browser/" target="_blank">Chrome</a>
            <span>(recommandé)</span></li>
        <li><img src="<?php echo url::base(); ?>images/template/firefox.png"/> <a href="http://www.mozilla.org/fr/firefox/new/" target="_blank">Firefox</a>
        </li>
    </ul>
</div>
<div id="barBottom"></div>

<audio autoplay="autoplay" id="audio">
    <source src="<?php echo url::base(); ?>audios/home.mp3" type="audio/mpeg">
</audio>

<script>
    var audio = document.getElementById('audio');
    audio.volume = 0.4;
</script>