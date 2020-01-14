(function() {
var soal = {
	paths: {
		pilihan: window.location.origin + '/manage-soal/pilihan',
		edit: window.location.origin + '/manage-soal/edit/?no='
	},
	doms: function() {
		this.$opsi_form = $('#opsi-form');
		this.$opsi_select = this.$opsi_form.find("select");
		this.$daftar_total = $('#table-totalprak');
		this.$daftar_soal = $('#table-daftarsoal');

		this.$add_modal = $('#modal-tambah');
		this.$add_form = $('#form-tambahsoal');
		this.$add_jenis = $('#jenis-soal').find("input[type='radio']");
		this.$add_pilihan = $('#tambah-pilihan');
		this.$add_submit = this.$add_form.find("button[type='submit']");

		this.$edit_modal = $('#modal-edit');
		this.$edit_form = $('#form-edit');
		this.$edit_formpilih = $('.form-pilihan');
		this.$edit_btn = $('.edit');
		this.$edit_prak = this.$edit_form.find("select[name='etxtprak']");
		this.$edit_jab = this.$edit_form.find("textarea[name='etxtjab']");
		this.$edit_submit = this.$edit_form.find("button[type='submit']");
	},
	init: function() {
		this.doms();
		$("select").select2();
		this.$daftar_total.DataTable();
		this.$daftar_soal.DataTable();
		this.$edit_formpilih.hide();
		this.$add_pilihan.hide();
		this.events();
	},
	events: function() {
		var ini = this;
		this.$edit_btn.click(function() {
			ini.show_edit($(this).data('edit'));
		});
		this.$add_jenis.change(function() {
			ini.jenisButir($(this));
		});
		this.$add_form.change(function() {
			ini.check_tambah();
		});
		this.$add_modal.on('show.bs.modal', function() {
			ini.$add_form.trigger('reset');
			ini.$add_pilihan.hide();
		})
	},
	check_tambah: function() {
		var fill = 1;
		if (this.$add_form.find("input[name='jenis']:checked").val() == '2') {
			if (this.$add_form.find("textarea[name='txtjab']").val().length !== 0) {
				this.$add_submit.prop('disabled', false);
			} else {
				this.$add_submit.prop('disabled', true);
			}
		} else {
			this.$add_submit.prop('disabled', true);
			this.$add_form.find("textarea").each(function() {
				if ($(this).val().length == 0) {
					fill = fill * 0;
				}
			});
			if (this.$add_pilihan.find("input[type='radio']:checked").val()) {
				fill = fill * 1;
			} else {
				fill = fill * 0;
			}
			if (fill !== 0) {
				this.$add_submit.prop('disabled', false);
			} else {
				this.$add_submit.prop('disabled', true);
			}
		}
	},
	jenisButir: function($current) {
		if ($current.val() == '1') {
			this.$add_pilihan.show();
		} else {
			this.$add_pilihan.hide();
		}
	},
	show_edit: async function(no) {
		var data = await $.get(this.paths.pilihan, {no: no});
		this.$edit_form.prop('action', this.paths.edit + no);
		this.$edit_prak.val(data.prak);
		this.$edit_prak.trigger('change');
		this.$edit_jab.val(data.soal);
		if (data.pilihan.length !== 0) {
			this.$edit_formpilih.show();
			this.$edit_formpilih.find("input[type='radio']").each(function(i) {
				$(this).val(data.pilihan[i].id);
				if (data.pilihan[i].id == data.kunci) {
					$(this).prop('checked', true);
				}
				$(this).next().val(data.pilihan[i].jabaran);
			});
		}
		this.$edit_modal.modal('toggle');
	}
};
soal.init();
})();
