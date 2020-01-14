var user = {
	paths: {
		data: window.location.origin + '/manage-user/set/?n=',
		edit: window.location.origin + '/manage-user/edit/?n='
	},
	doms: function() {
		this.$table = $('#daftar-user');

		this.$edit_modal = $('#modal-edit');
		this.$edit_form = $('#form-edit');
		this.$edit_btn = $('.edit');
		this.$edit_priv = this.$edit_form.find("select[name='etxtpriv']")
		this.$edit_user = this.$edit_form.find("input[name='etxtuser']");
		this.$edit_nama = this.$edit_form.find("input[name='etxtnama']");
		this.$edit_off = this.$edit_form.find("select[name='etxtoff']");
		this.$edit_pass = this.$edit_form.find("input[name='etxtpass']");
	},
	init: function() {
		this.doms();
		this.$table.DataTable();
		this.events();
		$('select').select2();
	},
	events: function() {
		var ini = this;
		this.$edit_btn.click(function() {
			ini.show_edit($(this).data('edit'));
		});
	},
	show_edit: async function(no) {
		var data = await $.get(this.paths.data + no);
		this.$edit_form.prop('action', this.paths.edit + no);
		this.$edit_priv.val(data.priv);
		this.$edit_priv.trigger('change');
		this.$edit_user.val(data.user);
		this.$edit_nama.val(data.nama);
		this.$edit_off.val(data.off);
		this.$edit_off.trigger('change');
		this.$edit_modal.modal('toggle');
	}
};

user.init();