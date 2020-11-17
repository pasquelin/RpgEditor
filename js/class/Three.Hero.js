THREE.Hero = function (app) {

	this.wireframe = false;

	this.id = app.loader.my.id;
	this.username = app.loader.my.username;
	this.img = app.loader.my.img;
	this.region = app.loader.my.region;
	this.argent = app.loader.my.argent;
	this.xp = app.loader.my.xp;
	this.hp = app.loader.my.hp;
	this.hpMax = app.loader.my.hpMax;
	this.niveau = app.loader.my.niveau;
	this.gravity = app.loader.my.gravity;
	this.speed = app.loader.my.speed;
	this.hand_left = app.loader.my.hand_left;
	this.hand_right = app.loader.my.hand_right;
	this.ammo = app.loader.my.ammo;
	this.currentdirection = {
		x: app.loader.datas.my.currentdirection_x,
		y: 0,
		jump: 0
	};

	this.oxygen = 100;

	var moveForward = false;
	var moveBackward = false;
	var moveLeft = false;
	var moveRight = false;

	var heightJump = 9;
	var jump = false;
	var lastJump = 0;

	var timeFall = 0;
	var speedTmp = 0;

	var inWater = false;

	//size
	var infoSize = app.loader.map.size;
	var sizeBloc = infoSize.elements;

	// memory stat hero
	var memoryBarValue = 0;
	var memoryScoreValue = 0;
	var memoryAmmoValue = 0;
	var memoryDistance = 0;
	var memoryBarOxygenValue = 0;

	var light = new THREE.PointLight(0xffaa00, 1.2, 400);

	// les battle
	var battle = new THREE.Battle();

	var collision = new THREE.Collision(app);

	//camera
	var pitchObject = new THREE.Object3D();
	//pitchObject.position.z = 50;
	pitchObject.add(app.camera);

	var yawObject = new THREE.Object3D();
	yawObject.name = 'camera';
	yawObject.rotation.y = app.loader.datas.my.currentdirection_x;
	yawObject.position.set(app.loader.my.positionX, app.loader.my.positionY, app.loader.my.positionZ);
	yawObject.add(pitchObject);

	var clone = yawObject.clone();


	var person = new THREE.Person('hero', this.img, this.hand_left, this.hand_right);
	person.name = 'hero';

	var shootgun = false;

	var spacerActive = false;


	/*
	 *	GET camera du héro
	 */
	this.getCamera = function () {
		return yawObject;
	};

	/*
	 *	GET myRay
	 */
	this.getRay = function () {
		return person.ray;
	};


	/*
	 *	GET collision du héro
	 */
	this.getCollisionModule = function () {
		return collision.getZone(yawObject.position);
	};

	/*
	 *	GET Torch
	 */
	this.getTorch = function () {
		return light;
	};


	/*
	 *	GET person du héro
	 */
	this.getPerson = function () {
		return person;
	};


	/*
	 *	DELETE le nombre de munition
	 */
	this.deleteAmmo = function () {
		this.ammo--;
		if (this.ammo < 0)
			this.ammo = 0;

		return this.ammo;
	};


	/*
	 * UPDATE du héro
	 */
	this.update = function (appNew) {
		app = appNew;
		clone = yawObject.clone();

		if (moveLeft && !moveRight)
			clone.translateX(-this.speed / (inWater ? 2 : 1));

		if (moveRight && !moveLeft)
			clone.translateX(this.speed / (inWater ? 2 : 1));

		if (moveForward && !moveBackward) {
			if (!inWater)
				speedTmp += 0.05;
			else {
				speedTmp += 0.01;
				clone.translateY(pitchObject.rotation.x);
			}

			clone.translateZ(-(this.speed + speedTmp) / (inWater ? 2 : 1) + (inWater ? Math.abs(pitchObject.rotation.x) : 0));
		}
		if (moveBackward && !moveForward) {
			speedTmp = 0.01;

			if (inWater)
				clone.translateY(pitchObject.rotation.x);

			clone.translateZ((this.speed + speedTmp) / (inWater ? 2 : 1) + (inWater ? Math.abs(pitchObject.rotation.x) : 0));
		}

		if (inWater && !spacerActive)
			clone.position.y += this.currentdirection.jump += (pitchObject.rotation.x / 100);
		else if (inWater && spacerActive)
			clone.position.y += this.currentdirection.jump -= 0.01;
		else
			clone.position.y += this.currentdirection.jump -= this.gravity;

		var isMove = false;
		if (moveForward || moveBackward || moveLeft || moveRight)
			isMove = true;

		var resultCollision = collision.update(yawObject, clone, this.gravity, this.currentdirection.jump, jump, isMove, speedTmp);
		jump = resultCollision.jump;
		speedTmp = resultCollision.speed;
		this.currentdirection.jump = resultCollision.currentJump;

		// collision pnj
		if (isMove) {
			for (var key in app.scene.children) {
				if (app.scene.children[key].name != 'hero'
					&& (app.scene.children[key] instanceof THREE.Bears
					|| app.scene.children[key] instanceof THREE.Dog
					|| app.scene.children[key] instanceof THREE.Person )) {
					var distance = app.scene.children[key].position.distanceTo(clone.position);
					if (distance <= 20 && memoryDistance > distance)
						clone.position = yawObject.position.clone();

					memoryDistance = distance;
				}
			}
		}


		var collisionWater = clone.position.clone();
		var newZone = collision.getZone(collisionWater);
		if (app.map.hasWater(newZone.x, newZone.y, newZone.z)) {
			light.visible = false;
			if (!inWater) {
				this.currentdirection.jump = -1;
				jump = false;
			}
			inWater = true;

			person.water();
		} else {
			if (inWater && jump && this.currentdirection.jump > 0) {
				this.currentdirection.jump = heightJump - this.currentdirection.jump;
				jump = false;
				person.waterOut();
			}
			inWater = false;
		}

		collisionWater.y += 25;
		var newZoneHear = collision.getZone(collisionWater);
		if (app.map.hasWater(newZoneHear.x, newZoneHear.y, newZoneHear.z)) {
			//if in water
			if (!jump && inWater && pitchObject.rotation.x < 0.5 && pitchObject.rotation.x > -0.5)
				this.currentdirection.jump = -0.1;

			water.style.display = user_oxygen.style.display = 'block';
			this.oxygen -= 0.05;

			if (this.oxygen <= 0)
				this.hp--;
		} else {
			if (this.oxygen == 100)
				user_oxygen.style.display = 'none';
			else if (this.oxygen < 100)
				this.oxygen += 0.05;

			water.style.display = 'none';
		}


		if (!moveForward && !moveBackward)
			speedTmp = 0;
		else if (speedTmp > 2)
			speedTmp = 2;
		else if (speedTmp < 0)
			speedTmp = 0;


		//calcul en cas de chute
		if (yawObject.position.y != clone.position.y && yawObject.position.y > clone.position.y && !inWater)
			timeFall += yawObject.position.y - clone.position.y;
		else if (timeFall > 150 && !inWater) {
			app.alert = timeFall * 10;
			app.messages.push('Chute de ' + (Math.round(timeFall) / 20) + 'm');
			app.hero.hp -= Math.round(Math.round(timeFall) / 10);
			timeFall = 0;
		}
		else
			timeFall = 0;


		//sound move
		if ((moveForward || moveBackward || moveLeft || moveRight) && !jump)
			app.sound.move(true, inWater);
		else
			app.sound.move(false, inWater);


		//update person
		if (person.position.x != clone.position.x || person.position.z != clone.position.z || person.rotation.y != PIDivise2 + yawObject.rotation.y)
			app.sound.audioMove.volume = 0.2;
		else
			app.sound.audioMove.volume = 0;

		person.update(( !moveForward && !moveBackward && !inWater ? 2 : spacerActive || speedTmp >= 1 ? 1 : 0), shootgun);


		//update de la torche
		var maxTorch = speedTmp >= 1 ? 50 : 10;

		if (app.clock.getDelta() * 1000 % 2 !== 0)
			light.intensity = random(80, 100) / 100;

		light.position.copy(yawObject.position);
		light.position.x += random(0, maxTorch);
		light.position.z += random(0, maxTorch);


		// update coordonnée
		yawObject.position.copy(clone.position);
		person.position.copy(clone.position);
		person.setRotationY(yawObject.rotation.y);
		person.position.y -= 16;


		//data user
		if (this.hp <= 0)
			this.gameover();
		else if (this.hp > 100)
			this.hp = 100;

		if (this.oxygen > 100)
			this.oxygen = 100;

		if (memoryBarValue != this.hp) {
			memoryBarValue = this.hp;
			valueGraphHp.innerHTML = this.hp;
			contentGraphHp.style.width = this.hp + '%';
		}

		if (memoryBarOxygenValue != this.oxygen) {
			memoryBarOxygenValue = this.oxygen;
			contentGraphOxygen.style.width = memoryBarOxygenValue + '%';
		}

		if (memoryScoreValue != this.argent) {
			memoryScoreValue = this.argent;
			userScore.innerHTML = number_format(this.argent) + ' pt' + (this.argent > 1 ? 's' : '');
		}

		if (memoryAmmoValue != this.ammo) {
			memoryAmmoValue = this.ammo;
			userAmmo.innerHTML = number_format(this.ammo);
		}

		//shoot
		if (shootgun) {
			var now = Date.now();
			if (now - shootgun > 300) {
				battle.add(app);
				shootgun = now;
			}
		}

	};


	/*
	 * GAMEOVER
	 */
	this.gameover = function () {
		yawObject.rotation.set(0, -2.5, 0);
		yawObject.position.set(app.loader.my.positionX, app.loader.my.positionY, app.loader.my.positionZ);
		this.hp = 100;
		this.oxygen = 100;
		this.ammo = 32;
		this.currentdirection.x = 0;
		this.currentdirection.y = 0;

		app.messages.push('GAME OVER');
	};


	/*
	 * Sauvegarde de la session
	 */
	this.saveSession = function () {
		if (sessionStorage.currentdirection_x != this.currentdirection.x % 360)
			sessionStorage.currentdirection_x = this.currentdirection.x % 360;

		if (sessionStorage.currentdirection_y != this.currentdirection.y % 360)
			sessionStorage.currentdirection_y = this.currentdirection.y % 360;
	};


	/*
	 * Geneate GET for URL hero
	 */
	this.getData = function () {
		var zone = collision.getZone(yawObject.position);
		return 'region=' + this.region + '\
			&x=' + (zone.x * sizeBloc + (sizeBloc / 2)) + '\
			&y=' + (zone.y * sizeBloc + (sizeBloc / 2)) + '\
			&z=' + (zone.z * sizeBloc + (sizeBloc / 2)) + '\
			&positionX=' + yawObject.position.x + '\
			&positionY=' + yawObject.position.y + '\
			&positionZ=' + yawObject.position.z + '\
			&argent=' + this.argent + '\
			&xp=' + this.xp + '\
			&hp=' + this.hp + '\
			&hpMax=' + this.hpMax + '\
			&niveau=' + this.niveau + '\
			&gravity=' + this.gravity + '\
			&speed=' + this.speed + '\
			&currentdirection_x=' + this.currentdirection.x;
	};

	/*
	 * MOUSE
	 */


	/*
	 * Position de la sourie
	 */
	this.onMouseMove = function (event) {
		// var global voir map.js
		if (!control)
			return;

		var movementX = event.movementX || event.mozMovementX || event.webkitMovementX || 0;
		var movementY = event.movementY || event.mozMovementY || event.webkitMovementY || 0;

		yawObject.rotation.y -= movementX * ( inWater ? 0.001 : 0.002);
		pitchObject.rotation.x -= movementY * ( inWater ? 0.001 : 0.002);

		pitchObject.rotation.x = Math.max((inWater ? -1.4 : -1), Math.min((inWater ? 1.4 : 1), pitchObject.rotation.x));

		this.currentdirection.x = yawObject.rotation.y;

		event.preventDefault();
	};


	/*
	 * On appuis le click sourie
	 */
	this.onMouseDown = function (event) {
		// var global voir map.js
		if (!control || inWater)
			return;

		shootgun = 1;

		event.preventDefault();
	};


	/*
	 * On relache le click sourie
	 */
	this.onMouseUp = function (event) {

		shootgun = false;

		event.preventDefault();
	};


	/*
	 * On appuie sur une touche du clavier
	 */
	this.onKeyDown = function (event) {

		if (event.keyCode != 13)
			document.getElementById('notifications').innerHTML = '';

		if (event.keyCode == 38 || event.keyCode == 122 || event.keyCode == 119 || event.keyCode == 90 || event.keyCode == 87) {
			if (!moveForward)
				moveForward = true;
		} else if (event.keyCode == 37 || event.keyCode == 113 || event.keyCode == 97 || event.keyCode == 81 || event.keyCode == 65) {
			if (!moveLeft)
				moveLeft = true;
		} else if (event.keyCode == 40 || event.keyCode == 115 || event.keyCode == 83) {
			if (!moveBackward)
				moveBackward = true;
		} else if (event.keyCode == 39 || event.keyCode == 100 || event.keyCode == 68) {
			if (!moveRight)
				moveRight = true;
		} else if (event.keyCode == 32) {
			spacerActive = true;
			if (jump && !inWater)
				return;

			if (lastJump > app.clock.getElapsedTime() - (inWater ? 0.4 : 0.5))
				return;
			lastJump = app.clock.getElapsedTime();
			jump = true;
			this.currentdirection.jump = inWater ? 2 : heightJump;
			app.sound.effect((inWater ? 'jumpWater.ogg' : 'jump.ogg'), 0.1);
		} else if (event.keyCode == 76) {
			if (light.visible)
				light.visible = false;
			else if (!inWater)
				light.visible = true;
		}
	};


	/*
	 * On relache une touche du clavier
	 */
	this.onKeyUp = function (event) {
		if (event.keyCode == 38 || event.keyCode == 122 || event.keyCode == 119 || event.keyCode == 90 || event.keyCode == 87) {
			moveForward = false;
		} else if (event.keyCode == 37 || event.keyCode == 113 || event.keyCode == 97 || event.keyCode == 81 || event.keyCode == 65) {
			moveLeft = false;
		} else if (event.keyCode == 40 || event.keyCode == 115 || event.keyCode == 83) {
			moveBackward = false;
		} else if (event.keyCode == 39 || event.keyCode == 100 || event.keyCode == 68) {
			moveRight = false;
		} else if (event.keyCode == 32) {
			spacerActive = false;
			if (inWater)
				this.currentdirection.jump = 0.2;
		}

		this.saveSession();
	};

	/*
	 * EVENT
	 */
	document.addEventListener('mousedown', bind(this, this.onMouseDown), false);
	document.addEventListener('mouseup', bind(this, this.onMouseUp), false);
	document.addEventListener('mousemove', bind(this, this.onMouseMove), false);
	window.addEventListener('keydown', bind(this, this.onKeyDown), false);
	window.addEventListener('keyup', bind(this, this.onKeyUp), false);
};