var PI = Math.PI;
var PIDivise2 = PI / 2;
var PIDivise90 = PI / 90;
var PIDivise180 = PI / 180;
var PImulti2 = PI * 2;
var PImulti90 = PI * 90;
var PImulti180 = PI * 180;

function bind(scope, fn) {
	return function () {
		fn.apply(scope, arguments);
	};
}

function random(min, max) {
	var randomNum = Math.random() * (max - min);
	return(Math.round(randomNum) + min);
}

function log(txt) {
	if (debug)
		console.log(txt);
}

function info(txt) {
	if (debug)
		console.info(txt);
}

function redirect(url) {
	location.href = url;
}

function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

function savePassword() {
	var new_pwd = $('#new_pwd').val();

	if( new_pwd ) {
		$('#repeat_new_pwd, #new_pwd').removeClass('border-rouge');

		if (new_pwd == '') {
			$('#new_pwd').addClass('border-rouge');
			return;
		}

		if (new_pwd != $('#repeat_new_pwd').val()) {
			$('#repeat_new_pwd, #new_pwd').addClass('border-rouge');
			return;
		}

		$.post(url_script + 'user/update_pwd', {
			'new_pwd': new_pwd
		}, function (data) {
			$('#repeat_new_pwd, #new_pwd').val('');
		});
	}

	var username = $('#pseudo').val();

	if(username) {
		$.post(url_script + 'user/update_username', {
			'username': username
		}, function (data) {
			$('#pseudo').val(data);
		});
	}

}