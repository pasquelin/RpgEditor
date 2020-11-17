<?php defined( 'SYSPATH' ) OR die( 'No direct access allowed.' ) ?>
<section id="noCursor">
    <div id="instructions">
        <span style="font-size:45px">Cliquez pour pivoter la caméra</span>
        <br/><span style="font-size:16px"><b>ESC</b> = Activer / désactiver le mouvement de la caméra</span>
        <br/><span style="font-size:16px"><b>P</b> = Capture écran</span>
        <br/><span style="font-size:16px"><b>G</b> = Afficher / masquer la grille</span>
    </div>
</section>
<div id="selectAction">
		<div><label><input type="radio" checked name="action" value="no"/>Simple visite</label></div>
		<div><label><input type="radio" name="action" value="add"/>Ajouter un cube</label></div>
		<div><label><input type="radio" name="action" value="del"/>Supprimer un cube</label></div>
		<p>Appuyez sur la touche <strong>"MAJ"</strong><br/>pour vérouiller la caméra.</p>
    <p>Touches disponible :<br/>flèches, A, Z, R, Q, S, D, F, W.</p>
    <p><a href="/">Revenir au jeu</a></p>
</div>
<div id="controlCube">
		<img id="bloc_1" class="cubeBackground" src="<?php echo url::base(); ?>images/background/grass.png" />
		<img id="bloc_2" class="cubeBackground" src="<?php echo url::base(); ?>images/background/grass_dirt.png" />
		<img id="bloc_3" class="cubeBackground" src="<?php echo url::base(); ?>images/background/grass_dirt.png" />
		<img id="bloc_4" class="cubeBackground" src="<?php echo url::base(); ?>images/background/grass_dirt.png" />
		<img id="bloc_5" class="cubeBackground" src="<?php echo url::base(); ?>images/background/grass_dirt.png" />
		<img id="bloc_6" class="cubeBackground" src="<?php echo url::base(); ?>images/background/dirt.png" />
		<div id="allCube">Appliquer à tous <br/><img id="bloc_all" class="cubeBackground" src="<?php echo url::base(); ?>images/background/dirt.png" /></div>
</div>
<div id="containerMapping"></div>
<script>
		var urlReplace = '<?php echo str_replace('admin/','', url::base()); ?>';

		var dataRegion = <?php echo $region; ?>;
		dataRegion.x = parseInt(dataRegion.x);
		dataRegion.y = parseInt(dataRegion.y);
		dataRegion.z = parseInt(dataRegion.z);

		var dataElements = [<?php echo $elements; ?>];
</script>

