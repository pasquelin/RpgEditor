if (!Detector.webgl) Detector.addGetWebGLMessage();

var container, stats;
var app = {};

app.JSONLoader = new THREE.JSONLoader();

var projector, plane, cube;
var mouse2D, ray,
	theta = 45, controls, cubes, cubesHide;

var hoverTool = false;
var typeAction = 'no';

var listImg = {}, obstacles = {}, modules = [], listCube = {};

var rollOverMesh, voxelPosition = new THREE.Vector3(), tmpVec = new THREE.Vector3();
var i, intersector;
var idClickMaterial;
var dataTextureCube = {};
var MeshFaceMaterial = new THREE.MeshFaceMaterial();
var materialSelectObject = new THREE.MeshBasicMaterial({ ambient: 0x444444, color: 0x990000, opacity: 1, transparent: true, wireframe: false });
var materialShadowMap = new THREE.MeshNormalMaterial();
var grille;
var sizeCube = 50;

var clickMouse = false;
var objectSelect = null;
var memoryObjectSelect = null;

var clock = new THREE.Clock();

var gui;
var Mapgui;

$(function () {
	init();
	animate();

	$('.cubeBackground').click(function () {
		$.facebox({
			ajax: url_script + 'mapping/listing_material'
		});
		idClickMaterial = this.id;
	});

	$('#noCursor').click(function () {
		controls.freeze = false;
		$(this).remove();

		$('#sidebar').animate({left: -210});
		$('#controlCube').animate({right: -260});
		$('#controlCube').animate({right: -260});
		$('#selectAction').animate({top: -60});
		$('#containerMapping > div').animate({right: -260});
	});

	$(document).keyup(function (e) {
		if ($('#facebox').is(':visible'))
			return;

		if (e.keyCode == 27) {
			if ($('#noCursor').length)
				$('#noCursor').remove();

			controls.freeze = $('#sidebar').css('left') == '0px' ? false : true;

			$('#sidebar').animate({left: !controls.freeze ? -210 : 0});
			$('#controlCube').animate({right: !controls.freeze ? -260 : 10});
			$('#my-gui-container').animate({right: !controls.freeze ? -257 : 0});
			$('#containerMapping > div').animate({right: !controls.freeze ? -260 : 20});
			$('#selectAction').animate({top: !controls.freeze ? -60 : 22});
		} else if (e.keyCode == 80) {
			savePNG();
		} else if (e.keyCode == 71) {
			setGrid();
		}
	});

	$("#selectAction, #controlCube").hover(
		function () {
			hoverTool = true;
		},
		function () {
			hoverTool = false;
		}
	);

	$('.material').live('click', function () {
		$('#' + idClickMaterial).attr('src', dir_script + '../images/background/' + this.id);

		if (idClickMaterial == 'bloc_all')
			for (var i = 1; i <= 6; i++)
				$('#bloc_' + i).attr('src', dir_script + '../images/background/' + this.id);

		idClickMaterial = null;

		typeAction = $('#actionCurrent').val();

		var position = rollOverMesh.position;

		dataTextureCube = getTexutreVoxel();

		if (typeAction == 'mod')
			return;

		app.scene.remove(rollOverMesh);

		rollOverMesh = addCube(dataTextureCube, (sizeCube == 10 ? true : null));
		rollOverMesh.position = position;

		if (typeAction == 'del' || typeAction == 'no')
			rollOverMesh.visible = false;

		app.scene.add(rollOverMesh);
	});
});


/*
 *WEBGL
 */

function init() {

	var modelSelect = 'arbre';
	container = document.getElementById('containerMapping');

	app.camera = new THREE.CombinedCamera(window.innerWidth, window.innerHeight, 60, 1, 8000);

	controls = new THREE.FirstPersonControls(app.camera, container);

	controls.object.position.y = 50;
	controls.movementSpeed = 400;
	controls.lookSpeed = 0.1;
	controls.lookVertical = true;
	controls.lookVertical = true;

	app.scene = new THREE.Scene();
	//app.scene.fog = new THREE.FogExp2(dataRegion.background_color, 0.0001);


	// roll-over helpers
	rollOverMesh = addCube(getTexutreVoxel());
	rollOverMesh.name = 'vortex';
	rollOverMesh.position.y += 50 / 2;
	rollOverMesh.position.x += 50 / 2;
	rollOverMesh.position.z += 50 / 2;
	rollOverMesh.visible = false;
	app.scene.add(rollOverMesh);

	// picking

	projector = new THREE.Projector();

	// grid
	var material = THREE.ImageUtils.loadTexture(dir_script + '../' + dataRegion.background);
	material.wrapS = material.wrapT = THREE.RepeatWrapping;
	material.repeat.set(dataRegion.x, dataRegion.z);
	material.magFilter = THREE.NearestFilter;
	material.minFilter = THREE.LinearMipMapLinearFilter;


	var plane = new THREE.Mesh(new THREE.PlaneGeometry(dataRegion.x * 50, dataRegion.z * 50, dataRegion.x, dataRegion.z), new THREE.MeshBasicMaterial({
		map: material
	}));
	plane.rotation.x = -Math.PI / 2;
	plane.position.x += dataRegion.x * 25;
	plane.position.z += dataRegion.z * 25;
	plane.name = 'planeBackground';

	app.scene.add(plane);

	grille = new THREE.Mesh(new THREE.PlaneGeometry(dataRegion.x * 50, dataRegion.z * 50, dataRegion.x, dataRegion.z), new THREE.MeshBasicMaterial({
		color: 0xffffff,
		wireframe: true
	}));
	grille.rotation.x = -Math.PI / 2;
	grille.position.x += dataRegion.x * 25;
	grille.position.z += dataRegion.z * 25;
	grille.name = 'planeGrille';
	app.scene.add(grille);

	for (keyEl in dataElements) {
		if (dataElements[keyEl].subX > 0 || dataElements[keyEl].subZ > 0 || dataElements[keyEl].subZ > 0)
			addObstacle(dataElements[keyEl].subX, dataElements[keyEl].subY, dataElements[keyEl].subZ, dataElements[keyEl]);
		else
			addObstacle(dataElements[keyEl].x, dataElements[keyEl].y, dataElements[keyEl].z, dataElements[keyEl]);
	}

	getCubes();

	mouse2D = new THREE.Vector3(0, 10000, 0.5);

	// Lights
	var ambientLight = new THREE.AmbientLight(0xffffff);
	app.scene.add(ambientLight);

	var directionalLight = new THREE.DirectionalLight(0xffffff);
	directionalLight.position.set(1, 0.75, 0.5).normalize();
	app.scene.add(directionalLight);

	app.renderer = new THREE.WebGLRenderer({
		clearColor: dataRegion.background_color,
		antialias: true,
		clearAlpha: true,
		preserveDrawingBuffer: true
	});

	app.renderer.setSize(window.innerWidth, window.innerHeight);

	container.appendChild(app.renderer.domElement);

	stats = new Stats();
	stats.domElement.style.position = 'absolute';
	stats.domElement.style.bottom = '0';
	stats.domElement.style.left = '0';
	container.appendChild(stats.domElement);

	container.addEventListener('mousemove', onDocumentMouseMove, false);
	container.addEventListener('mouseup', onDocumentMouseUp, false);
	container.addEventListener('mousedown', onDocumentMouseDown, false);

	window.addEventListener('resize', onWindowResize, false);

	Mapgui = new dat.GUI({ autoPlace: false });
	Mapgui.params = {
		vitesse: controls.movementSpeed,
		vertical: controls.lookSpeed,
		sizeCube: 'grand',
		action: 'Simple Visite',
		object: selectObjectList[0] !== undefined ? selectObjectList[0] : null,
		visibleMap: true,
		visibleModels: true,
		visibleHide: true,
		visibleGrid: true,
		material: 'texture',
		lookVertical: true,
		rotationY: 180 * app.camera.rotation.y / Math.PI,
		rotationX: 180 * app.camera.rotation.x / Math.PI,
		rotationZ: 180 * app.camera.rotation.z / Math.PI,
		positionX: app.camera.position.x,
		positionY: app.camera.position.y,
		positionZ: app.camera.position.z,
		addObject: function () {

			Mapgui.action.setValue('Manipuler un objet');

			var vector = new THREE.Vector3(0, 0, 1);
			projector.unprojectVector(vector, app.camera);

			var ray = new THREE.Ray(app.camera.position, vector.subSelf(app.camera.position).normalize());

			app.JSONLoader.load(dir_script + '../obj/' + modelSelect + '/json.js', function (geometry) {
				var mesh = new THREE.Mesh(geometry, new THREE.MeshFaceMaterial());
				mesh.position = ray.origin.clone().addSelf(ray.direction);
				mesh.name = modelSelect;
				mesh.alias = modelSelect + ' - inconnue';
				mesh.type = 'object';
				app.scene.add(mesh);
				sauvegardeObject();
			});
		}
	};

	var f2 = Mapgui.addFolder('Carte');
	f2.open();
	Mapgui.action = f2.add(Mapgui.params, 'action', ['Simple Visite', 'Ajouter un cube', 'Ajouter un module', 'Editer un module', 'Supprimer', 'Manipuler un objet']).onChange(function (value) {
		if (value == 'Ajouter un cube') {
			typeAction = 'add';
		} else if (value == 'Ajouter un module') {
			typeAction = 'mod';
		} else if (value == 'Editer un module') {
			typeAction = 'edit';
		} else if (value == 'Supprimer') {
			typeAction = 'del';
		} else if (value == 'Manipuler un objet') {
			typeAction = 'obj';
		}
		else
			typeAction = 'no';

		app.scene.remove(rollOverMesh);

		if (typeAction == 'add')
			$('#controlCube').show();
		else
			$('#controlCube').hide();

		$('#actionCurrent').val(typeAction);
		if (typeAction == 'no')
			return;

		else if (typeAction == 'add') {
			rollOverMesh = addCube(dataTextureCube, (sizeCube == 10 ? true : null));
			rollOverMesh.visible = true;
		} else {
			rollOverMesh = new THREE.Mesh(new THREE.CubeGeometry(sizeCube, sizeCube, sizeCube), new THREE.MeshBasicMaterial({
				color: typeAction == 'del' ? 0xff0000 : 0xffff00,
				opacity: 0.3,
				transparent: true
			}));
		}

		app.scene.add(rollOverMesh);
	});
	Mapgui.sizeCube = f2.add(Mapgui.params, 'sizeCube', ['grand', 'petit']).onChange(function (value) {
		sizeCube = value == 'grand' ? 50 : 10;

		app.scene.remove(rollOverMesh);

		if (typeAction == 'add')
			$('#controlCube').show();
		else
			$('#controlCube').hide();

		$('#actionCurrent').val(typeAction);
		if (typeAction == 'no')
			return;

		else if (typeAction == 'add') {
			rollOverMesh = addCube(dataTextureCube, (sizeCube == 10 ? true : null));
			rollOverMesh.visible = true;
		} else {
			rollOverMesh = new THREE.Mesh(new THREE.CubeGeometry(sizeCube, sizeCube, sizeCube), new THREE.MeshBasicMaterial({
				color: typeAction == 'del' ? 0xff0000 : 0xffff00,
				opacity: 0.3,
				transparent: true
			}));
		}

		app.scene.add(rollOverMesh);
	});
	Mapgui.visibleGrid = f2.add(Mapgui.params, 'visibleGrid').onChange(function (value) {
		grille.visible = value;
	});
	Mapgui.visibleMap = f2.add(Mapgui.params, 'visibleMap').onChange(function (value) {
		cubes.visible = value;
	});
	Mapgui.visibleHide = f2.add(Mapgui.params, 'visibleHide').onChange(function (value) {
		cubesHide.visible = value;
	});
	Mapgui.visibleModels = f2.add(Mapgui.params, 'visibleModels').onChange(function (value) {
		for (var keyChild in app.scene.children)
			if (app.scene.children[keyChild].type == 'object')
				app.scene.children[keyChild].visible = value;
	});
	Mapgui.material = f2.add(Mapgui.params, 'material', ['texture', 'wireframe', 'relief']).onChange(function (value) {
		if (value == 'texture') {
			cubes.material = MeshFaceMaterial;
		} else if (value == 'wireframe') {
			cubes.material = materialShadowMap;
			cubes.material.wireframe = true;
		} else if (value == 'relief') {
			cubes.material = materialShadowMap;
			cubes.material.wireframe = false;
		}
	});
	Mapgui.object = f2.add(Mapgui.params, 'object', selectObjectList).onChange(function (value) {
		modelSelect = value;
		Mapgui.action.setValue('Manipuler un objet');
	});
	Mapgui.addObject = f2.add(Mapgui.params, 'addObject');

	var f1 = Mapgui.addFolder('Caméra');
	f1.open();
	Mapgui.positionX = f1.add(Mapgui.params, 'positionX', 0, dataRegion.x * 50).onChange(function (value) {
		app.camera.position.setX(value);
	});
	Mapgui.positionY = f1.add(Mapgui.params, 'positionY', 0, dataRegion.y * 50).onChange(function (value) {
		app.camera.position.setY(value);
	});
	Mapgui.positionZ = f1.add(Mapgui.params, 'positionZ', 0, dataRegion.z * 50).onChange(function (value) {
		app.camera.position.setZ(value);
	});
	Mapgui.rotationY = f1.add(Mapgui.params, 'rotationY', -180, 180).onChange(function (value) {
		app.camera.rotation.setY(value * Math.PI / 180);
	});
	Mapgui.rotationX = f1.add(Mapgui.params, 'rotationX', -180, 180).onChange(function (value) {
		app.camera.rotation.setX(value * Math.PI / 180);
	});
	Mapgui.rotationZ = f1.add(Mapgui.params, 'rotationZ', -180, 180).onChange(function (value) {
		app.camera.rotation.setZ(value * Math.PI / 180);
	});
	Mapgui.movementSpeed = f1.add(Mapgui.params, 'vitesse', { Rapide: 800, Normal: controls.movementSpeed, Lent: 100 }).onChange(function (value) {
		controls.movementSpeed = value;
	});
	Mapgui.lookSpeed = f1.add(Mapgui.params, 'vertical', 0, 0.2).onChange(function (value) {
		controls.lookSpeed = value;
	});
	Mapgui.lookVertical = f1.add(Mapgui.params, 'lookVertical').onChange(function (value) {
		controls.lookVertical = value;
	});

	document.getElementById('map-gui-container').appendChild(Mapgui.domElement);
	Mapgui.open();
}


/*
 * Ajout des cubes sur la map + le sol (clear la map auto avant l'execution)
 */
function getCubes() {
	container.style.display = 'none';

	if (cubes) {
		for (var keyChild in app.scene.children) {
			var row = app.scene.children[keyChild];
			if (row.name !== undefined && (row.name == 'cubeInvisible' || row.name == 'cubeVisible')) {
				row.deallocate();
				app.scene.remove(row);
			}
		}
		app.renderer.deallocateObject(cubes);
		cubes.deallocate();
		app.scene.remove(cubes);
	}

	if (cubesHide) {
		app.renderer.deallocateObject(cubesHide);
		cubesHide.deallocate();
		app.scene.remove(cubesHide);
	}

	var geometry = new THREE.Geometry();
	var geometryHide = new THREE.Geometry();

	for (var x in obstacles) {
		for (var y in obstacles[x]) {
			for (var z in obstacles[x][y]) {
				var row = obstacles[x][y][z];

				var dataSend = {
					background_px: dir_script + '../' + row.materials[0],
					background_nx: dir_script + '../' + row.materials[1],
					background_py: dir_script + '../' + row.materials[2],
					background_ny: dir_script + '../' + row.materials[3],
					background_pz: dir_script + '../' + row.materials[4],
					background_nz: dir_script + '../' + row.materials[5]
				};


				var voxel;

				if (row.subX > 0 || row.subY > 0 || row.subZ > 0) {
					voxel = addCube(dataSend, true);

					voxel.position.x = row.subX + 5;
					voxel.position.y = row.subY;
					voxel.position.z = row.subZ + 5;
				} else {
					voxel = addCube(dataSend);

					voxel.position.x = row.x;
					voxel.position.y = row.y;
					voxel.position.z = row.z;
				}


				var filter = row.materials[0].replace('images/background/', '');

				if (filter == 'spacer.png')
					THREE.GeometryUtils.merge(geometryHide, voxel);
				else
					THREE.GeometryUtils.merge(geometry, voxel);


			}
		}
	}

	cubes = new THREE.Mesh(geometry, MeshFaceMaterial);
	cubes.name = 'cubeVisible';
	app.scene.add(cubes);

	cubesHide = new THREE.Mesh(geometryHide, MeshFaceMaterial);
	cubesHide.name = 'cubeInvisible';
	app.scene.add(cubesHide);

	container.style.display = 'block';
}


/*
 * Cr√©er un cube
 */
function addCube(dataSend, small) {
	var sizeCube = small === true ? 10 : 50
	var path = dataSend.background_px + dataSend.background_nx + dataSend.background_py + dataSend.background_ny + dataSend.background_pz + dataSend.background_nz + sizeCube;
	if (listCube[path] == undefined)
		listCube[path] = {
			scr: path,
			cube: new THREE.CubeGeometry(sizeCube, sizeCube, sizeCube, 0, 0, 0, [
				loadTexture(dataSend.background_px),
				loadTexture(dataSend.background_nx),
				loadTexture(dataSend.background_py),
				loadTexture(dataSend.background_ny),
				loadTexture(dataSend.background_pz),
				loadTexture(dataSend.background_nz)
			])
		};

	var mesh = new THREE.Mesh(listCube[path].cube, MeshFaceMaterial);
	mesh.name = 'cube';
	return mesh;
}


/*
 * Detection collision voxel
 */
function getRealIntersector(intersects) {

	for (i = 0; i < intersects.length; i++)
		if (intersects[ i ].object != rollOverMesh && intersects[ i ].distance < 3000)
			return intersects[ i ];

	return null;
}


/*
 * Calcul de la position du voxel (add / mod)
 */
function setVoxelPosition(intersector, type) {

	if (intersector.distance > 3000)
		return;

	tmpVec.copy(intersector.face.normal);

	voxelPosition.add(intersector.point, intersector.object.matrixRotationWorld.multiplyVector3(tmpVec));

	var position = voxelPosition;

	if (!type) {
		position = intersector.point;
		position.x -= intersector.face.normal.x > 0 ? sizeCube : 0;
		position.y -= intersector.face.normal.y > 0 ? sizeCube : 0;
		position.z -= intersector.face.normal.z > 0 ? sizeCube : 0;
	}

	voxelPosition.x = Math.floor(position.x / sizeCube) * sizeCube + (sizeCube / 2);
	voxelPosition.y = Math.floor(position.y / sizeCube) * sizeCube + (sizeCube / 2);
	voxelPosition.z = Math.floor(position.z / sizeCube) * sizeCube + (sizeCube / 2);
}


/*
 * D√©placement de la sourie
 */
function onDocumentMouseMove(event) {
	event.preventDefault();

	if (typeAction == 'no')
		return;

	if (typeAction == 'obj')
		rollOverMesh.visible = false;

	mouse2D.x = ( event.clientX / window.innerWidth ) * 2 - 1;
	mouse2D.y = -( event.clientY / window.innerHeight ) * 2 + 1;

	ray = projector.pickingRay(mouse2D.clone(), app.camera);

	var intersects = ray.intersectObjects(app.scene.children);
	if (intersects.length > 0) {
		if (intersects[0].object.type == 'object' && typeAction == 'obj') {
			if (clickMouse && !objectSelect) {
				objectSelect = intersects[0].object;
				memoryObjectSelect = intersects[0].object;

			}
			return;
		}
		intersector = getRealIntersector(intersects);
		if (intersector) {
			setVoxelPosition(intersector, (typeAction == 'del' || typeAction == 'edit' ? false : true));
			rollOverMesh.position = voxelPosition;
		}
	}
}

function onDocumentMouseDown(event) {
	event.preventDefault();

	$('#my-gui-container').empty();
	if (memoryObjectSelect)
		memoryObjectSelect.material = MeshFaceMaterial;
	memoryObjectSelect = null;
	clickMouse = true;

	mouse2D.x = ( event.clientX / window.innerWidth ) * 2 - 1;
	mouse2D.y = -( event.clientY / window.innerHeight ) * 2 + 1;

	ray = projector.pickingRay(mouse2D.clone(), app.camera);

	var intersects = ray.intersectObjects(app.scene.children);
	if (intersects.length > 0) {
		if (typeAction == 'obj')
			for (var keyIntersect in intersects) {
				var element = intersects[keyIntersect];
				if (element.distance > 1000)
					continue;

				if (element.object.type == 'object') {
					if (clickMouse && !objectSelect) {

						memoryObjectSelect = element.object;

						/*
						 GUI pour model
						 */
						gui = new dat.GUI({ autoPlace: false });
						gui.params = {
							material: 'texture',
							positionY: memoryObjectSelect.position.y,
							positionX: memoryObjectSelect.position.x,
							positionZ: memoryObjectSelect.position.z,
							rotationY: 180 * memoryObjectSelect.rotation.y / Math.PI,
							rotationX: 180 * memoryObjectSelect.rotation.x / Math.PI,
							rotationZ: 180 * memoryObjectSelect.rotation.z / Math.PI,
							scale: memoryObjectSelect.scale.x,
							scaleY: memoryObjectSelect.scale.y,
							scaleX: memoryObjectSelect.scale.x,
							scaleZ: memoryObjectSelect.scale.z,
							identifiant: memoryObjectSelect.alias != undefined ? memoryObjectSelect.alias : memoryObjectSelect.name + ' - inconnu',
							sauvegarder: sauvegardeObject,
							dupliquer: function () {
								memoryObjectSelect = memoryObjectSelect.clone();
								memoryObjectSelect.position.x += 50;
								memoryObjectSelect.position.y += 50;
								memoryObjectSelect.position.z += 50;
								app.scene.add(memoryObjectSelect);
								sauvegardeObject();
							},
							supprimer: function () {
								app.scene.remove(memoryObjectSelect);
								memoryObjectSelect = null;
								$('#my-gui-container').empty();
								sauvegardeObject();
								Mapgui.open();
							}
						};
						gui.saveObject = gui.add(gui.params, 'identifiant').onChange(function (value) {
							memoryObjectSelect.alias = value;
						});
						gui.material = gui.add(gui.params, 'material', ['texture', 'wireframe', 'transparent']).onChange(function (value) {
							if (value == 'texture') {
								memoryObjectSelect.material = MeshFaceMaterial;
							} else if (value == 'wireframe') {
								memoryObjectSelect.material = materialSelectObject;
								memoryObjectSelect.material.wireframe = true;
							} else if (value == 'transparent') {
								memoryObjectSelect.material = materialSelectObject;
								memoryObjectSelect.material.wireframe = false;
								memoryObjectSelect.material.opacity = 0.2;
							}
						});
						gui.positionX = gui.add(gui.params, 'positionX', 0, dataRegion.x * 50).onChange(function (value) {
							memoryObjectSelect.position.setX(value);
						});
						gui.positionY = gui.add(gui.params, 'positionY', 0, dataRegion.y * 50).onChange(function (value) {
							memoryObjectSelect.position.setY(value);
						});
						gui.positionZ = gui.add(gui.params, 'positionZ', 0, dataRegion.z * 50).onChange(function (value) {
							memoryObjectSelect.position.setZ(value);
						});
						gui.rotationY = gui.add(gui.params, 'rotationY', -180, 180).onChange(function (value) {
							memoryObjectSelect.rotation.setY(value * Math.PI / 180);
						});
						gui.rotationX = gui.add(gui.params, 'rotationX', -180, 180).onChange(function (value) {
							memoryObjectSelect.rotation.setX(value * Math.PI / 180);
						});
						gui.rotationZ = gui.add(gui.params, 'rotationZ', -180, 180).onChange(function (value) {
							memoryObjectSelect.rotation.setZ(value * Math.PI / 180);
						});
						gui.scale = gui.add(gui.params, 'scale', -100, 100).onChange(function (value) {
							memoryObjectSelect.scale.set(value,value,value);
							gui.scaleX.setValue(value);
							gui.scaleY.setValue(value);
							gui.scaleZ.setValue(value);
						});
						gui.scaleX = gui.add(gui.params, 'scaleX', -100, 100).onChange(function (value) {
							memoryObjectSelect.scale.setX(value);
						});
						gui.scaleY = gui.add(gui.params, 'scaleY', -100, 100).onChange(function (value) {
							memoryObjectSelect.scale.setY(value);
						});
						gui.scaleZ = gui.add(gui.params, 'scaleZ', -100, 100).onChange(function (value) {
							memoryObjectSelect.scale.setZ(value);
						});
						gui.saveObject = gui.add(gui.params, 'sauvegarder');
						gui.saveObject = gui.add(gui.params, 'dupliquer');
						gui.saveObject = gui.add(gui.params, 'supprimer');

						document.getElementById('my-gui-container').appendChild(gui.domElement);
						gui.open();
						Mapgui.close();
						return;
					}
				}
			}
	}

	Mapgui.open();
}

function onDocumentMouseUp(event) {
	event.preventDefault();
	clickMouse = false;
	objectSelect = null;

	if (typeAction == 'no' || typeAction == 'obj' || hoverTool || !ray.intersectObjects(app.scene.children).length)
		return;


	var coordonnee = {
		x: sizeCube == 10 ? 0 : voxelPosition.x,
		y: sizeCube == 10 ? 0 : voxelPosition.y,
		z: sizeCube == 10 ? 0 : voxelPosition.z,
		subX: sizeCube != 10 ? 0 : voxelPosition.x - 5,
		subY: sizeCube != 10 ? 0 : voxelPosition.y,
		subZ: sizeCube != 10 ? 0 : voxelPosition.z - 5,
		region_id: dataRegion.id,
		size: sizeCube,
		materials: [
			dataTextureCube.background_px,
			dataTextureCube.background_nx,
			dataTextureCube.background_py,
			dataTextureCube.background_ny,
			dataTextureCube.background_pz,
			dataTextureCube.background_pz
		]
	};
	var setCoordonnee = coordonnee;

	typeAction = $('#actionCurrent').val();

	if (typeAction == 'del') {

		if (sizeCube != 10 && obstacles[voxelPosition.x] != undefined && obstacles[voxelPosition.x][voxelPosition.y] != undefined && obstacles[voxelPosition.x][voxelPosition.y][voxelPosition.z] != undefined) {
			console.log(obstacles[voxelPosition.x][voxelPosition.y][voxelPosition.z]);
			delete obstacles[voxelPosition.x][voxelPosition.y][voxelPosition.z];
		}
		else if (obstacles[voxelPosition.x - 5] != undefined && obstacles[voxelPosition.x - 5][voxelPosition.y] != undefined && obstacles[voxelPosition.x - 5][voxelPosition.y][voxelPosition.z - 5] != undefined)
			delete obstacles[voxelPosition.x - 5][voxelPosition.y][voxelPosition.z - 5];

		getCubes();

		$.post(url_script + 'mapping/remove/', coordonnee);
		return;
	}
	else if (typeAction == 'edit') {
		$.facebox({
			ajax: url_script + 'mapping/form/' + dataRegion.id + '/' + coordonnee.x + '/' + coordonnee.y + '/' + coordonnee.z
		});
		return;
	} else if (typeAction == 'mod') {
		for (key in coordonnee.materials)
			coordonnee.materials[key] = 'images/background/module.png';

		$.facebox({
			ajax: url_script + 'mapping/form/' + dataRegion.id + '/' + coordonnee.x + '/' + coordonnee.y + '/' + coordonnee.z
		});

		if (sizeCube == 10)
			addObstacle(coordonnee.subX, coordonnee.subY, coordonnee.subZ, coordonnee);
		else
			addObstacle(coordonnee.x, coordonnee.y, coordonnee.z, coordonnee);
	} else {
		for (key in coordonnee.materials)
			coordonnee.materials[key] = coordonnee.materials[key].replace(urlReplace, '');

		$.post(url_script + 'mapping/add/', coordonnee);

		if (sizeCube == 10)
			addObstacle(coordonnee.subX, coordonnee.subY, coordonnee.subZ, coordonnee);
		else
			addObstacle(coordonnee.x, coordonnee.y, coordonnee.z, coordonnee);
	}

	var dataSend = {
		background_px: dir_script + '../' + coordonnee.materials[0],
		background_nx: dir_script + '../' + coordonnee.materials[1],
		background_py: dir_script + '../' + coordonnee.materials[2],
		background_ny: dir_script + '../' + coordonnee.materials[3],
		background_pz: dir_script + '../' + coordonnee.materials[4],
		background_nz: dir_script + '../' + coordonnee.materials[5]
	};

	var voxel;

	if (coordonnee.subX > 0 || coordonnee.subY > 0 || coordonnee.subZ > 0) {
		voxel = addCube(dataSend, true);
		voxel.position.x = coordonnee.subX + 5;
		voxel.position.y = coordonnee.subY;
		voxel.position.z = coordonnee.subZ + 5;
	} else {
		voxel = addCube(dataSend);
		voxel.position.x = coordonnee.x;
		voxel.position.y = coordonnee.y;
		voxel.position.z = coordonnee.z;
	}

	app.scene.add(voxel);

}


/*
 * Traitement de l'animation
 */
function animate() {
	requestAnimationFrame(animate);
	if (!$('#facebox').is(':visible'))
		render();
	stats.update();
}


/*
 * Render
 */
function render() {
	var info = app.renderer.info;
	//console.log('Memory Geometrie : '+info.memory.geometries+' - Memory programs : '+info.memory.programs+' - Memory textures : '+info.memory.textures+' - Render calls : '+info.render.calls+' - Render vertices : '+info.render.vertices+' - Render faces : '+info.render.faces+' - Render points : '+info.render.points);
	//console.log(info.memory.geometries);


	if (objectSelect && intersector && intersector.point) {
		voxelPosition.add(intersector.point, intersector.object.matrixRotationWorld.multiplyVector3(tmpVec));
		objectSelect.position.copy(voxelPosition);
	}

	controls.update(clock.getDelta(), dataRegion);
	Mapgui.positionX.setValue(app.camera.position.x);
	Mapgui.positionY.setValue(app.camera.position.y);
	Mapgui.positionZ.setValue(app.camera.position.z);
	Mapgui.rotationX.setValue(180 * app.camera.rotation.x / Math.PI);
	Mapgui.rotationY.setValue(180 * app.camera.rotation.y / Math.PI);
	Mapgui.rotationZ.setValue(180 * app.camera.rotation.z / Math.PI);
	app.renderer.render(app.scene, app.camera);
}


/*
 * Chargement des textures
 */
function getTexutreVoxel() {
	return dataTextureCube = {
		background_px: document.getElementById('bloc_2').src,
		background_nx: document.getElementById('bloc_4').src,
		background_py: document.getElementById('bloc_1').src,
		background_ny: document.getElementById('bloc_6').src,
		background_pz: document.getElementById('bloc_3').src,
		background_nz: document.getElementById('bloc_5').src
	};
}


/*
 * Chargement des textures
 */
function loadTexture(path) {

	if (listImg[path] !== undefined)
		return listImg[path].mesh;

	var texture = THREE.ImageUtils.loadTexture(path);
	texture.wrapS = texture.wrapT = THREE.ClampToEdgeWrapping;
	texture.magFilter = THREE.NearestFilter;
	texture.minFilter = THREE.LinearMipMapLinearFilter;

	listImg[path] = {
		scr: path,
		mesh: new THREE.MeshLambertMaterial({
			map: texture,
			ambient: 0xbbbbbb,
			transparent: true
		})
	};

	return listImg[path].mesh;
}

var sauvegardeObject = function () {
	var list = {};
	for (var keyChild in app.scene.children) {
		if (app.scene.children[keyChild].type == 'object') {
			if (list[app.scene.children[keyChild].name] == undefined)
				list[app.scene.children[keyChild].name] = [];

			list[app.scene.children[keyChild].name].push(app.scene.children[keyChild]);
		}
	}

	if (list) {
		var out = [];
		for (var keyList in list) {
			out.push("app.JSONLoader.load('obj/" + keyList + "/json.js', function (geometry, material) {");
			for (var keyMesh in list[keyList]) {
				var mesh = list[keyList][keyMesh];
				out.push("var mesh = new THREE.Mesh(geometry, new THREE.MeshFaceMaterial(material));");
				out.push("mesh.position.set(" + mesh.position.x + "," + mesh.position.y + "," + mesh.position.z + ");");
				out.push("mesh.scale.set(" + mesh.scale.x + "," + mesh.scale.y + "," + mesh.scale.z + ");");
				out.push("mesh.rotation.set(" + mesh.rotation.x + "," + mesh.rotation.y + "," + mesh.rotation.z + ");");
				out.push("mesh.name = '" + keyList + "';");
				out.push("mesh.alias = '" + mesh.alias + "';");
				out.push("mesh.type = 'object';");
				out.push("app.scene.add(mesh);");
			}
			out.push("});");
		}

		$.post(url_script + 'mapping/fonction/', {fonction: out.join("\n"), id: dataRegion.id});
	}
};

var addObstacle = function (x, y, z, data) {
	if (obstacles[x] == undefined)
		obstacles[x] = {};
	if (obstacles[x][y] == undefined)
		obstacles[x][y] = {};

	obstacles[x][y][z] = data;
}


/*
 * Resize de la fenetre
 */
function onWindowResize() {
	app.camera.setSize(window.innerWidth, window.innerHeight);
	app.camera.updateProjectionMatrix();

	app.renderer.setSize(window.innerWidth, window.innerHeight);
}

function savePNG() {

	window.open(app.renderer.domElement.toDataURL('image/png'), 'Capture');

}

function setGrid() {
	if (grille.visible)
		grille.visible = false;
	else
		grille.visible = true;


	Mapgui.visibleGrid.setValue(grille.visible);

}