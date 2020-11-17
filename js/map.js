var stats;
var control = false;
var simulate_key;
var buttonEnter = false;


/*
 * element div ID
 */
var contentLoading = document.getElementById('content_loading');
var contentBody = document.getElementById('content_body');
var contentAction = document.getElementById('content_action');
var valueGraphHp = document.getElementById('valueMoyenneGraph_hp');
var contentGraphHp = document.getElementById('ContenuGraphique_hp');
var valueGraphOxygen = document.getElementById('valueMoyenneGraph_oxygen');
var contentGraphOxygen = document.getElementById('ContenuGraphique_oxygen');
var cible = document.getElementById('cible');
var water = document.getElementById('water');
var logout = document.getElementById('logout');
var user_info = document.getElementById('user_info');
var user_oxygen = document.getElementById('user_oxygen');
var userScore = document.getElementById('user_argent');
var userAmmo = document.getElementById('user_ammo');
var noCursor = document.getElementById('noCursor');
var notifications = document.getElementById('notifications');
var webGL = document.getElementById('debugWebGL');


/*
 * my app
 */
app = {};

app.scene = new THREE.Scene;
app.camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 20000);
app.loader = new THREE.PreLoader;
app.JSONLoader = new THREE.JSONLoader();
app.clock = new THREE.Clock;
app.sound = new THREE.Sound;
app.overlay = new THREE.Overlay;


app.renderer = {};
app.hero = {};
app.map = {};
app.bots = {};
app.modules = {};
app.messages = [];
app.alert = false;
app.group = [];

/*
 * Initialize datas and scene
 */
var load = function () {
	// load elements
	if (!app.loader.getCompleted())
		return setTimeout(load, 200);

	// show elements HTML for hero HP / SCORE ...
	user_info.style.display = userScore.style.display = userAmmo.style.display = cible.style.display = logout.style.display = notifications.style.display = 'block';

	info(app.loader.nbrBot + ' habitant(s)');
	info(app.loader.nbrElements + ' cube(s)');
	info(app.loader.nbrSounds + ' son(s)');

	//stat for le debug
	if (debug) {
		stats = new Stats();
		stats.domElement.style.position = 'absolute';
		stats.domElement.style.bottom = '0';
		stats.domElement.style.left = '0';
		document.body.appendChild(stats.domElement);
	}

	// initialize the scene with objects
	initialize();
};


/*
 * Initialisation de la map
 */
var initialize = function () {
	// creat map
	app.map = new THREE.Map(app);

	// creat hero
	app.hero = new THREE.Hero(app);

	// add camera in scene
	app.scene.add(app.hero.getCamera());
	// add physic hero (camera) in scene
	app.scene.add(app.hero.getPerson());
	// add torch hero
	var torch = app.hero.getTorch();
	app.scene.add(torch);

	// add physic map in scene
	app.scene.add(app.map.getUnivers());
	// add light in scene
	app.scene.add(app.map.getAmbience());
	// add point light in scene
	app.scene.add(app.map.getLight1());
	// add point light in scene
	app.scene.add(app.map.getLight2());

	app.group = app.map.getUnivers().children;

	// add element on backend
	app.map.getOtherElements();

	// generate bots and add in scene
	var bots = app.map.getBots();
	if (bots)
		for (var keyBot in bots) {
			var bot = new THREE.Bot(app, bots[keyBot]);
			app.bots[bot.id] = bot;
			app.scene.add(bot.getPerson());
			app.group.push(bot.getRay());
		}

	// generate bots and add in scene
	var modules = app.map.getModules();
	if (modules)
		for (var keyCaseModule in modules) {
			if (getIsHistoryModule('memoryItemModule', modules[keyCaseModule], true) || app.loader.items['item_' + modules[keyCaseModule].data.id_item] == undefined)
				continue;
			var module = new THREE.Item(app, app.loader.items['item_' + modules[keyCaseModule].data.id_item].image);
			module.position.copy(modules[keyCaseModule]);
			app.modules[modules[keyCaseModule].x + '-' + modules[keyCaseModule].y + '-' + modules[keyCaseModule].z] = module;
			app.scene.add(module);
		}

	//generate render
	app.renderer = new THREE.WebGLRenderer({
		antialias: true,
		preserveDrawingBuffer: true
	});
	app.renderer.setSize(window.innerWidth, window.innerHeight);
	app.renderer.setClearColor(app.map.getBackgroundColor());

	// load music
	if (app.loader.map.music)
		app.sound.ambience(app.loader.map.music);


	// load render in html
	contentBody.appendChild(app.renderer.domElement);
	contentLoading.innerHTML = '';

	// loop
	animate();

	window.addEventListener('resize', onWindowResize, false);
};


/*
 * Rendu du canvas
 */
var render = function () {
	// update map
	app.map.update(app);

	if (!control) {
		noCursor.style.display = 'block';
		return app.renderer.render(app.scene, app.camera);
	}

	// update bots in scene
	for (var keyBot in app.bots)
		if (app.bots[keyBot].update(app) == 'remove') {
			app.bots[keyBot].getPerson().remove();
			app.scene.remove(app.bots[keyBot].getPerson());
			delete app.bots[keyBot];
		}

	// update module in scene
	for (var keyModule in app.modules)
		app.modules[keyModule].update(app);

	// update hero
	app.hero.update(app);

	// update sound for the volume distance with hero and environment
	app.sound.update(app);

	// update the environment hero
	updateHeroVisual();


	// lecture de message a afficher
	if (app.messages) {
		for (var keyMsg in app.messages) {
			if ($('.notifications').last().html() != app.messages[keyMsg])
				lookMessage(app.messages[keyMsg]);
			app.messages.splice(keyMsg, 1);
		}
	}


	// Vue en rouge en cas d'accident'
	if (app.alert) {
		var alertUser = $('#alertUser');
		app.sound.effect('sorrow.mp3', 0.4);
		alertUser.stop(true, true).show().fadeOut(app.alert);
		app.alert = false;
	}

	// update stat environment
	if (debug) {
		var info = app.renderer.info;
		webGL.innerHTML = '<b>Memory Geometrie</b> : ' + info.memory.geometries + ' - <b>Memory programs</b> : ' + info.memory.programs + ' - <b>Memory textures</b> : ' + info.memory.textures + ' - <b>Render calls</b> : ' + info.render.calls + ' - <b>Render vertices</b> : ' + info.render.vertices + ' - <b>Render faces</b> : ' + info.render.faces + ' - <b>Render points</b> : ' + info.render.points;
	}

	app.renderer.clear();
	app.renderer.render(app.scene, app.camera);
};


/*
 * Loop for animate
 */
var animate = function () {
	requestAnimationFrame(animate);

	// the scene is not defined
	if (app.scene === undefined)
		return;

	// update the render
	render();

	// if the debug is TRUE => update
	if (debug)
		stats.update();
};


/*
 * Resize window
 */
var onWindowResize = function () {
	app.camera.aspect = window.innerWidth / window.innerHeight;
	app.camera.updateProjectionMatrix();
	app.renderer.setSize(window.innerWidth, window.innerHeight);
};

/*
 * Update notification management
 */
var lookMessage = function (txt) {
	var id = Math.round(app.clock.oldTime) + '_' + random(0, 100);
	$('#notifications')
		.append('<div id="' + id + '" class="notifications">' + txt + '</div>')
		.find('#' + id)
		.fadeIn(400)
		.delay(80 * txt.length)
		.fadeOut(3000, function () {
			killSpeackBot();
		});
};


/*
 * look notifications bots for random messages
 */
var killSpeackBot = function () {
	var notif = $('.notifications');
	if (notif.length) {
		notif.stop(true, true);
		if ($('.reponse').length) {
			var id = app.clock.oldTime + '_' + random(0, 100);
			var txt = $('.reponse').html();
			$('#notifications').empty().append('<div id="' + id + '" class="notifications reponseNotification">' + txt + '</div>');
			$('#' + id).fadeIn(1000).delay(80 * txt.length).fadeOut(4000, function () {
				$(this).remove();
			});
		}
		else
			notif.remove();
	}
};


/*
 * Update user interface
 */
var loadMove = false;
var action = false;
var updateHeroVisual = function () {
	if (loadMove)
		return;

	// fenetre action module
	var module = app.map.getOverModule(app.hero.getCollisionModule());

	if (module) {
		if (!action) {
			if (module.data.module == 'move') {
				$.get('actions/' + module.data.module + '?' + app.hero.getData(), function (data) {
					if (data == 'no')
						return;

					$('#content_action').html(data);
					app.messages.push(module.data.title ? module.data.title : 'Changement de lieu');
				});
			}
			else if (module.data.module == 'html') {
				$('#content_action').html(module.data.html);

				if (module.data.title)
					app.messages.push(module.data.title);
			}
			else if (module.data.module == 'sound') {
				if (getIsHistoryModule('memorySoundModule', module))
					return;

				app.sound.effect(module.data.sound);
			}
			else if (module.data.module == 'article') {
				$('#content_action').html(module.article);

				if (module.data.title)
					app.messages.push(module.data.title);
			}
			else if (module.data.module == 'checkpoint') {
				app.loader.request('user/update', 'GET', app.hero.getData());
				if (module.data.title)
					app.messages.push(module.data.title);

			}
			else if (module.data.module == 'gameover') {
				app.hero.gameover();
			}
			else if (module.data.module == 'quete') {
				$.get('actions/' + module.data.module + '?' + app.hero.getData(), function (data) {
					if (data == 'no')
						return;
					$('#content_action').html(data);
				});
			}
			else if (module.data.module == 'item') {
				if (getIsHistoryModule('memoryItemModule', module))
					return;

				app.sound.effect('life.ogg', 0.4);

				var itemOver = app.loader.items['item_' + module.data.id_item];

				if (itemOver.hp != 0)
					app.hero.hp += parseInt(itemOver.hp);

				if (itemOver.ammo != 0)
					app.hero.ammo += parseInt(itemOver.ammo);

				removeReferences(app.modules[module.x + '-' + module.y + '-' + module.z]);
				delete app.modules[module.x + '-' + module.y + '-' + module.z];

				if (module.data.title)
					app.messages.push(module.data.title);
			}

			action = true;
		}
	}
	else {
		contentAction.innerHTML = '';
		action = false;
	}
};


/*
 Fonction qui permet de savoir si tu es passer sur un event
 */
var getIsHistoryModule = function (name, module, read) {

	var memoryModule = localStorage.getItem(name);
	if (memoryModule)
		memoryModule = JSON.parse(memoryModule);
	else
		memoryModule = {};

	if (memoryModule[module.x + '-' + module.y + '-' + module.z] !== undefined)
		return true;

	if (read)
		return false;
	memoryModule[module.x + '-' + module.y + '-' + module.z] = true;
	localStorage.setItem(name, JSON.stringify(memoryModule));
	return false;
}

/*
 * Simular click cursor with pressKey ENTER
 */
var simulEnter = function () {
	var button = $(":button");
	if (button.length) {
		button.each(function () {
			var data = $(this).data();
			if (data) {
				if (data.url !== undefined) {
					$('#content_action').empty().load(data.url + '?' + app.hero.getData(), function (data) {
						if (!data)
							return;

						$('#content_action').html(data).fadeIn();
					});
				}
			}
			$(this).click();
		});
	}
};

var removeReferences = function (removeme) {
	try {
		removeme.traverse(function (ob) {
			if (ob.geometry != undefined) {
				ob.geometry.dispose();
			}
		});
	} catch (e) {
		console.log('Error memory');
	}
	app.scene.remove(removeme);

}


/*
 * cursor management
 */

var havePointerLock = 'pointerLockElement' in document || 'mozPointerLockElement' in document || 'webkitPointerLockElement' in document;

if (havePointerLock) {

	var element = document.body;

	var pointerlockchange = function () {
		if (document.pointerLockElement === element || document.mozPointerLockElement === element || document.webkitPointerLockElement === element) {
			noCursor.style.display = 'none';
			lookMessage('Souris désactivé');
			control = true;
			app.overlay.close();
		} else {
			noCursor.style.display = 'block';
			control = false;
			lookMessage('Souris activé');
		}
	};

	var activeCursor = function () {
		// Ask the browser to lock the pointer
		element.requestPointerLock = element.requestPointerLock || element.mozRequestPointerLock || element.webkitRequestPointerLock;

		if (/Firefox/i.test(navigator.userAgent)) {

			var fullscreenchange = function () {

				if (document.fullscreenElement === element || document.mozFullscreenElement === element || document.mozFullScreenElement === element) {

					document.removeEventListener('fullscreenchange', fullscreenchange);
					document.removeEventListener('mozfullscreenchange', fullscreenchange);

					element.requestPointerLock();
				}
			};

			document.addEventListener('fullscreenchange', fullscreenchange, false);
			document.addEventListener('mozfullscreenchange', fullscreenchange, false);

			element.requestFullscreen = element.requestFullscreen || element.mozRequestFullscreen || element.mozRequestFullScreen || element.webkitRequestFullscreen;
			element.requestFullscreen();

		} else
			element.requestPointerLock();
	};

	// Hook pointer lock state change events
	document.addEventListener('pointerlockchange', pointerlockchange, false);
	document.addEventListener('mozpointerlockchange', pointerlockchange, false);
	document.addEventListener('webkitpointerlockchange', pointerlockchange, false);

	noCursor.addEventListener('click', activeCursor, false);

} else
	noCursor.innerHTML = 'Your browser doesn\'t seem to support Pointer Lock API';


$(function () {
	if (!Detector.webgl)
		Detector.addGetWebGLMessage();

	/*
	 * Mapping start
	 */
	load();

	/*
	 * Event unload window or press key
	 */
	$(window)
		.unload(function () {
			app.loader.request('user/update', 'GET', app.hero.getData());
		})
		.keyup(function (event) {
			if (!control)
				return;

			if (event.keyCode === 13)
				buttonEnter = simulate_key = false;
		})
		.keydown(function (event) {
			if (!control)
				return;

			if (event.keyCode === 80)
				window.open(app.renderer.domElement.toDataURL('image/png'), 'Capture');
			else if (event.keyCode === 13) {
				killSpeackBot();
				simulEnter();
				buttonEnter = simulate_key = true;
			}
		});


	/*
	 * Quete / mission start
	 */
	$('#content_action')
		.on('click', '#accepter', function (event) {
			var id = $('#id_quete').val();
			$('#content_action').empty().load('actions/quete/add/' + id + '?' + app.hero.getData(), function (data) {
				if (data)
					$(this).html(data).fadeIn();
			});
			event.preventDefault();
		})
		.on('click', '#annul', function (event) {
			var id = $('#id_quete').val();
			$('#content_action').empty().load('actions/quete/annul/' + id + '?' + app.hero.getData(), function (data) {
				if (data)
					$(this).html(data).fadeIn();
			});
			event.preventDefault();
		});
	/*
	 * MENU TOP LEFT
	 */
	$('#logout').on('click', '#myProfil', function () {
		app.overlay.load('user');
	});

	$('#overlay').on('click', '#updateProfil', function () {
		app.overlay.load('user/show/update');
	});
});