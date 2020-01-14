$(document).ready(function() {

	$('#txtnilai').keyup(function(){
		if (this.value > 100) {
			$('#btnPeriksa').prop('disabled', true);
		} else {
			$('#btnPeriksa').prop('disabled', false);
		}
	});

	$('#btnPeriksa').click(function(e){
		e.preventDefault();
		let data = {nilai: $('#txtnilai').val()};
		console.log(data);
		let prak = $(this).data('prak');
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-top-full-width",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		$.post($(this).data('act'), data).done(function(dt){
			console.log(dt);
			if (dt == 1) {
				toastr.options.onHidden = function() { window.location.replace(window.location.origin+"/penilaian/"+prak)};
				toastr.success('Pernilaian Berhasil');
			} else {
				toastr.success('Penilaian Tidak Berubah');
			}
		});
	})

	// $('.txtnilai').keyup(function(){
	// 	let total = 0;
	// 	$('.txtnilai').each(function(){
	// 		total += +$(this).val();
	// 	});
	// 	$('#nilaiakhir').html(total);
	// 	if (total > 100) {
	// 		$(this).next().addClass('fa fa-times-circle i-nilai ired');
	// 	}
	// });
});