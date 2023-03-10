<?php
session_start();
include("funcoes.php");
include("funcoes_csv.php");

/*$servidor ="localhost";
$usuario = "root";
$senha = "";
$banco = "basictest";*/

/*$servidor='54.207.211.112';
$usuario='developer';
$senha='dev@2023';
$banco='proturbo';*/

/*$servidor ="basictest.mysql.dbaas.com.br";
$usuario='basictest';
$senha='G8038375Gg@';
$banco = 'basictest';*/

$servidor ="sql888.main-hosting.eu";
$usuario='u273458796_gustavosantos';
$senha='@8038375Gg?';
$banco = 'u273458796_proturbo';

try{
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8",$usuario,$senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $erro){
    echo "Falha ao conectar.";
}

function limpaPost($dados){
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

function auth($tokenSessao){
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM users WHERE user_token=? LIMIT 1");
    $sql->execute(array($tokenSessao));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    //Se não encontrar o usuario
    if(!$usuario){
        return false;
    }else{
        return $usuario;
    }
}
function sessionVerif(){
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if (!$user){
        header('location: ./index.php');
    }
}
function sessionVerifAdmin(){
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if($user['user_level'] != "admin"){
        header('location: ./index.php');
    }
}
?>