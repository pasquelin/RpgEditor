THREE.Bot = function (app, dataBot) {

	THREE.Object3D.call(this);

	this.wireframe = false;

	this.gravity = app.loader.my.gravity;
	this.fixe = dataBot.fixe;
	this.leak = dataBot.leak;
	this.radar = 200;
	this.speed = 0.4;
	this.speedMin = 0.5;
	this.speedMax = 1;

	this.target = new THREE.Vector3(0, 0, 0);


	var moveForward = true;
	var moveLeft = false;
	var moveRight = false;
	var jump = false;

	var lastAction = false;
	var isDie = false;
	var turn = false;

	var timeSpeed = false;

	var currentdirection = {
		x: 0,
		jump: 0
	};

	var speedTmp = 0;

	//size
	var infoSize = app.loader.map.size;
	var sizeBloc = infoSize.elements;

	// les battle
	var battle = new THREE.Battle();

	var collision = new THREE.Collision(app);

	var person;

	if (dataBot.type == 2)
		person = new THREE.Bears(dataBot.img, this.id);
	else if (dataBot.type == 3)
		person = new THREE.Dog(dataBot.img, this.id);
	else {
		person = new THREE.Person('bot', dataBot.img, null, null, this.id);
		if (!this.fixe)
			person.changeRight(1);
	}

	person.name = 'bot';

	var action = function () {
		if (isDie)
			return;

		var rand = random(0, 100);

		// On fait tourner le bot aléatoirement
		turn = (rand > 90) ? true : false;

		//console.log('action', turn);

		setTimeout(action, 100);
	}


	this.getPerson = function () {
		return person;
	};

	this.getRay = function () {
		return person.ray;
	};

	this.setJump = function (value) {
		this.fixe = false;

		if (dataBot.type == 2)
			app.sound.play('touch_bears.ogg', person);
		else if (dataBot.type == 3)
			app.sound.play('touch_dog.ogg', person);
		else
			app.sound.play('touch.ogg', person);

		currentdirection.jump = value;
	};


	this.speack = function (app) {
		if (notifications.innerHTML != '' || this.fixe)
			return;

		if (this.position.distanceTo(app.hero.getPerson().position) < 100) {
			var last = new Date().getTime();
			if (last - lastAction < 5000) {
				app.messages.push('...');
				return;
			}
			lastAction = last;

			app.messages.push(app.map.getArticles());
		}
	};


	/*
	 * UPDATE
	 */
	this.update = function (app) {
		if (person.getDie()) {
			isDie = true;
			if (person.cycleDie == 500)
				return 'remove';
			if (person.name == 'bot')
				app.map.deleteOverModule(collision.getZone(this.position));
			return;

		}

		if (buttonEnter)
			this.speack(app);

		var hero = app.hero.getPerson().position;

		var distance = person.position.distanceTo(hero);

		// Afficher le bot ou non selon sa distance avec le hero
		if (distance > 800) {
			if (person.visible) {
				person.visible = false;
				person.traverse(function (child) {
					child.visible = false;
					person.ray.visible = false;
				});
			}
			return;
		} else if (!person.visible) {
			person.visible = true;
			person.traverse(function (child) {
				child.visible = true;
				person.ray.visible = false;
			});
		}

		// On vérifie que le bot se trouve dans la partie action du hero
		this.speed = this.speedMin;

		if (distance < this.radar) {
			timeSpeed = app.clock.elapsedTime + random(3, 10);
			if (!this.fixe)
				this.speed = this.speedMax;
		}


		// On vérifie que le bot se trouve dans la partie action du hero
		if (distance < this.radar) {
			this.rotation.y = Math.atan2(person.position.x - hero.x, person.position.z - hero.z);
		} else if (moveLeft && !this.fixe)
			this.rotation.y += 0.05;
		else if (moveRight && !this.fixe)
			this.rotation.y -= 0.05;


		var isMove = false;
		var clone = this.clone();
		clone.position.y += currentdirection.jump -= this.gravity;

		if (moveForward) {
			speedTmp += 0.005;
			clone.translateZ(-(this.speed + speedTmp));
		}


		if (moveForward || moveLeft || moveRight)
			isMove = true;

		var resultCollision = collision.update(this, clone, this.gravity, currentdirection.jump, jump, isMove, speedTmp);
		jump = resultCollision.jump;
		speedTmp = resultCollision.speed;
		currentdirection.jump = resultCollision.currentJump;

		if (resultCollision.isCollision && resultCollision.isCollision != 'collisionY' && resultCollision.isCollision != 'collisionGround' && resultCollision.isCollision != 'collisionBigY' && !moveLeft && !moveRight) {
			if (random(0, 100) > 50)
				moveLeft = true;
			else
				moveRight = true;
		} else if (!resultCollision.isCollision || resultCollision.isCollision == 'collisionGround' || resultCollision.isCollision == 'collisionY' || resultCollision.isCollision == 'collisionBigY')
			moveLeft = moveRight = false;

		if (speedTmp > 2)
			speedTmp = 2;
		else if (speedTmp < 0)
			speedTmp = 0;

		if (distance > 20) {
			if (dataBot.fixe && this.fixe) {
				this.position.set(this.position.x, clone.position.y, this.position.z);
			} else {
				this.position.copy(clone.position);

				if (person.position.x != this.position.x || person.position.y != this.position.y - 16 || person.position.z != this.position.z)
					person.update(speedTmp >= 0.6 ? 1 : 0);
			}
		} else
			person.update(2);

		person.position.copy(this.position);
		person.position.y -= 16;
		person.setRotationY(this.rotation.y);


		// si c est un bot et a porté du hero on peut attaquer
		if (dataBot.type == 2 || dataBot.type == 3) {
			if (distance <= 20) {
				if (app.clock.elapsedTime % 1 < 0.2)
					if (random(0, 5) < 1) {
						person.update(3);
						if (dataBot.type == 2)
							battle.addForAnimalBears(app, person.position.distanceTo(app.hero.getCamera().position));
						else if (dataBot.type == 3)
							battle.addForAnimalDog(app, person.position.distanceTo(app.hero.getCamera().position));
					}
			}
		} else if (dataBot.type != 2 && dataBot.type != 3 && ( ( !this.fixe && !dataBot.fixe && distance < this.radar) || ( !this.fixe && dataBot.fixe && distance <= 20))) {
			if (app.clock.elapsedTime % 1 < 0.2)
				if (random(0, 5) < 1) {
					person.update(3);
					battle.addForBot(app, this, dataBot.fixe);
				}
		}
	};

	this.position.set(dataBot.x, dataBot.y, dataBot.z);
	setTimeout(action, 500);
};

THREE.Bot.prototype = Object.create(THREE.Object3D.prototype);