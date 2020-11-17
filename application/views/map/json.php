<?php defined( "SYSPATH" ) OR die( "No direct access allowed." ); ?>
{
	"my" : {
		"id" : <?php echo $my->id; ?>,
		"username" : "<?php echo $my->username; ?>",
        "x" : <?php echo $my->x; ?>,
        "y" : <?php echo $my->y + 1; ?>,
        "z" : <?php echo $my->z; ?>,
        "positionX" : "<?php echo $my->positionX; ?>",
        "positionY" : "<?php echo $my->positionY; ?>",
        "positionZ" : "<?php echo $my->positionZ; ?>",
		"logins" : <?php echo $my->logins; ?>,
		"gravity" : <?php echo number_format($my->gravity, 10); ?>,
		"speed" : <?php echo $my->speed; ?>,
		"currentdirection_x" : <?php echo number_format($my->currentdirection_x, 10); ?>,
		"img" : "<?php echo $my->avatar; ?>",
		"hp" : <?php echo $my->hp; ?>,
		"hpMax" : <?php echo $my->hp_max; ?>,
		"niveau" : <?php echo $my->niveau; ?>,
        "argent" : <?php echo $my->argent; ?>,
        "ammo" : <?php echo $my->ammo; ?>,
		"xp" : <?php echo $my->xp; ?>,
		"xpMax" : <?php echo $my->niveau_suivant(); ?>,
		"region" : <?php echo $my->region_id; ?>,
        "hand_left" : <?php echo $my->item_id_handLeft ? $my->item_id_handLeft : 0; ?>,
        "hand_right" : <?php echo $my->item_id_handRight ? $my->item_id_handRight : 0; ?>
	},
    "map" : {
                "id" : "<?php echo $region->map->region->id; ?>",
                "materials" : "<?php echo str_replace('images/background/', '', $region->map->region->background); ?>",
                "colorBackground" : "<?php echo $region->map->region->background_color; ?>",
                "ambiance" : "<?php echo $region->map->region->ambiance; ?>",
                "skybox" : "<?php echo $region->map->region->skybox; ?>",
                "sun" : "<?php echo $region->map->region->sun; ?>",
                "music" :  "<?php echo $region->map->region->music; ?>",
                "degradation" :  "<?php echo $region->map->region->degradation; ?>",
                "frequence" :  "<?php echo $region->map->region->frequence; ?>",
                "fonction" :  <?php echo json_encode($region->map->region->fonction); ?>,
                "size" : {
                        "elements" : 50,
                        "xMin" : 0,"zMin" : 0,"yMin" : 0,
                        "xMax" : <?php echo $region->map->region->x; ?>,"zMax" : <?php echo $region->map->region->z; ?>,"yMax" : <?php echo $region->map->region->y; ?>
                },
                "articles" :  [ <?php echo $region->map->articles; ?> ],
                "elements" :  [ <?php echo str_replace('images/background/', '', $region->map->elements); ?> ],
                "modules" :  [ <?php echo $region->map->modules; ?> ]
    },
    "bots" : {
            "list" : [
            <?php if( $region->bots ) : ?>
                    <?php foreach( $region->bots as $key => $region->bot ) : ?>
                 {
                    "id" : <?php echo $region->bot->id; ?>,
                    "name" : "<?php echo $region->bot->name; ?>",
                    "x" : <?php echo $region->bot->x; ?>,
                    "y" : <?php echo $region->bot->y; ?>,
                    "z" : <?php echo $region->bot->z; ?>,
                    "type" : <?php echo $region->bot->type; ?>,
                    "fixe" : <?php echo $region->bot->fixe; ?>,
                    "leak" : <?php echo $region->bot->leak; ?>,
                    "img" : "<?php echo $region->bot->image; ?>",
                    "hp" : <?php echo $region->bot->hp; ?>,
                    "hpMax" : <?php echo $region->bot->hp_max; ?>
                } <?php if( $key < count($region->bots) - 1) echo ","; ?>
                    <?php endforeach ?>
            <?php endif ?>
        ]
    },
    "items" : {
    <?php foreach( $items as $keyItem => $item ) : ?>
        "item_<?php echo $item->id; ?>" : <?php echo json_encode($item); ?><?php if( $keyItem < count($items) - 1) echo ","; ?>
    <?php endforeach ?>
    },
    "sounds" :  <?php echo $sounds; ?>
}
