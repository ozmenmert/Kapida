$('.nextStep').on('click', function() {

	$('#siparisForm').first()[0].scrollIntoView({
		behavior: 'smooth',
		block: 'start'
	});
	event.preventDefault();

	var telefon = $('#telefon').val();
	var numericTelefon = telefon.replace(/\D/g, '');

	var adet = $('input[name="adet"]:checked').val();
	if (!adet) {
		$('#quickViewModal').modal('hide');
		toastr.error('Lütfen bir ürün seçimi yapınız.', '');
		$('input[name="adet"]').first()[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var isim = $('input[name="name"]').val();

	// Boşluk kontrolü
	if (!isim || isim.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Lütfen Ad ve Soyadınızı Giriniz', 'Eksik Bilgi!');
		$('input[name="name"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	// İsim ve soyisim kontrolü
	var isimParcalari = isim.trim().split(" ");
	if (isimParcalari.length < 2 || isimParcalari.some(word => word.length === 0)) {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Lütfen hem adınızı hem soyadınızı giriniz', 'Eksik Bilgi!');
		$('input[name="name"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	if (numericTelefon.length !== 11) {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Telefon numaranızı eksik yazdınız', 'Eksik Bilgi!');
		$('#telefon')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	} else if (!numericTelefon.startsWith('05')) {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Telefon numaranızı doğru formatta girmelisiniz. Örn: 0 500 000 00 00', 'Eksik Bilgi!');
		$('#telefon')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var adres = $('textarea[name="adres"]').val();
	if (!adres || adres.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Lütfen adres giriniz.', 'Eksik Bilgi!');
		$('textarea[name="adres"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var il = $('select[name="il"]').val();
	if (!il || il.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Lütfen il seçiniz', 'Eksik Bilgi!');
		$('select[name="il"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var ilce = $('select[name="ilce"]').val();
	if (!ilce || ilce.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Lütfen ilçe seçiniz', 'Eksik Bilgi!');
		$('select[name="ilce"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var policy = $('input[name="policy"]').is(':checked');
	if (!policy) {
		$('#step2').hide();
		$('#step1').show();
		toastr.error('Mesafeli Satış Sözleşme kabul etmeden sipariş veremezsiniz', 'Onay Eksik!');
		$('input[name="policy"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	$('#step1').hide();
	$('#step2').show();
});