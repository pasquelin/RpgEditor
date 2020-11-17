THREE.Person = function (type, picture, hand_left, hand_right, id) {

	THREE.Object3D.call(this);

	this.handLeft = new THREE.Object3D();

	this.handRight = new THREE.Object3D();

	this.wireframe = false;

	this.text = false;

	this.idBot = id;

	this.hp = random(4, 8);

	this.name = type;

	this.bodyGroup = new THREE.Object3D();

	var listImg = {};

	var tire = -1;

	this.cycleDie = 0;


	/*
	 * Get he's die
	 */
	this.getDie = function () {

		if (this.hp == 0) {
			this.hp--;
			this.die();
		} else if (this.hp <= 0) {
			this.cycleDie++;
		}

		return this.hp < 0 ? true : false;
	}

	/*
	 * Update person et position
	 */
	this.update = function (type, shootgun) {
		this.ray.visible = false;
		if (this.name == 'bot' && tire >= 0 && tire < 5) {
			tire++;
			return;
		} else
			this.initialGesture();

		this.lightGun.intensity = 0;

		switch (type) {
			case 1 :
				this.run();
				break;
			case 2 :
				this.stop();
				break;
			case 3 :
				this.shootgun();
				break;
			default :
				this.walk();
				break;
		}

		if (shootgun)
			this.shootgun();
	};


	/*
	 * Initialisation position person
	 */
	this.initialGesture = function () {
		this.rightarm.rotation.set(0, 0, 0.5);
		this.leftarm.rotation.set(0, 0, 0.3);
		this.rightleg.rotation.set(0, 0, 0);
		this.leftleg.rotation.set(0, 0, 0);
	};


	/*
	 * Position person STOP
	 */
	this.stop = function () {
		this.rightarm.rotation.x = -0.2;
		this.leftarm.rotation.x = 0.2;

		this.rightleg.rotation.x = -0.1;
		this.leftleg.rotation.x = 0.1;
	};


	/*
	 * Position person STOP
	 */
	this.die = function () {
		app.sound.play('sorrow.mp3', this);
		app.sound.play('fall.mp3', this);
		this.initialGesture();

		this.rightarm.rotation.x = -1.5;
		this.leftarm.rotation.x = 1.5;
		this.rightarm.rotation.z = 0;
		this.leftarm.rotation.z = 0;

		this.rightleg.rotation.x = -0.5;
		this.leftleg.rotation.x = 0.5;
		this.position.y -= 6;
		this.rotation.z = 1.5;
	};


	/*
	 * Position person GUN FIRE
	 */
	this.shootgun = function () {
		tire = 0;
		this.rightarm.rotation.z = 1.3;
		this.rightarm.rotation.x = -0.2;
	};


	/*
	 * Position person MARCHER
	 */
	this.walk = function () {
		var time = Date.now() / 1000;
		var speed = time * 4;

		var cosSpeed = Math.cos(speed);
		var sinSpeed = Math.sin(speed);

		this.head.rotation.y = Math.sin(time * 1.5) / 5;
		this.head.rotation.z = Math.sin(time) / 5;

		this.leftarm.rotation.z = -sinSpeed / 2;
		this.leftarm.rotation.x = (cosSpeed + PIDivise2) / 30;

		this.rightarm.rotation.z = sinSpeed / 2;
		this.rightarm.rotation.x = -(cosSpeed + PIDivise2) / 30;

		this.leftleg.rotation.z = sinSpeed / 3;
		this.rightleg.rotation.z = -sinSpeed / 3;
	};


	/*
	 * Position person RUN
	 */
	this.run = function () {
		var time = Date.now() / 1000;
		var z = 6.662 * time;
		var x = 2.812 * time;
		var cosX = Math.cos(x);
		var cosZ = Math.cos(z);

		this.head.rotation.y = Math.sin(time * 1.5) / 5;
		this.head.rotation.z = Math.sin(time) / 5;

		this.rightarm.rotation.z = 2 * Math.cos(z + PI);
		this.rightarm.rotation.x = 1 * (cosX - 1);

		this.leftarm.rotation.z = 2 * cosZ;
		this.leftarm.rotation.x = 1 * (cosX + 1);

		this.rightleg.rotation.z = 1.4 * cosZ;
		this.leftleg.rotation.z = 1.4 * Math.cos(z + PI);
	};


	/*
	 * Position person Water
	 */
	this.water = function () {
		this.bodyGroup.rotation.z = -1;
		this.bodyGroup.position.y = 10;
		this.bodyGroup.position.x = -13;
		this.handRight.visible = false;
		this.handRight.traverse(function (child) {
			child.visible = false;
		});
		this.handLeft.visible = false;
		this.handLeft.traverse(function (child) {
			child.visible = false;
		});
	};


	/*
	 * Position person Water out
	 */
	this.waterOut = function () {
		this.bodyGroup.rotation.z = 0;
		this.bodyGroup.position.y = 0;
		this.bodyGroup.position.x = 0;
		this.handRight.visible = true;
		this.handRight.traverse(function (child) {
			child.visible = true;
		});
		this.handLeft.visible = true;
		this.handLeft.traverse(function (child) {
			child.visible = true;
		});
	};


	/*
	 * Change item hand left
	 */
	this.changeLeft = function (id) {
		for (var i = this.handLeft.children.length - 1; i >= 0; i--)
			this.handLeft.remove(this.handLeft.children[ i ]);

		if (!id || app.loader.items['item_' + id] == undefined || app.loader.items['item_' + id].image == undefined)
			return;

		this.handLeft.add(this.loadItem(-40, app.loader.items['item_' + id].image, true));
		this.leftarm.add(this.handLeft);
	};


	/*
	 * Change item hand right
	 */
	this.changeRight = function (id) {
		for (var i = this.handRight.children.length - 1; i >= 0; i--)
			this.handRight.remove(this.handRight.children[ i ]);

		if (!id || app.loader.items['item_' + id] == undefined || app.loader.items['item_' + id].image == undefined)
			return;

		this.handRight.add(this.loadItem(-45, app.loader.items['item_' + id].image));

		this.rightarm.add(this.handRight);
	};


	/*
	 * Load item for hands
	 */
	this.loadItem = function (rotation, image, left) {
		var item = new THREE.Item(app, image);
		item.scale.x = 0.6;
		item.scale.y = 0.6;
		item.scale.z = 0.6;
		item.position.y = -14;
		item.position.z = left ? -1 : 1;
		item.position.x = 2;
		item.rotation.z = rotation * Math.PI / 180 - 0.5;
		return item;
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

	var head = new THREE.CubeGeometry(7, 8, 7);
	this.head = new THREE.Mesh(head, faceMesh);
	for (keyImg in this.materialHead)
		this.head.geometry.faces[keyImg].materialIndex = this.materialHead[keyImg];
	this.head.position.y = 18;


	var arm = new THREE.CubeGeometry(3, 12, 3)
	for (i = 0; i < 8; i += 1)
		arm.vertices[i].y -= 6;

	this.leftarm = new THREE.Mesh(arm, faceMesh);
	this.rightarm = new THREE.Mesh(arm, faceMesh);
	for (keyImg in this.materialArm) {
		this.leftarm.geometry.faces[keyImg].materialIndex = this.materialArm[keyImg];
		this.rightarm.geometry.faces[keyImg].materialIndex = this.materialArm[keyImg];
	}
	this.leftarm.position.z = -5;
	this.rightarm.position.z = 5;
	this.leftarm.position.y = 14;
	this.rightarm.position.y = 14;

	this.bodyGroup.add(this.leftarm);
	this.bodyGroup.add(this.rightarm);

	var body = new THREE.CubeGeometry(4, 12, 8);
	this.body = new THREE.Mesh(body, faceMesh);
	for (keyImg in this.materialBody)
		this.body.geometry.faces[keyImg].materialIndex = this.materialBody[keyImg];
	this.body.position.y = 8;

	this.bodyGroup.add(this.body);


	var leg = new THREE.CubeGeometry(4, 12, 4)
	for (i = 0; i < 8; i += 1)
		leg.vertices[i].y -= 6;
	this.leftleg = new THREE.Mesh(leg, faceMesh);
	this.rightleg = new THREE.Mesh(leg, faceMesh);
	for (keyImg in this.materialLeg) {
		this.leftleg.geometry.faces[keyImg].materialIndex = this.materialLeg[keyImg];
		this.rightleg.geometry.faces[keyImg].materialIndex = this.materialLeg[keyImg];
	}
	this.leftleg.position.z = -2;
	this.rightleg.position.z = 2;
	this.leftleg.position.y = 2;
	this.rightleg.position.y = 2;


	if (hand_right != undefined && hand_right)
		this.changeRight(hand_right);

	if (hand_left != undefined && hand_left)
		this.changeLeft(hand_left);

	this.lightGun = new THREE.PointLight(0xfbcb6c, 0, 600);
	this.handRight.add(this.lightGun);

	this.bodyGroup.add(this.leftleg);
	this.bodyGroup.add(this.rightleg);


	this.ray = new THREE.Mesh(new THREE.CubeGeometry(15, 28, 15));
	this.ray.visible = false;
	this.ray.position.y = 8;
	this.ray.name = 'rayPerson';

	this.add(this.bodyGroup);
	this.add(this.head);
	this.add(this.ray);

	this.scale.set(0.9, 0.9, 0.9);

	this.remove = function () {
		head.dispose();
		arm.dispose();
		body.dispose();
		leg.dispose();
	};
};

THREE.Person.prototype = Object.create(THREE.Object3D.prototype);