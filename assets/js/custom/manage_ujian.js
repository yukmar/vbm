var ujian1 = {
	doms: function() {
		this.$table = $('#total-ujian1');
		this.$list = $('#list-ujian1');
	},
	init: function() {
		this.doms();
		this.$table.add(this.$list).DataTable();
		this.events();
	},
	events: function() {
	}
};
var ujian2 = {
	doms: function() {
		this.$table = $('#total-ujian2');
		this.$list = $('#list-ujian2');
	},
	init: function() {
		this.doms();
		this.$table.add(this.$list).DataTable();
		this.events();
	},
	events: function() {
	}
};
var ujian = {
	paths: {
		origin: window.location.origin + '/manage-soal/ujian',
		bank_ujian: window.location.origin + '/manage-soal/ujian/list'
	},
	data: async function(u) {
		this.bank_ujian = await $.get(this.paths.bank_ujian, {n : this.prak, u : u});
	},
	doms: function() {
		this.$form = $('#form-pilih');
		this.$opsi = $("select");
		this.$bank_form = $('#bank-form');
		this.$bank_table = $('#bank-ujian');
		this.$bank_opsi = this.$bank_form.find("select");
		this.prak = this.$bank_form.find("input[type='hidden']").val();
		this.$bank_btn = this.$bank_form.find("button");
		this.$edit_ujian = $('#edit-ujian');
	},
	init: function() {
		this.doms();
		this.$opsi.select2();
		this.events();
		ujian1.init();
		ujian2.init();
	},
	events: function() {
		this.$bank_btn.click(this.show_bank.bind(this));
	},
	show_bank: async function() {
		var ini = this;
		await this.data(this.$bank_opsi.val());
		this.$bank_table.find("input[type='checkbox']").each(function(i) {
			$(this).prop('checked', false);
			if (ini.bank_ujian.list.length !== 0) {
				if (ini.bank_ujian.list.includes($(this).val())) {
					$(this).prop('checked' ,true);
				}
			}
		});
		this.$edit_ujian.find("input[name='j']").val(this.$bank_opsi.val());
	}
}
ujian.init();