THREE.Collision = function (app) {

	//size
	var infoSize = app.loader.map.size;
	var sizeBloc = infoSize.elements;
	var maxX = infoSize.xMax * sizeBloc;
	var maxY = infoSize.yMax * sizeBloc;
	var maxZ = infoSize.zMax * sizeBloc;
	var middle = sizeBloc / 2;

	var isCollision = false;

	/*
	 *	SET position du héro
	 */
	this.getZone = function (position) {
		return {
			x: Math.floor(position.x / sizeBloc),
			y: Math.floor((position.y - 25) / sizeBloc),
			yTop: Math.floor((position.y ) / sizeBloc),
			z: Math.floor(position.z / sizeBloc)
		};
	};


	/*
	 *	SET position du héro
	 */
	this.getZoneSmall = function (position) {
		return {
			x: Math.floor(position.x / (sizeBloc / 5)),
			y: Math.floor((position.y - middle) / (sizeBloc / 5)),
			yTop: Math.floor((position.y - middle - 1) / (sizeBloc / 5)),
			z: Math.floor(position.z / (sizeBloc / 5))
		};
	};

	/*
	 COLLISION
	 */
	this.update = function (yawObject, clone, gravity, currentdirectionJump, isJump, isMove, speedTmp) {

		isCollision = false;

		//collision GROUND
		if (clone.position.y < middle) {
			clone.position.y = middle;
			currentdirectionJump = 0;
			if (isJump)
				app.sound.effect('jump2.ogg', 0.1);
			isJump = false;
			isCollision ='collisionGround';
		} else if (clone.position.y > maxY) {
			clone.position.y = max;
			currentdirectionJump = 0;
			isJump = false;
			isCollision ='collisionCeiling';
		}

		//collision Y
		var collisionY = this.getZone(clone.position);
		var collisionYFooter = app.map.hasObstacle(collisionY.x, collisionY.y, collisionY.z);
		if (app.map.hasObstacle(collisionY.x, collisionY.yTop, collisionY.z) || collisionYFooter) {
			clone.position.y = yawObject.position.y;
			if (collisionYFooter) {
				if (isJump)
					app.sound.effect('jump2.ogg', 0.1);
				isJump = false;
				currentdirectionJump = 0;
			}
			isCollision = 'collisionBigY';
		}

		// collision X
		var collisionX = clone.position.clone();
		collisionX.x += clone.position.x > yawObject.position.x ? 10 : -10;
		collisionX = this.getZone(collisionX);
		if (app.map.hasObstacle(collisionX.x, collisionX.yTop, collisionX.z) || app.map.hasObstacle(collisionX.x, collisionX.y, collisionX.z)) {
			clone.position.x = yawObject.position.x;
			speedTmp -= 0.05;
			isCollision = 'collisionBigX';
		}

		// collision Z
		var collisionZ = clone.position.clone();
		collisionZ.z += clone.position.z > yawObject.position.z ? 10 : -10;
		collisionZ = this.getZone(collisionZ);
		if (app.map.hasObstacle(collisionZ.x, collisionZ.yTop, collisionZ.z) || app.map.hasObstacle(collisionZ.x, collisionZ.y, collisionZ.z)) {
			clone.position.z = yawObject.position.z;
			speedTmp -= 0.05;
			isCollision ='collisionBigZ';
		}

		//Small elements
		var collisionXZ = false;

		// collision X
		var collisionX = clone.position.clone();
		collisionX.x += clone.position.x > yawObject.position.x ? 4 : -4;
		collisionX.y += gravity;
		collisionX = this.getZoneSmall(collisionX);
		var collisionXFooter = app.map.hasObstacleSmall(collisionX.x, collisionX.y, collisionX.z);
		var collisionXMedium = app.map.hasObstacleSmall(collisionX.x, collisionX.y + 1, collisionX.z);
		var collisionXTop = app.map.hasObstacleSmall(collisionX.x, collisionX.y + 2, collisionX.z);
		if (collisionXFooter || collisionXMedium || collisionXTop) {
			clone.position.x = yawObject.position.x;
			speedTmp -= 0.05;
			if (collisionXFooter && !collisionXMedium && !collisionXTop && isMove) {
				currentdirectionJump = 3;
				collisionXZ = true;
			}
			isCollision ='collisionX';
		}

		// collision Z
		var collisionZ = clone.position.clone();
		collisionZ.z += clone.position.z > yawObject.position.z ? 4 : -4;
		collisionZ.y += gravity;
		collisionZ = this.getZoneSmall(collisionZ);
		var collisionZFooter = app.map.hasObstacleSmall(collisionZ.x, collisionZ.y, collisionZ.z);
		var collisionZMeduim = app.map.hasObstacleSmall(collisionZ.x, collisionZ.y + 1, collisionZ.z);
		var collisionZTop = app.map.hasObstacleSmall(collisionZ.x, collisionZ.y + 2, collisionZ.z);
		if (collisionZFooter || collisionZMeduim || collisionZTop) {
			clone.position.z = yawObject.position.z;
			speedTmp -= 0.05;
			if (collisionZFooter && !collisionZMeduim && !collisionZTop && isMove) {
				currentdirectionJump = 3;
				collisionXZ = true;
			}
			isCollision ='collisionZ';
		}

		//collision Y
		var collisionY = this.getZoneSmall(clone.position);
		if (!collisionXZ && (app.map.hasObstacleSmall(collisionY.x, collisionY.y, collisionY.z)
			|| app.map.hasObstacleSmall(collisionY.x, collisionY.y + 1, collisionY.z)
			|| app.map.hasObstacleSmall(collisionY.x, collisionY.y + 2, collisionY.z))) {
			clone.position.y = yawObject.position.y;
			if (isJump)
				app.sound.effect('jump2.ogg', 0.1);
			isJump = false;
			currentdirectionJump = 0;
			isCollision ='collisionY';
		}

		// no out map
		if (clone.position.x < 10)
			clone.position.x = 10;
		else if (clone.position.x > maxX - 10)
			clone.position.x = maxX - 10;

		if (clone.position.z < 10)
			clone.position.z = 10;
		else if (clone.position.z > maxZ - 10)
			clone.position.z = maxZ - 10;
		
		return {
			jump : isJump,
			currentJump : currentdirectionJump,
			speed : speedTmp,
			isCollision : isCollision
		};
	};
};