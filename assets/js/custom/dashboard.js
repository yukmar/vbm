$(document).ready(function(){
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
	$("#toggle-opsi").click(function(){
    $("#list-opsi").toggle();
  });
  $("#list-prak").change(function(){
  	if ($(this).val() == $(this).data("currentprak")) {
  		$("#btnSubmit").prop("disabled", true);
  	} else {
  		$("#btnSubmit").prop("disabled", false);
  	}
  });
  $("#changePretest").submit(function(){
  	return confirm("Anda yakin ingin mengganti pretest?");
  });
});