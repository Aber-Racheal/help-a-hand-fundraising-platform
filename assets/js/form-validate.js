function valid_datas( f ){
	
	if( f['first-name'].value == '' ){
		jQuery('#form_status').html('<span class="wrong">Your name must not be empty!</span>');
		notice( f['first-name']);
	}
	
	else if( f['last-name'].value == '' ){
		jQuery('#form_status').html('<span class="wrong">Your email must not be empty and correct format!</span>');
		notice( f['last-name'] );
	}

	else if (f.email.value == '') {
		jQuery('#form_status').html('<span class="wrong">Your email must not be empty!</span>');
		notice(f.email);
	  }
	  // Check if Email format is valid
	else if (!/\S+@\S+\.\S+/.test(f.email.value)) {
		jQuery('#form_status').html('<span class="wrong">Please enter a valid email address!</span>');
		notice(f.email);
	  }
	//}else if( f.phone.value == '' ){
		//jQuery('#form_status').html('<span class="wrong">Your phone must not be empty and correct format!</span>');
		//notice( f.phone );
	// }else if( f.subject.value == '' ){
	// 	jQuery('#form_status').html('<span class="wrong">Your subject must not be empty!</span>');
	// 	notice( f.subject );
	// }else if( f.message.value == '' ){
	// 	jQuery('#form_status').html('<span class="wrong">Your message must not be empty!</span>');
	// 	notice( f.message );

	 // Check if Password is empty
	else if (f.password.value == '') {
		jQuery('#form_status').html('<span class="wrong">Password must not be empty!</span>');
		notice(f.password);
	  }
	  // Check if Password length is less than 6
	else if (f.password.value.length < 6) {
		jQuery('#form_status').html('<span class="wrong">Password must be at least 6 characters long!</span>');
		notice(f.password);
	}else{
		 jQuery.ajax({
			url: 'mail.php',
			type: 'post',
			data: jQuery('form#signup-form').serialize(),
			complete: function(data) {
				jQuery('#form_status').html(data.responseText);
				jQuery('#signup-form').find('input,textarea').attr({value:''});
				jQuery('#signup-form').css({opacity:1});
				jQuery('#signup-form').remove();
			}
		});
		jQuery('#form_status').html('<span class="loading">Sending your message...</span>');
		jQuery('#signup-form').animate({opacity:0.3});
		jQuery('#signup-form').find('input,textarea,button').css('border','none').attr({'disabled':''});
	}
	
	return false;
}

function notice( f ){
	jQuery('form').find('input,textarea').css('border','none');
	f.style.border = '1px solid red';
	f.focus();
}