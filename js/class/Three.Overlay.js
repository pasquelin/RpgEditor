THREE.Overlay = function () {

	this.global = $('#overlay');

	this.close = function () {
		if (!this.show())
			return;

		this.global.fadeOut(function () {
			$(this).empty();
			$('#instructions').show();
		});
	};

	this.edit = function (data, close, hide) {
		if (data == '')
			return;

		this.global.html(data);

		if (hide)
			this.global.hide();
		else {
			this.global.show();
			$('#instructions').hide();
		}
	};

	this.load = function (url, callback) {
		var _this = this;
		var hideOverlay = false;
		var action = url.split('?')[0];

		if (action.substring(action.length - 4) == 'move')
			hideOverlay = true;


		$.get(url_script + url, function (data) {

			if (data)
				_this.edit(data, true, hideOverlay);

			if (callback && typeof(callback) === 'function')
				callback(data);

			_this.loadData = false;
		});
	};

	this.show = function () {
		if (this.global.is(':visible'))
			return true;

		return false;
	};
}