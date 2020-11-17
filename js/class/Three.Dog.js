THREE.Dog = function (picture, id) {

	THREE.Object3D.call(this);

	this.wireframe = false;

	this.idBot = id;

	this.hp = random(3, 6);

	this.name = 'bears';

	this.bodyGroup = new THREE.Object3D();

	this.attacked = -1;

	this.cycleDie = 0;

	var listImg = {};

	var time = Date.now() / 1000;

	/*
	 * Update person et position
	 */
	this.update = function (type) {

		time = Date.now() / 1000;

		if (this.ray.visible)
			this.ray.visible = false;

		if (this.attacked >= 0 && this.attacked < 15) {
			this.attacked++;
			return;
		}

		switch (type) {
			case 1 :
				this.run();
				break;
			case 2 :
				this.stop();
				break;
			case 3 :
				this.attack();
				break;
			default :
				this.walk();
				break;
		}

	};

	/*
	 * Get he's die
	 */
	this.getDie = function () {

		if (this.hp == 0)
			this.die();
		else if (this.hp <= 0)
			this.cycleDie++;

		return !!(this.hp < 0);
	};


	/*
	 * Initialisation position person
	 */
	this.initialGesture = function () {
		this.rightarm.rotation.set(0, 0, 0);
		this.leftarm.rotation.set(0, 0, 0);
		this.rightleg.rotation.set(0, 0, 0);
		this.leftleg.rotation.set(0, 0, 0);
	};


	/*
	 * Position person STOP
	 */
	this.stop = function () {
		this.initialGesture();

		this.rightleg.rotation.x = this.leftarm.rotation.x = -0.1;
		this.leftleg.rotation.x = this.rightarm.rotation.x = 0.1;
	};


	/*
	 * Position person MEURS
	 */
	this.die = function () {
		this.hp = -1;

		app.sound.play('dog.mp3', this);
		app.sound.play('fall.mp3', this);

		this.initialGesture();

		this.rightleg.rotation.x = this.rightarm.rotation.x = -1.3;
		this.leftleg.rotation.x = this.leftarm.rotation.x = 1.3;

		this.position.y -= 6;
	};


	/*
	 * Position person ATTAQUE
	 */
	this.attack = function () {
		this.attacked = 0;

		this.initialGesture();

		this.rightarm.rotation.z = 1.3;
	};


	/*
	 * Position person MARCHER
	 */
	this.walk = function () {
		var sinSpeed = Math.sin(time * 4);

		this.initialGesture();

		this.head.rotation.y = this.headAccessory.y = Math.sin(time * 1.5) / 5;
		this.head.rotation.z = this.headAccessory.z = Math.sin(time) / 5;

		this.leftleg.rotation.z = this.rightarm.rotation.z = sinSpeed / 3;
		this.rightleg.rotation.z = this.leftarm.rotation.z = -sinSpeed / 3;
	};


	/*
	 * Position person COURIR
	 */
	this.run = function () {
		var z = 6.662 * time;
		var cosZ = Math.cos(z);

		this.initialGesture();

		this.head.rotation.y = this.headAccessory.y = Math.sin(time * 1.5) / 5;
		this.head.rotation.z = this.headAccessory.z = Math.sin(time) / 5;

		this.rightleg.rotation.z = this.leftarm.rotation.z = 1.4 * cosZ;
		this.leftleg.rotation.z = this.rightarm.rotation.z = 1.4 * Math.cos(z + PI);
	};


	/*
	 * Load texture
	 */
	var materials = [];
	var index = -1;
	this.loadTexture = function (x, y, xSize, ySize) {

		var ratio = picture.width / 16;

		x *= ratio;
		y *= ratio;
		xSize *= ratio;
		ySize *= ratio;

		var path = x + '-' + y + '-' + xSize + '-' + ySize;

		if (listImg[path] !== undefined)
			return listImg[path];

		var canvas = window.document.createElement('canvas');
		canvas.width = xSize;
		canvas.height = ySize;

		var context = canvas.getContext('2d');

		context.drawImage(picture, x, y, xSize, ySize, 0, 0, xSize, ySize);

		var material = new THREE.MeshLambertMaterial({
			map: new THREE.Texture(canvas, new THREE.UVMapping(), THREE.ClampToEdgeWrapping, THREE.ClampToEdgeWrapping, THREE.NearestFilter, THREE.LinearMipMapLinearFilter),
			ambient: app.loader.map.ambiance,
			wireframe: this.wireframe,
			transparent: true
		});
		material.map.needsUpdate = true;

		materials.push(material);
		index++;

		return listImg[path] = index;
	};

	this.setRotationY = function( value ) {
		this.rotation.y = PIDivise2 + value;
	};


	/*
	 * Contructor person
	 */

	//Head
	this.materialHeadAccessory = [
		this.loadTexture(10, 2, 2, 2),
		this.loadTexture(10, 0, 2, 2),
		this.loadTexture(10, 0, 2, 2),
		this.loadTexture(12, 0, 2, 2),
		this.loadTexture(8, 2, 2, 2),
		this.loadTexture(12, 2, 2, 2)
	];

	//Head
	this.materialHead = [
		this.loadTexture(2, 2, 2, 2),
		this.loadTexture(2, 0, 2, 2),
		this.loadTexture(2, 0, 2, 2),
		this.loadTexture(4, 0, 2, 2),
		this.loadTexture(0, 2, 2, 2),
		this.loadTexture(4, 2, 2, 2)
	];

	// Left / Right arm
	this.materialArm = [
		this.loadTexture(11, 4, 1, 4),
		this.loadTexture(11, 4, 1, 4),
		this.loadTexture(11, 4, 1, 1),
		this.loadTexture(12, 4, 1, 1),
		this.loadTexture(11, 4, 1, 4),
		this.loadTexture(11, 4, 1, 4)
	];

	// Body
	this.materialBody = [
		this.loadTexture(5, 5, 2, 3),
		this.loadTexture(8, 5, 2, 3),
		this.loadTexture(5, 4, 2, 1),
		this.loadTexture(7, 4, 2, 1),
		this.loadTexture(4, 5, 1, 3),
		this.loadTexture(7, 5, 1, 3)
	];

	// Left / Right leg
	this.materialLeg = [
		this.loadTexture(0, 5, 1, 3),
		this.loadTexture(2, 5, 1, 3),
		this.loadTexture(1, 4, 1, 1),
		this.loadTexture(2, 4, 1, 1),
		this.loadTexture(3, 5, 1, 3),
		this.loadTexture(1, 5, 1, 3)
	];

	var faceMesh = new THREE.MeshFaceMaterial(materials);

	/*
	 * HEAD
	 */
	//Head Accessory
	var headAccessory = new THREE.CubeGeometry(10, 10, 10);
	this.headAccessory = new THREE.Mesh(headAccessory, faceMesh);
	for (keyImg in this.materialHeadAccessory)
		this.headAccessory.geometry.faces[keyImg].materialIndex = this.materialHeadAccessory[keyImg];
	this.headAccessory.position.set(12, 12, 0);

	//Head
	var head = new THREE.CubeGeometry(8, 8, 8);
	this.head = new THREE.Mesh(head, faceMesh);
	for (keyImg in this.materialHead)
		this.head.geometry.faces[keyImg].materialIndex = this.materialHead[keyImg];
	this.head.position.set(12, 12, 0);


	/*
	 * LEG
	 * Left / Right leg
	 */
	var arm = new THREE.CubeGeometry(4, 16, 4);
	for (var i = 0; i < 8; i += 1)
		arm.vertices[i].y -= 6;

	this.leftarm = new THREE.Mesh(arm, faceMesh);
	this.rightarm = new THREE.Mesh(arm, faceMesh);
	for (keyImg in this.materialArm) {
		this.leftarm.geometry.faces[keyImg].materialIndex = this.materialArm[keyImg];
		this.rightarm.geometry.faces[keyImg].materialIndex = this.materialArm[keyImg];
	}

	// left
	this.leftarm.position.set(8, 6, -4);
	this.bodyGroup.add(this.leftarm);

	// right
	this.rightarm.position.set(8, 6, 4);
	this.bodyGroup.add(this.rightarm);


	/*
	 * BODY
	 */
	var body = new THREE.CubeGeometry(22, 8, 8);
	this.body = new THREE.Mesh(body, faceMesh);
	for (keyImg in this.materialBody)
		this.body.geometry.faces[keyImg].materialIndex = this.materialBody[keyImg];
	this.body.position.setY(8);
	this.bodyGroup.add(this.body);


	/*
	 * LEG
	 * Left / Right leg
	 */
	var leg = new THREE.CubeGeometry(4, 16, 4);
	for (i = 0; i < 8; i += 1)
		leg.vertices[i].y -= 6;
	this.leftleg = new THREE.Mesh(leg, faceMesh);
	this.rightleg = new THREE.Mesh(leg, faceMesh);
	for (keyImg in this.materialLeg) {
		this.leftleg.geometry.faces[keyImg].materialIndex = this.materialLeg[keyImg];
		this.rightleg.geometry.faces[keyImg].materialIndex = this.materialLeg[keyImg];
	}

	// left
	this.leftleg.position.set(-8, 6, -4);
	this.bodyGroup.add(this.leftleg);

	// right
	this.rightleg.position.set(-8, 6, 4);
	this.bodyGroup.add(this.rightleg);


	/*
	 * RAY
	 */
	this.ray = new THREE.Mesh(new THREE.CubeGeometry(26, 20, 14));
	this.ray.visible = false;
	this.ray.position.y = 4;
	this.ray.name = 'rayDog';

	this.add(this.bodyGroup);
	this.add(this.head);
	this.add(this.headAccessory);
	this.add(this.ray);

	this.scale.set(0.9, 0.9, 0.9);

	this.remove = function () {
		headAccessory.dispose();
		head.dispose();
		arm.dispose();
		body.dispose();
		leg.dispose();
	};
};

THREE.Dog.prototype = Object.create(THREE.Object3D.prototype);