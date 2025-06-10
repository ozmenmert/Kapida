<?php
include "../ayar.php";

$sayfa_hizmet_id = 3;
redirectToUnauthorized($sayfa_hizmet_id, 'liste');

$pageName = 'Ürün - Promosyon Listesi';
$meta = array(
    'title' => $pageName . $separator . $siteData['title'],
    'description' => $siteData['description'],
    'keywords' => $siteData['keywords'],
    'author' => $siteData['author']
);
include 'header.php';
?>
<div class="page-wrapper">
    <div class="content container-fluid">

        <?php include '../share/promosyon-page-header.php'; ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <?= $pageName ?>
                        </h2>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th width="50">Ana Görsel</th>
                                    <th>Ürün Adı</th>
                                    <th>Promosyon Ekle/Çıkar</th>
                                    <th>Ürün Promosyonları</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $urun_promosyonIdleri = array();                                
                                $sql = "SELECT p.promosyon_id, p.promosyon_adi, u.urun_id FROM a_promosyonlar AS p
                                LEFT OUTER JOIN a_urunler_promosyonlar AS u_p ON u_p.promosyon_id = p.promosyon_id
                                LEFT OUTER JOIN a_urunler AS u ON u.urun_id = u_p.urun_id;";
                                $veriCek = $conn->prepare($sql);
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) {
                                    $urun_promosyonIdleri[$row['urun_id']][$row['promosyon_id']] = $row['promosyon_adi'];
                                }

                                $veriCek = $conn->prepare("SELECT * FROM a_urunler ORDER BY urun_id DESC");
                                $veriCek->execute();
                                while ($row = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td>
                                        <?= $row['urun_id'] ?>
                                    </td>
                                    <td><img src="../<?= $row['urun_img'] ?>" class="tableImg"></td>
                                    <td>
                                        <?= $row['urun_adi'] ?>
                                    </td>
                                    <td>
                                        <a href="urune-promosyon-ekle?id=<?=$row["urun_id"]?>" class="btn btn-success text-white btn-sm" title=" Ürüne Promosyon Ekle">
                                            <i class="fa fa-plus"></i> <i class="fa fa-minus"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="list-btn">
                                            <ul class="filter-list">
                                            <?php
                                                if(isset($urun_promosyonIdleri[$row['urun_id']])){
                                                    foreach($urun_promosyonIdleri[$row['urun_id']] as $key=>$data){
                                                        if($data!=""){?>
                                                            <li>
                                                                <a class="btn btn-info" href="promosyon-duzenle?id=<?=$key?>" title="promosyon-duzenle?id=<?=$key?>"><?=$data ?></a>
                                                            </li>
                                                        <?php }
                                                    }
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="sweetalert.min.js"></script>