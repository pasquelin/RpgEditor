THREE.PersonControls = function ( object, domElement ) {

		this.object = object;
		this.objectPosition = object.position.clone();
		this.target = new THREE.Vector3( 0, 0, 0 );

		this.domElement = ( domElement !== undefined ) ? domElement : document;

		this.movementSpeed = 400;
		this.lookSpeed = 0.2;

		this.nofly = true;
	
		this.lookVertical = true;
		this.autoForward = false;
		this.invertVertical = false;

		this.activeLook = true;

		this.heightSpeed = false;
		this.heightCoef = 1.0;
		this.heightMin = 0.0;

		this.constrainVertical = true;
		this.verticalMin = Math.PI / 2 - 0.3;
		this.verticalMax = Math.PI / 2 + 0.3;

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
		this.jump = false;

		this.mouseDragOn = false;

		if ( this.domElement === document ) {
				this.viewHalfX = window.innerWidth / 2;
				this.viewHalfY = window.innerHeight / 2;

		} else {
				this.viewHalfX = this.domElement.offsetWidth / 2;
				this.viewHalfY = this.domElement.offsetHeight / 2;
				this.domElement.setAttribute( 'tabindex', -1 );
		}

		this.onMouseOver = function () {
				this.freeze = false;
		};

		this.onMouseOut = function () {
				this.freeze = true;
		};

		this.onMouseMove = function ( event ) {

				if ( this.domElement === document ) {
						this.mouseX = event.pageX - this.viewHalfX;
						this.mouseY = event.pageY - this.viewHalfY;

				} else {
						this.mouseX = event.pageX - this.domElement.offsetLeft - this.viewHalfX;
						this.mouseY = event.pageY - this.domElement.offsetTop - this.viewHalfY;
				}

		};
		
		this.onKeyDown = function ( event ) {

				switch( event.keyCode ) {
						case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
								this.moveForward = true;
								break;

						case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
								this.moveLeft = true;
								break;

						case 40 : case 115 : case 83 : // Flèche bas, s, S
								this.moveBackward = true;
								break;

						case 39 : case 100 : case 68 : // Flèche droite, d, D
								this.moveRight = true;
								break;

						case 32:
								this.jump = true;
								break;

				}

		};

		this.onKeyUp = function ( event ) {

				switch( event.keyCode ) {

						case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
								this.moveForward = false;
								break;

						case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
								this.moveLeft = false;
								break;

						case 40 : case 115 : case 83 : // Flèche bas, s, S
								this.moveBackward = false;
								break;

						case 39 : case 100 : case 68 : // Flèche droite, d, D
								this.moveRight = false;
								break;

				}

		};

		this.update = function( delta, dataSocket, cubes ) {
		
				if ( this.freeze )
						return;
				
				
				console.log(cubes);
				var vector = new THREE.Vector3( -1, 0, 0 );
				var ray = new THREE.Ray(this.object.position, vector);
				var intersects = ray.intersectObject(cubes);

				if (intersects.length > 0) {
						if (intersects[0].distance < 5) {
								console.log(intersects);
						}
				}

				if( dataSocket.jump )
						this.jump = true;
				
				var actualMoveSpeed = delta * this.movementSpeed;
				var actualLookSpeed = delta * this.lookSpeed;
				var verticalLookRatio = 1;
				var targetPosition = this.target, position = this.object.position;

				this.autoSpeedFactor = 0.0;
				
				if ( this.heightSpeed )
						this.autoSpeedFactor = delta * ( ( THREE.Math.clamp( this.object.position.y, this.heightMin, this.heightMax ) - this.heightMin) * this.heightCoef );

				if ( !this.activeLook ) 
						actualLookSpeed = 0;

				if ( this.constrainVertical )
						verticalLookRatio = Math.PI / ( this.verticalMax - this.verticalMin );

			
				if ( this.moveForward || ( this.autoForward && !this.moveBackward ) || dataSocket.left.y > 0 ) {
						this.object.translateZ( - ( actualMoveSpeed + this.autoSpeedFactor ) );
						if( this.nofly && !this.jump)
								this.object.position.y = 100;
				}
				else if ( this.moveBackward || dataSocket.left.y < 0 ) {
						this.object.translateZ( actualMoveSpeed );
						if( this.nofly && !this.jump)
								this.object.position.y = 100;
				}
				
				if( dataSocket.right.x || dataSocket.right.y )
				{
						if ( dataSocket.right.x ) {
								var vitesse = dataSocket.right.x > 50 ? 50 : dataSocket.right.x < -50 ? -50 : dataSocket.right.x;
								this.lon +=  vitesse * 0.05;
						}
						if( this.lookVertical && dataSocket.right.y ) 
								this.lat += dataSocket.right.y * 0.05 * (this.invertVertical?-1:1) * verticalLookRatio;
				}
				else
				{
						if ( this.moveLeft || this.mouseX < -200 ) 
								this.lon -=  1;
						else if ( this.moveRight || this.mouseX > 200 ) 
								this.lon +=  1;	
						
						if( this.lookVertical && ( this.mouseY < -100 || this.mouseY  > 100 ) ) 
								this.lat -= this.mouseY * actualLookSpeed * (this.invertVertical?-1:1) * verticalLookRatio;
				}
				
				if(  this.object.position.y > 170)
						this.jump = false;
				
				if( this.jump && this.object.position.y < 170) 
						this.object.position.y +=  6;
				else if(this.object.position.y > 100)
						this.object.position.y -= 6;

				this.lat = Math.max( - 85, Math.min( 85, this.lat ) );
				this.phi = ( 90 - this.lat ) * Math.PI / 180;

				this.theta = this.lon * Math.PI / 180;

				if ( this.constrainVertical )
						this.phi = THREE.Math.mapLinear( this.phi, 0, Math.PI, this.verticalMin, this.verticalMax );

				targetPosition.x = position.x + 100 * Math.sin( this.phi ) * Math.cos( this.theta );
				targetPosition.y = position.y + 100 * Math.cos( this.phi );
				targetPosition.z = position.z + 100 * Math.sin( this.phi ) * Math.sin( this.theta );
		

				this.object.lookAt( targetPosition );
		};
		
		
		this.domElement.addEventListener( 'mouseover', bind( this, this.onMouseOver ), false );
		this.domElement.addEventListener( 'mouseout', bind( this, this.onMouseOut ), false );
		this.domElement.addEventListener( 'mousemove', bind( this, this.onMouseMove ), false );
		this.domElement.addEventListener( 'keydown', bind( this, this.onKeyDown ), false );
		this.domElement.addEventListener( 'keyup', bind( this, this.onKeyUp ), false );

		function bind( scope, fn ) {
				return function () {
						fn.apply( scope, arguments );
				};
		}

};
