<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<script>
    const ToastTopEnd = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
<script>
    const Toast = Swal.mixin({
        toast: false,
        position: 'center',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
    });
</script>
<?php if (@$_GET['durum'] == "basarili") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'success',
            title: 'İşlem Başarılı.'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "giris") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'success',
            title: 'Başarıyla giriş yaptınız. Hoşgeldiniz!'
        });
    </script>
<?php } ?>
<?php if (@$_GET['status'] == "izinsizGiris") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'warning',
            title: 'Erişmeye çalıştığınız sayfaya giriş izniniz bulunmamaktadır.'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "profilGuncelleme") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'success',
            title: 'Profil başarıyla güncellendi.'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "sifreBasarili") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'success',
            title: 'Şifreniz başarıyla değiştirildi.'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "basarisiz") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'error',
            title: 'İşlem Başarısız'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "emailVar") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'warning',
            title: 'Bu e-posta adresi kullanımda'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "sifreUyusmuyor") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'error',
            title: 'İşlem Başarısız, Şifreler uyuşmuyor'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "girisBasarisiz") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Başarısız Giriş'
        });
    </script>
<?php } ?>
<?php if (@$_GET['durum'] == "gecersizIslem") { ?>
    <script>
        ToastTopEnd.fire({
            icon: 'error',
            title: 'Geçersiz bir işlem yapmaya çalışıyorsunuz'
        });
    </script>
    <?php } ?>