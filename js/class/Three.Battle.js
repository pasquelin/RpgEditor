THREE.Battle = function () {

	THREE.Object3D.call(this);

	// projector
	var projector = new THREE.Projector();

	/*
	 * Création d'un tire de M4
	 */
	this.add = function (app) {

		if (!app.hero.ammo) {
			app.sound.effect('gunEmpty.mp3', 0.3);
			return;
		}

		app.sound.effect('gunFire.mp3', 0.5);
		app.hero.getPerson().lightGun.intensity = 5;
		app.hero.deleteAmmo();

		var vector = new THREE.Vector3(0, 0, 0.5);

		projector.unprojectVector(vector, app.camera);

		var ray = new THREE.Raycaster(app.hero.getCamera().position, vector.sub(app.hero.getCamera().position).normalize());

		var intersects = ray.intersectObjects(app.group);

		if (intersects.length > 0 && intersects[0].distance < 2000 && intersects[0].object.parent.hp != undefined && intersects[0].object.parent.hp >= 0) {
			intersects[0].object.parent.hp--;
			if (intersects[0].object.parent.hp)
				app.hero.argent += 100;

			app.bots[intersects[0].object.parent.idBot].setJump(2);
			app.hero.argent += Math.round(intersects[0].distance / 100);
		} else
			setTimeout(function () {
				app.sound.effect('ricoche.mp3', 0.4);
			}, 50);
	}

	/*
	 * Création d'un tire pour un bot
	 */
	this.addForBot = function (app, self, noGun) {
		var distance = self.position.distanceTo(app.hero.getCamera().position);

		var vector = app.hero.getCamera().position.clone();

		var listObject = app.map.getUnivers().children;
		listObject.push(app.hero.getRay());

		var ray = new THREE.Raycaster(self.position, vector.sub(self.position).normalize());
		var intersects = ray.intersectObjects(listObject);

		if (intersects.length > 0 && intersects[0].distance < noGun ? 100 : 2000) {
			if (intersects[0].object.name != undefined && intersects[0].object.name == 'rayPerson') {
				if (random(0, distance) < 50) {
					var pt = random(3, 12);
					app.hero.hp -= pt;
					app.alert = pt * 1000;
				}

				if (noGun)
					app.sound.play('poing.mp3', null, distance);
				else
					app.sound.play('gunFire.mp3', null, distance);
			}
		}
	}

	/*
	 * Création d'un tire pour un animal
	 */
	this.addForAnimalDog = function (app, distance) {
		if (random(0, distance) < 50) {
			var pt = random(1, 3);
			app.hero.hp -= pt;
			app.alert = pt * 1000;
		}

		app.sound.play('attackDog.ogg', null, distance);
	}

	/*
	 * Création d'un tire pour un animal
	 */
	this.addForAnimalBears = function (app, distance) {
		if (random(0, distance) < 50) {
			var pt = random(3, 8);
			app.hero.hp -= pt;
			app.alert = pt * 1000;
		}

		app.sound.play('attackBears.ogg', null, distance);
	}
};

THREE.Battle.prototype = Object.create(THREE.Object3D.prototype);