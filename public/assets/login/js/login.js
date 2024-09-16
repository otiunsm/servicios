$(document).ready((function() {
	$("#login_submit").on("click", (function(t) {

		t.preventDefault();
	         let user = $('[name="username"]').val();
             let clave = $('[name="password"]').val();
		$.ajax({
			type: "post",
			url: 'Login/login',
			data:{user, clave},
			dataType: "json",
			success: function(response){
				
				if (response) {
					window.location = window.location;
				}else{
					window.location = window.location;
				}
			}
		})

	}))
}));
