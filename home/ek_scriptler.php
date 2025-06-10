<?php
if (isset($siteData['ek_script']) and $siteData['ek_script'] != '') {
    echo $siteData['ek_script'];
}
if (isset($data['urun_script']) and $data['urun_script'] != '') {
    echo $data['urun_script'];
}
if (isset($data['urun_css']) and $data['urun_css'] != '') {
    echo $data['urun_css'];
}