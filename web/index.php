<?php
//    Preparando o ambiente
//
//    O objetivo geral desse projeto será desenvolver uma API REST, utilizando inclusive banco de dados. 
//    Para isso será necessário termos uma estrutura básica necessária configurada para iniciarmos a 
//    criação das APIs.
//
//    Nessa fase do projeto, você instalará o Silex e criará 1 rotas principal, apenas para garantir 
//    que tudo está configurado e funcionando.
//
//    1)Rota: /clientes
//
//    Com a rota /clientes, faça a simulação da listagem de clientes com Nome, Email e CPF/CNPJ 
//    vindo de um array. O formato de exibição deve ser json.

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../vendor/autoload.php';

//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;
    
$app->get('/clientes', function(Silex\Application $app) use ($data) {

    $data = array (
        array ('nome' => 'Andrea', 'curso' => 'Silex', 'cpf'   => '13005023803'),
        array ('nome' => 'Reginaldo','curso' => 'ApiSilex','cpf'   => '12005023803'),
        array ('nome' => 'Felipe','curso' => 'Doctrine','cpf'   => '13044023803')
    );    
    
    return $app->json($data);
    
});

$app->run();




