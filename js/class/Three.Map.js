THREE.Map = function (app) {

	THREE.Object3D.call(this);

	this.wireframe = false;

	this.group = [];

	var region = {};

	var listImg = {};

	var degradation = app.loader.map.degradation;
	var frequence = app.loader.map.frequence;
	var fonction = app.loader.map.fonction;
	var skybox = app.loader.map.skybox;


	//size
	var infoSize = app.loader.map.size;
	var sizeBloc = infoSize.elements;
	var maxX = infoSize.xMax * sizeBloc;
	var maxY = infoSize.yMax * sizeBloc;
	var maxZ = infoSize.zMax * sizeBloc;


	var univers = new THREE.Object3D();

	var geometry = new THREE.Geometry();

	var geometryWater = new THREE.Geometry();
	var ambient = new THREE.AmbientLight(app.loader.map.ambiance);

	var light1 = new THREE.PointLight(0xffaa00, 1, 600);

	if (app.loader.map.sun > 0) {
		var light2 = new THREE.DirectionalLight(0xffffff);
		light2.position.set(1, 0.75, 0.5).normalize();
	} else
		var light2 = new THREE.PointLight(0xffaa00, 1, 600);


	var obstacles = {};
	var modules = {};
	var water = {};
	var lights = {};
	var subObstacles = {};


	/*
	 * GET light ambience
	 */
	this.getAmbience = function () {
		return ambient;
	};


	/*
	 * GET light point 1
	 */
	this.getLight1 = function () {
		return light1;
	};


	/*
	 * GET light point 2
	 */
	this.getLight2 = function () {
		return light2;
	};


	/*
	 * GET data for obstacles map current
	 */
	this.getObstacles = function () {
		return obstacles;
	};


	/*
	 * GET data for module map current
	 */
	this.getModules = function () {
		return modules;
	};


	/*
	 * GET data for univers map current
	 */
	this.getUnivers = function () {
		return univers;
	};


	/*
	 * GET water
	 */
	this.getWater = function () {
		return water;
	};


	/*
	 * GET water
	 */
	this.getSubObstacles = function () {
		return subObstacles;
	};


	/*
	 * GET data for obstacles map current
	 */
	this.getArticles = function () {
		return app.loader.map.articles[random(0, (app.loader.map.articles.length - 1))];
	};


	/*
	 * GET data for bots map current
	 */
	this.getBots = function () {
		return app.loader.bots.list ? app.loader.bots.list : false;
	};


	/*
	 * GET la couleur de fond de la map
	 */
	this.getBackgroundColor = function () {
		return app.loader.map.colorBackground ? app.loader.map.colorBackground : 0x8fa2ff;
	};


	/*
	 * GET obstacles
	 */
	this.hasObstacle = function (x, y, z) {
		if (obstacles[x] != undefined && obstacles[x][y] != undefined && obstacles[x][y][z] != undefined && obstacles[x][y][z] === true)
			return true;

		return false;
	};


	/*
	 * GET obstacles small
	 */
	this.hasObstacleSmall = function (x, y, z) {
		if (subObstacles[x] != undefined && subObstacles[x][y] != undefined && subObstacles[x][y][z] != undefined && subObstacles[x][y][z] === true)
			return true;

		return false;
	};


	/*
	 * GET water
	 */
	this.hasWater = function (x, y, z) {
		if (water[x] != undefined && water[x][y] != undefined && water[x][y][z] != undefined && water[x][y][z] === true)
			return true;

		return false;
	};


	/*
	 * GET light ambience
	 */
	this.getOtherElements = function () {
		return eval(fonction);
	};


	/*
	 * Tool load image / gestion en cache
	 */
	var materials = [new THREE.MeshBasicMaterial({ visible: false, wireframe: this.wireframe, transparent: true })];
	var index = 0;
	this.loadTexture = function (path, visible) {
		if (listImg[path.src + '_' + visible] !== undefined)
			return listImg[path.src + '_' + visible];

		var material = new THREE.MeshLambertMaterial({
			map: new THREE.Texture(path, new THREE.UVMapping(), THREE.ClampToEdgeWrapping, THREE.ClampToEdgeWrapping, THREE.NearestFilter, THREE.LinearMipMapLinearFilter),
			ambient: app.loader.map.ambiance,
			wireframe: this.wireframe,
			transparent: true,
			side: 2
		});
		material.map.needsUpdate = true;

		materials.push(material);
		index++;

		return listImg[path.src + '_' + visible] = index;
	};


	/*
	 * UPDATE map
	 */
	this.update = function (app) {
		var minDistance1 = {
			distance: null,
			value: null,
			name: null
		};

		for (var keyLight in lights) {
			var distance = app.hero.getCamera().position.distanceTo(lights[keyLight]);
			if (distance > 1500 || (minDistance1.distance && minDistance1.distance < distance))
				continue;

			minDistance1.distance = distance;
			minDistance1.name = keyLight;
			minDistance1.value = lights[keyLight];
		}

		var minDistance2 = {
			distance: null,
			value: null,
			name: null
		};

		for (var keyLight in lights) {
			var distance = app.hero.getCamera().position.distanceTo(lights[keyLight]);

			if (distance > 1500 || distance == minDistance1.distance || (minDistance2.distance && minDistance2.distance < distance))
				continue;

			minDistance2.distance = distance;
			minDistance2.name = keyLight;
			minDistance2.value = lights[keyLight];
		}

		light1.intensity = random(70, 100) / 100;
		if (minDistance1.value) {
			light1.position.set(minDistance1.value.x, minDistance1.value.y + sizeBloc + random(0, 10), minDistance1.value.z);
			light1.visible = true;
		}
		else
			light1.visible = false;

		if (app.loader.map.sun == 0) {
			light2.intensity = random(70, 100) / 100;
			if (minDistance2.value) {
				light2.position.set(minDistance2.value.x, minDistance2.value.y + sizeBloc + random(0, 10), minDistance2.value.z);
				light2.visible = true;
			}
			else
				light2.visible = false;
		}
	};


	/*
	 * Create element
	 */
	var cubeMesh = new THREE.CubeGeometry(sizeBloc, sizeBloc, sizeBloc);
	var cubeMeshSmall = new THREE.CubeGeometry(sizeBloc / 5, sizeBloc / 5, sizeBloc / 5);
	this.addCube = function (row) {
		var filter = row.materials[0].src.replace(url_script + 'images/background/', '');

		var mesh = new THREE.Mesh((row.subX || row.subY || row.subZ) ? cubeMeshSmall : cubeMesh);

		var zone, facesWater;
		if (filter == 'water.png') {
			zone = this.getZone({x: row.x, y: row.y, z: row.z});

			facesWater = {
				0: water[zone.x + 1] != undefined && water[zone.x + 1][zone.y] !== undefined && water[zone.x + 1][zone.y][zone.z] !== undefined && water[zone.x + 1][zone.y][zone.z] ? true : false,
				1: water[zone.x - 1] != undefined && water[zone.x - 1][zone.y] !== undefined && water[zone.x - 1][zone.y][zone.z] !== undefined && water[zone.x - 1][zone.y][zone.z] ? true : false,
				2: water[zone.x] !== undefined && water[zone.x][zone.y + 1] !== undefined && water[zone.x][zone.y + 1][zone.z] !== undefined && water[zone.x][zone.y + 1][zone.z] ? true : false,
				3: water[zone.x] !== undefined && water[zone.x][zone.y - 1] !== undefined && water[zone.x][zone.y - 1][zone.z] !== undefined && water[zone.x][zone.y - 1][zone.z] ? true : false,
				4: water[zone.x] !== undefined && water[zone.x][zone.y] !== undefined && water[zone.x][zone.y][zone.z + 1] !== undefined && water[zone.x][zone.y][zone.z + 1] ? true : false,
				5: water[zone.x] !== undefined && water[zone.x][zone.y] !== undefined && water[zone.x][zone.y][zone.z - 1] !== undefined && water[zone.x][zone.y][zone.z - 1] ? true : false
			};
		}

		for (var keyImg in row.materials)
			if (filter == 'water.png' && (row.x || row.y || row.z) && facesWater[keyImg] !== undefined && facesWater[keyImg])
				mesh.geometry.faces[keyImg].materialIndex = 0;
			else
				mesh.geometry.faces[keyImg].materialIndex = this.loadTexture(row.materials[keyImg]);

		return mesh;
	};


	/*
	 * GET if over module
	 */
	this.getOverModule = function (position) {
		if (region.modules[position.x + '-' + position.y + '-' + position.z] != undefined)
			return region.modules[position.x + '-' + position.y + '-' + position.z];

		return false;
	};


	/*
	 * GET if over module
	 */
	this.deleteOverModule = function (position) {
		var x = Math.floor(position.x / sizeBloc);
		var y = Math.floor(position.y / sizeBloc);
		var z = Math.floor(position.z / sizeBloc);

		if (region.modules[x + '-' + y + '-' + z] != undefined)
			delete region.modules[x + '-' + y + '-' + z];
	};


	this.getZone = function (position) {
		return {
			x: Math.floor(position.x / sizeBloc),
			y: Math.floor(position.y / sizeBloc),
			yTop: Math.floor((position.y + sizeBloc / 2) / sizeBloc),
			yBottom: Math.floor(position.y / sizeBloc),
			z: Math.floor(position.z / sizeBloc)
		};
	};


	this.getZoneSmall = function (position) {
		return {
			x: Math.floor(position.x / 10),
			y: Math.floor(position.y / 10),
			yTop: Math.floor((position.y + 10 / 2) / 10),
			yBottom: Math.floor(position.y / 10),
			z: Math.floor(position.z / 10)
		};
	};


	/*
	 * CONSTRUCTOR
	 */

//skybox
	if (skybox > 0) {
		var path = url_script + 'images/skybox/' + skybox + '/';
		var format = '.jpg';
		var urls = [
			path + 'px' + format, path + 'nx' + format,
			path + 'py' + format, path + 'ny' + format,
			path + 'pz' + format, path + 'nz' + format
		];

		var materialArray = [];
		for (var i = 0; i < 6; i++)
			materialArray.push(new THREE.MeshBasicMaterial({
				map: THREE.ImageUtils.loadTexture(urls[i]),
				side: THREE.BackSide
			}));
		var skyMaterial = new THREE.MeshFaceMaterial(materialArray);

		var mesh = new THREE.Mesh(new THREE.CubeGeometry(maxX * 5, maxY * 5, maxZ * 5), skyMaterial);
		mesh.position.set(maxX / 2, maxY / 2, maxZ / 2);

		univers.add(mesh);
	}

//ground
	var material = new THREE.Texture(app.loader.map.materials, new THREE.UVMapping(), THREE.ClampToEdgeWrapping, THREE.ClampToEdgeWrapping, THREE.NearestFilter, THREE.LinearMipMapLinearFilter);
	material.wrapS = material.wrapT = THREE.RepeatWrapping;
	material.repeat.set(infoSize.xMax, infoSize.zMax);
	material.needsUpdate = true;

	var mesh = new THREE.Mesh(new THREE.CubeGeometry(maxX, 1, maxZ, infoSize.xMax, infoSize.yMax, infoSize.zMax), new THREE.MeshLambertMaterial({
		map: material,
		wireframe: this.wireframe,
		ambient: app.loader.map.ambiance,
		side: 2
	}));
	mesh.position.set((maxX / 2), 0, (maxZ / 2));

	univers.add(mesh);

//blocs
	for (var x = 0; x <= infoSize.xMax; x++) {
		obstacles[x] = {};
		water[x] = {};
		for (var y = 0; y <= infoSize.yMax; y++) {
			obstacles[x][y] = {};
			water[x][y] = {};
			for (var z = 0; z <= infoSize.zMax; z++) {
				obstacles[x][y][z] = false;
				water[x][y][z] = false;
			}
		}
	}

//blocs small
	for (var x = 0; x <= infoSize.xMax * 5; x++) {
		subObstacles[x] = {};
		for (var y = 0; y <= infoSize.yMax * 5; y++) {
			subObstacles[x][y] = {};
			for (var z = 0; z <= infoSize.zMax * 5; z++) {
				subObstacles[x][y][z] = false;
			}
		}
	}


	for (var keyEle in app.loader.map.elements) {
		var row = app.loader.map.elements[keyEle];

		if (row.subX || row.subY || row.subZ) {
			var zoneSmall = this.getZoneSmall({x: row.subX, y: row.subY, z: row.subZ});
			subObstacles[zoneSmall.x][zoneSmall.y][zoneSmall.z] = true;
		} else {
			var zone = this.getZone({x: row.x, y: row.y, z: row.z});

			if (row.materials[0].src.replace(url_script + 'images/background/', '') == 'water.png')
				water[zone.x][zone.y][zone.z] = true;
			else
				obstacles[zone.x][zone.y][zone.z] = true;
		}
	}


	for (var keyModule in app.loader.map.modules) {
		var row = app.loader.map.modules[keyModule];
		if (row.data.module == 'light')
			lights[row.x + '-' + row.y + '-' + row.z] = new THREE.Vector3(row.x, row.y, row.z);
		else
			modules[Math.floor(row.x / sizeBloc) + '-' + Math.floor(row.y / sizeBloc) + '-' + Math.floor(row.z / sizeBloc)] = row;
	}


	for (var keyEle2 in app.loader.map.elements) {
		var row = app.loader.map.elements[keyEle2];
		var filter = row.materials[0].src.replace(url_script + 'images/background/', '');

		if (filter == 'spacer.png')
			continue;

		var cube = this.addCube(row);
		if (row.subX || row.subY || row.subZ)
			cube.position.set(row.subX + 5, row.subY, row.subZ + 5);
		else
			cube.position.set(row.x, row.y, row.z);

		if (filter == 'water.png')
			THREE.GeometryUtils.merge(geometryWater, cube);
		else
			THREE.GeometryUtils.merge(geometry, cube);
	}

// deformation des vertices
	for (var i = 0, l = geometry.vertices.length; i < l; i++) {
		if (random(0, 100) > frequence)
			continue;
		geometry.vertices[ i ].x += Math.random() * degradation;
		geometry.vertices[ i ].y += Math.random() * (degradation * 2);
		geometry.vertices[ i ].z += Math.random() * degradation;
	}

	var material = new THREE.MeshFaceMaterial(materials);
	var element = new THREE.Mesh(geometry, material);
	var elementWater = new THREE.Mesh(geometryWater, material);

	univers.add(element);
	univers.add(elementWater);

	univers.name = 'map';

	region = {
		univers: univers,
		obstacles: obstacles,
		subObstacles: subObstacles,
		modules: modules,
		lights: lights,
		water: water
	};
}
;

THREE.Map.prototype = Object.create(THREE.Object3D.prototype);