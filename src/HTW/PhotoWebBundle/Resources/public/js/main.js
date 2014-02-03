$.extend(true, $.magnificPopup.defaults, {
  tClose: 'Schliessen (Esc)', // Alt text on close button
  tLoading: 'Lade...'
});

$(document).ready(function() {
	$(document).foundation();
	
 	$('.show-for-medium-up .login-button, .show-for-medium-up .register-button').magnificPopup({
		type: 'ajax',
	});

	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
	});
});