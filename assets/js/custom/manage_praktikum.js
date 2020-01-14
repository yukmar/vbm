(function(){
	var praktikum = {
	doms: function() {
		this.$table = $('#daftar-praktikum');
		this.$edit_btn = $(".edit");
		this.$edit_modal = $('#modal-edit');
		this.$edit_form = $('#form-edit');
		this.$edit_judul = this.$edit_form.find("input[name='etxtjudul']");
		this.$edit_desc = this.$edit_form.find("textarea[name='etxtdesc']");
		this.$edit_pdf = this.$edit_form.find("input[name='etxtpdf']");
		this.$edit_video = this.$edit_form.find("input[name='etxtvideo']");
	},
	init: function() {
		this.doms();
		this.$table.DataTable();
		this.events();
	},
	events: function() {
		var ini = this;
		this.$edit_btn.click(function(){
			ini.show_edit($(this).data('edit'));
		});
	},
	show_edit: async function(no) {
		var data = await $.get(window.location.origin + '/manage-praktikum/set/', {no : no});
		this.$edit_form.prop('action', window.location.origin + '/manage-praktikum/edit/?n=' + no);
		this.$edit_judul.val(data.judul);
		this.$edit_desc.val(data.desc);
		this.$edit_pdf.val(data.pdf);
		this.$edit_video.val(data.video);
		this.$edit_modal.modal('toggle');
	}
}
praktikum.init();
})();