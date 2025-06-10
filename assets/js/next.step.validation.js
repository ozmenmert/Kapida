$('.nextStep').on('click', function(event) {
	event.preventDefault();
	var telefon = $('#telefon').val();
	var numericTelefon = telefon.replace(/\D/g, '');
	var adet = $('input[name="adet"]:checked').val();
	var isim = $('input[name="name"]').val();

	// Boşluk kontrolü
	if (!isim || isim.trim() === "") {
        $('input[name="name"]').css({'border':'1px solid red'});
		$("#name_error").html("İsim alanı gereklidir.");
	}else{
        // İsim ve soyisim kontrolü
        var isimParcalari = isim.trim().split(" ");
        if (isimParcalari.length < 2 || isimParcalari.some(word => word.length === 0)) {
            $('input[name="name"]').css({'border':'1px solid red'});
            $("#name_error").html("Lütfen Ad ve Soyadınızı Giriniz.");
        }else{
            $('input[name="name"]').css({'border':'none'});
            $("#name_error").html("");
        }
    }	

	if (numericTelefon.length !== 11) {
        $('input[name="telefon"]').css({'border':'1px solid red'});
		$("#telefon_error").html("Telefon numaranızı eksik yazdınız.");
	}else{
        if (!numericTelefon.startsWith('05')) {
            $('input[name="telefon"]').css({'border':'1px solid red'});
            $("#telefon_error").html("Telefon numaranızı doğru formatta girmelisiniz. Örn: 0 500 000 00 00");
        }else{
            $('input[name="telefon"]').css({'border':'none'});
            $("#telefon_error").html("");
        }
	}

    var il = $('#il').find(":selected").val();
    if(!il || il === ""){
        $('#il_div').css({'border' : '1px solid red', 'border-radius' : '10px'});
        $("#il_error").html("Lütfen il seçiniz.");
    }else{
        $('#il_div').css({'border':'none'});
        $("#il_error").html("");
    }

	var ilce = $('#ilce').find(":selected").val();
	if (!ilce || ilce.trim() === "") {
		$('#ilce_div').css({'border' : '1px solid red', 'border-radius' : '10px'});
        $("#ilce_error").html("Lütfen ilçe seçiniz.");
	}else{
        $('#ilce_div').css({'border':'none'});
        $("#ilce_error").html("");
    }

    var adres = $('textarea[name="adres"]').val();
	if (!adres || adres.trim() === "") {
        $('textarea[name="adres"]').css({'border':'1px solid red'});
        $("#adres_error").html("Lütfen adres giriniz.");
	}else{
        $('textarea[name="adres"]').css({'border':'none'});
        $("#adres_error").html("");
    }

    var policy = $(".policyCheck").prop("checked");
    if (!policy) {
        $('.policy').css({'border' : '1px solid red', 'border-radius' : '10px'});
        $('.policyCheck').css({'border' : '1px solid red'});
        $("#policy_error").html("Mesafeli Satış Sözleşme kabul etmeden sipariş veremezsiniz.");
	}else{
        $("#policy_error").html("");
        $('.policy').css({'border' : 'none'});
        $('.policyCheck').css({'border' : 'none'});
    }

});