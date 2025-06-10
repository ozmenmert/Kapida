<?php
include('dbConfig.php');
include('dbModel.php');

function getAll($table){
    return (new MainModel())->fetchAll("SELECT * FROM $table");
}

function getOneAll($table){
    return (new MainModel())->fetch("SELECT * FROM $table");
}

function getId($table, $idName, $id){
    return (new MainModel())->fetchAll("SELECT * FROM $table WHERE ".$idName." = $id");
}

function getOneId($table, $idName, $id){
    return (new MainModel())->fetch("SELECT * FROM $table WHERE ".$idName." = $id");
}

function getOneSql($sql){
    return (new MainModel())->fetch($sql);
}

function getSql($sql){
    return (new MainModel())->fetchAll($sql);
}

function insert($table,$form){
    return (new MainModel())->insert($table,$form);
}

function update($table,$form,$where){
    return (new MainModel())->update($table,$form,$where);
}

function delete($table,$where){
    return (new MainModel())->delete($table,$where);
}
?>