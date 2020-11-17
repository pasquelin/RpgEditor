THREE.FirstPersonControls = function (object, domElement) {

	this.object = object;
	this.target = new THREE.Vector3(0, 0, 0);

	this.domElement = ( domElement !== undefined ) ? domElement : document;

	this.movementSpeed = 0.01;
	this.lookSpeed = 0.005;

	this.lookVertical = true;
	this.activeLook = true;
	this.autoForward = false;

	this.heightSpeed = false;
	this.heightCoef = 1.0;
	this.heightMin = 0.0;
	this.heightMax = 1.0;

	this.constrainVertical = false;
	this.verticalMin = 0;
	this.verticalMax = Math.PI;

	this.autoSpeedFactor = 0.0;

	this.mouseX = 0;
	this.mouseY = 0;

	this.lat = 0;
	this.lon = 0;
	this.phi = 0;
	this.theta = 0;

	this.moveForward = false;
	this.moveBackward = false;
	this.moveLeft = false;
	this.moveRight = false;
	this.freeze = false;

	this.viewHalfX = 0;
	this.viewHalfY = 0;

	if (this.domElement !== document) {

		this.domElement.setAttribute('tabindex', -1);

	}

	//

	this.handleResize = function () {

		this.viewHalfX = window.innerWidth / 2;
		this.viewHalfY = window.innerHeight / 2;
	};

	this.onMouseDown = function (event) {

		if (this.domElement !== document) {

			this.domElement.focus();

		}
		this.activeLook = false;

	};

	this.onMouseUp = function (event) {

		this.activeLook = true;

	};

	this.onMouseMove = function (event) {

		this.mouseX = event.pageX - this.viewHalfX;
		this.mouseY = event.pageY - this.viewHalfY;

	};

	this.onMouseOver = function (event) {
		this.activeLook = true;
		event.preventDefault();
		event.stopPropagation();
	};

	this.onMouseOut = function (event) {
		this.activeLook = false;
		event.preventDefault();
		event.stopPropagation();

	};

	this.onKeyDown = function (event) {

		switch (event.keyCode) {

			case 38 :
			case 122 :
			case 119 :
			case 90 :
			case 87 : // Flèche haut, z, w, Z, W
				this.moveForward = true;
				break;

			case 37 :
			case 113 :
			case 97 :
			case 81 :
			case 65 : // Flèche gauche, q, a, Q, A
				this.moveLeft = true;
				break;

			case 40 :
			case 115 :
			case 83 : // Flèche bas, s, S
				this.moveBackward = true;
				break;

			case 39 :
			case 100 :
			case 68 : // Flèche droite, d, D
				this.moveRight = true;
				break;

			case 82: /*R*/
				this.moveUp = true;
				break;
			case 70: /*F*/
				this.moveDown = true;
				break;

			case 16:
				this.activeLook = false;
				break;
		}

	};

	this.onKeyUp = function (event) {

		switch (event.keyCode) {

			case 38 :
			case 122 :
			case 119 :
			case 90 :
			case 87 : // Flèche haut, z, w, Z, W
				this.moveForward = false;
				break;

			case 37 :
			case 113 :
			case 97 :
			case 81 :
			case 65 : // Flèche gauche, q, a, Q, A
				this.moveLeft = false;
				break;

			case 40 :
			case 115 :
			case 83 : // Flèche bas, s, S
				this.moveBackward = false;
				break;

			case 39 :
			case 100 :
			case 68 : // Flèche droite, d, D
				this.moveRight = false;
				break;

			case 82: /*R*/
				this.moveUp = false;
				break;
			case 70: /*F*/
				this.moveDown = false;
				break;

			case 16:
				this.activeLook = true;
				break;
		}

	};

	this.update = function (delta, dataRegion) {
		var actualMoveSpeed = 0;


		if (this.heightSpeed) {

			var y = THREE.Math.clamp(this.object.position.y, this.heightMin, this.heightMax);
			var heightDelta = y - this.heightMin;

			this.autoSpeedFactor = delta * ( heightDelta * this.heightCoef );

		} else
			this.autoSpeedFactor = 0.0;

		actualMoveSpeed = delta * this.movementSpeed;

		if (this.moveForward || ( this.autoForward && !this.moveBackward )) this.object.translateZ(-( actualMoveSpeed + this.autoSpeedFactor ));
		if (this.moveBackward) this.object.translateZ(actualMoveSpeed);

		if (this.moveLeft)  this.object.translateX(-actualMoveSpeed);
		if (this.moveRight) this.object.translateX(actualMoveSpeed);

		if (this.moveUp) this.object.translateY(actualMoveSpeed);
		if (this.moveDown) this.object.translateY(-actualMoveSpeed);


		if (!this.freeze) {
			var actualLookSpeed = delta * this.lookSpeed;

			if (!this.activeLook || (this.mouseX < 100 && this.mouseX > -100 && this.mouseY < 100 && this.mouseY > -100)) {

				actualLookSpeed = 0;

			}

			this.lon += this.mouseX * actualLookSpeed;
			if (this.lookVertical) this.lat -= this.mouseY * actualLookSpeed; // * this.invertVertical?-1:1;

			this.lat = Math.max(-85, Math.min(85, this.lat));
			this.phi = ( 90 - this.lat ) * Math.PI / 180;
			this.theta = this.lon * Math.PI / 180;

			var targetPosition = this.target,
				position = this.object.position;
			targetPosition.x = position.x + 100 * Math.sin(this.phi) * Math.cos(this.theta);
			targetPosition.y = position.y + 100 * Math.cos(this.phi);
			targetPosition.z = position.z + 100 * Math.sin(this.phi) * Math.sin(this.theta);


			var verticalLookRatio = 1;

			if (this.constrainVertical) {

				verticalLookRatio = Math.PI / ( this.verticalMax - this.verticalMin );

			}

			this.lon += this.mouseX * actualLookSpeed;
			if (this.lookVertical) this.lat -= this.mouseY * actualLookSpeed * verticalLookRatio;

			this.lat = Math.max(-85, Math.min(85, this.lat));
			this.phi = ( 90 - this.lat ) * Math.PI / 180;

			this.theta = this.lon * Math.PI / 180;

			if (this.constrainVertical) {

				this.phi = THREE.Math.mapLinear(this.phi, 0, Math.PI, this.verticalMin, this.verticalMax);

			}

			var targetPosition = this.target,
				position = this.object.position;

			targetPosition.x = position.x + 100 * Math.sin(this.phi) * Math.cos(this.theta);
			targetPosition.y = position.y + 100 * Math.cos(this.phi);
			targetPosition.z = position.z + 100 * Math.sin(this.phi) * Math.sin(this.theta);
			this.object.lookAt(targetPosition);
		}
	};


	this.domElement.addEventListener('contextmenu', function (event) {
		event.preventDefault();
	}, false);

	this.domElement.addEventListener('mousemove', bind(this, this.onMouseMove), false);
	this.domElement.addEventListener('mousedown', bind(this, this.onMouseDown), false);
	this.domElement.addEventListener('mouseup', bind(this, this.onMouseUp), false);

	this.domElement.addEventListener('mouseover', bind(this, this.onMouseOver), false);
	this.domElement.addEventListener('mouseout', bind(this, this.onMouseOut), false);

	document.addEventListener('keydown', bind(this, this.onKeyDown), false);
	document.addEventListener('keyup', bind(this, this.onKeyUp), false);

	function bind(scope, fn) {

		return function () {

			fn.apply(scope, arguments);

		};

	};

	this.handleResize();

};
