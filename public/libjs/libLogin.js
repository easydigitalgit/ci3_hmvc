

jQuery(document).ready(function() {
 //loadStrukturalSelect();
	$('#loginAlert').empty();
	$('#btnLogin').on('click',function(e) {
		e.preventDefault();
		console.log('btnlogin klik');
		var url = currentClass +'do_login';
		var formdata = new FormData($('#formLogin')[0]);
		
		$.ajax({
			url: url,
			type: "POST",
	        data: formdata,
	        dataType: "JSON",
	        contentType: false,
	        processData: false,
	        
		})
		.done(function(d) {
			//console.log("success");
			//console.log(d.msg);
			if(d.status == false){
				$('#loginAlert').addClass('alert alert-danger');
				$('#loginAlert').html(d.msg);
				//console.log(d.msg);
			}
			else { 
				$('#loginAlert').html(d.msg);
				$('#loginAlert').addClass('alert alert-success');
				window.location.href= d.dashboard; //site_url +'admin';
			}

		})
		.fail(function() {
			console.log("error");
			$('#loginAlert').addClass('alert alert-danger');
		 	$('#loginAlert').html('Terjadi kesalahan pada proses login'); 
		})
		.always(function() {
			console.log("complete");
		});
		

	});

$("#btnCreateAcc").click(function(event) {
	event.preventDefault();
	$(".help-block").html('');
	var url = site_url + 'auth/Login/create_acc';
	var formID = 'formCreateAccount';
	//var url = currentClass+ '/create_acc';
		var formdata = new FormData($('#formCreateAccount')[0]);
		//console.log(formdata);
		$.ajax({
			url: url,
			type: "POST",
	        data: formdata,
	        dataType: "JSON",
	        contentType: false,
	        processData: false,
	        
		})
		.done(function(d) {
			console.log("success");
			//console.log(d.msg);
			if(d.status == false){
				$('#crateAccAlert').addClass('alert alert-danger');
				$('#crateAccAlert').html(d.msg);
				for(var prop in d.msg) {
                 $("#"+formID+ " [name= "+prop+"] " ).next().next('span').html(d.msg[prop]);
                            
             }
			}
			else { 

				$('#crateAccAlert').removeClass('alert alert-danger')
				$('#crateAccAlert').addClass('alert alert-success');
				$('#crateAccAlert').html(d.msg);
				//window.location.href= d.dashboard; //site_url +'admin';
			}

		})
		.fail(function() {
			console.log("error");
			$('#crateAccAlert').addClass('alert alert-danger');
		 	 $('#crateAccAlert').html('Terjadi kesalahan pada proses createAccount'); 
		})
		.always(function() {
			console.log("complete");
		});
});

$("#createAccount").click(function(event) {
	console.log("createAcc clicked");
	loadStrukturalSelect();
	$("#form-login").addClass('d-none');
	$("#form-account").removeClass('d-none');
});
$("#signIN").click(function(event) {
	$("#form-account").addClass('d-none');
	$("#form-login").removeClass('d-none');

});




$("#password").on("keyup", function(event) {
   if (event.keyCode === 13) {
      event.preventDefault();
      $('#btn_login').click();
  }
});



});
