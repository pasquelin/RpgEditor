THREE.Sound = function () {

	this.position = new THREE.Vector3(0, 0, 0);

	this.audioMove = {
		volume: 0.1
	};

	this.play = function (data, position, distance) {
		if ((!data && !position ) || (!data && !distance))
			return;

		if (!distance)
			distance = this.position.distanceTo(position.position);

		var volume = 1 - distance / 400;

		if (volume < 0)
			return;

		var audioElement = app.loader.listAudio[data];
		try {
			audioElement.currentTime = 0;
			audioElement.volume = volume;
			audioElement.play();
		}
		catch (err) {
		}
	};


	this.effect = function (data, volume) {

		if (!data)
			return;

		if (!volume)
			volume = 0.5;

		var audioElement = app.loader.listAudio[data];
		try {
			audioElement.currentTime = 0;
			audioElement.volume = volume;
			audioElement.play();
		}
		catch (err) {
		}
	};


	this.ambience = function (data) {
		if (!data)
			return;

		var audioElement = app.loader.listAudio[data];

		try {
			audioElement.volume = 0.2;
			audioElement.loop = true;
			audioElement.autoplay = true;
			audioElement.play();
		}
		catch (err) {
		}
	};


	this.move = function (play, inWater) {
		this.audioMove = app.loader.listAudio[( inWater ? 'nager.ogg' : 'move.ogg')];
		try {
			if (!play) {
				this.audioMove.currentTime = 0;
				this.audioMove.pause();
				return;
			}

			this.audioMove.play();
		}
		catch (err) {
		}
	};

	this.update = function (app) {
		this.position = app.hero.getPerson().position.clone();
	};
}