<?php

require_once(File::build_path(array('model','ModelPanier.php')));
require_once(File::build_path(array('model','ModelProduit.php')));
require_once(File::build_path(array('model','ModelUtilisateur.php')));

class ControllerPanier{

    public static function addPanier(){
        if (!isset($_SESSION['login'])){
            session_start();
        }
        ModelPanier::insertPanier(ModelUtilisateur::getIdUti($_SESSION['login']),$_POST['id_produit'],$_POST['quantite']);
        $tab = ModelPanier::getPanier(ModelUtilisateur::getIdUti($_SESSION['login']));
        setcookie("panier",$tab['quantiteProduit'],time()+time()+31570000);

        require_once (File::build_path(array('view','vueCommande')));
    }

    public static function displayPanier(){

        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['login'])){
            $idClient = ModelUtilisateur::getIdUti($_SESSION['login']);
            $tab = ModelPanier::getPanier($idClient);
            $tabClient = ModelUtilisateur::getInfoCommande($idClient);
        } else {
            $tab = [];
            $tabClient = [];
        }
        require_once (File::build_path(array('view','vueCommande.php')));
    }

    public static function deletePanier(){
        if (!isset($_SESSION['login'])){
            session_start();
        }
        if (isset($_SESSION['login'])){
            $idClient = ModelUtilisateur::getIdUti($_SESSION['login']);
            ModelPanier::deletePanier($idClient, $_POST['id_produit']);
            $tab = ModelPanier::getPanier($idClient);
            $tabClient = ModelUtilisateur::getInfoCommande($idClient);
        } else {
            $tab = [];
            $tabClient = [];
        }
        require_once (File::build_path(array('view','vueCommande.php')));
    }

}