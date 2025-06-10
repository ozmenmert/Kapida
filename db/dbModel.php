<?php
class MainModel extends Config
{
    public function fetchAll($query, array $params=[])
    {
        $sth = $this->baglan->prepare($query);
        $sth->execute($params);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($query, array $params=[])
    {
        $sth = $this->baglan->prepare($query);
        $sth->execute($params);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($tablo, $form){
        try{
            $yer = implode(', ',array_fill(0,count($form), '?'));
            $sutun = implode(",",array_keys($form));
            $stmt = $this->baglan->prepare("INSERT INTO $tablo ($sutun) VALUES ($yer)");
            $stmt->execute(array_values($form));
            return $this->baglan->lastInsertId();
        }catch(Exception $e){
            return "<b>Kayıt Yapılmadı: </b>".$e->getMessage();
        }
    }

    public function delete($tablo, $where){
        try{
            $whereList = implode(' = ? AND ', array_keys($where)).' = ? ';
            $stmt = $this->baglan->prepare("DELETE FROM $tablo WHERE ".$whereList);
            $stmt->execute(array_values($where));
            return $stmt->rowCount();
        }catch(Exception $e){
            return "<b>Silme İşlemi Yapılmadı: </b>".$e->getMessage();
        }
    }

    public function deleteAll($tablo){
        try{
            $stmt = $this->baglan->prepare("DELETE FROM $tablo;");
            $stmt->execute();
            return $stmt->rowCount();
        }catch(Exception $e){
            return "<b>Silme İşlemi Yapılmadı: </b>".$e->getMessage();
        }
    }

    public function update($tablo, $form, $where){
        try{
            $sutun = implode(' = ?, ', array_keys($form)).' = ? ';
            $whereList = implode(' = ? AND ', array_keys($where)).' = ? ';
            $sql = "UPDATE $tablo SET $sutun WHERE ".$whereList;
            $stmt = $this->baglan->prepare($sql);
            $form = array_merge($form,$where);
            $stmt->execute(array_values($form));
            return $stmt->rowCount();
        }catch(Exception $e){
            return "<b>Güncelleme Yapılmadı: </b>".$e->getMessage();
        }
    }

    public function callProcedure($sql){
        try{
            $stmt = $this->baglan->prepare($sql);
            $stmt->execute();
            /*$stmt->closeCursor();*/
            return true;
        }catch(Exception $e){
            return "<b>Error: </b>".$e->getMessage();
        }
    }
}