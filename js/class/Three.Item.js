var memoryItemObj = {};

THREE.Item = function (app, img) {

	THREE.Object3D.call(this);

	this.size = 24;

	this.name = 'item';

	this.speedRotation = 0.02;

	this.visible = true;

	this.wireframe = false;

	var geometry = new THREE.Object3D();


	/*
	 * UPDATE
	 */
	this.update = function (app) {
		var visible = !!(this.position.distanceTo(app.hero.getCamera().position) < 1000);

		if (this.visible != visible) {
			geometry.visible = visible;
			geometry.traverse(function (child) {
				child.visible = visible;
			});
			this.visible = visible;
		}

		if (!this.visible)
			return;

		geometry.rotation.y += this.speedRotation;
	};

	/*
	 * Constructor item
	 */
	if (memoryItemObj[img] == undefined)
		app.JSONLoader.load('obj/' + img + '/json.js', function (vertices, materials) {
			var mesh = new THREE.Mesh(vertices, new THREE.MeshFaceMaterial(materials));
			memoryItemObj[img] = mesh;
			geometry.add(mesh);
		});
	else
		geometry.add(memoryItemObj[img]);

	this.add(geometry);
};

THREE.Item.prototype = Object.create(THREE.Object3D.prototype);