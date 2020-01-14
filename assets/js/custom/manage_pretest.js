var manage_pretest = {
	doms: function() {
		this.$daftar = $('#daftar-pretest');
		this.$total = $('#daftar-total');
		this.$select = $('select');
		this.$bank = $('#table-bank');
	},
	init: function() {
		this.doms();
		this.$daftar.add(this.$total).add(this.$bank).DataTable();
		this.$select.select2();
		this.events();
	},
	events: function() {
	}
}
manage_pretest.init();