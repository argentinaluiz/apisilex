<?php
//    Persistindo no banco
//
//    Utilizando os mesmos conceitos apresentados sobre a criação de novos serviços, 
//    crie um serviço que seja capaz de administrar uma simples table de produtos 
//    com o seguintes campos: (id, nome, descrição e valor).
//    Após a criação do serviço, faça o registro do mesmo no container 
//    de serviço do Silex.


require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//$app = new Silex\Application();
//$app['debug'] = true;
    

// /////////////////////////////////////////////////////////////////////////////////////////
// DEFINIDO SERVICO REPOSITORIO
// /////////////////////////////////////////////////////////////////////////////////////////
$app['produtos.repository'] = $app->share(function() use($em){
    return $em->getRepository('\SON\Entity\Produtos');
});


// /////////////////////////////////////////////////////////////////////////////////////////
// LISTAGEM
// /////////////////////////////////////////////////////////////////////////////////////////
$app->get('/produtos/list', function(Request $request) use ($em, $app) {    
     
    $repository = $app['produtos.repository'];
    $meusProdutos = $repository->findAll();
  
    $array_produtos = array();
    
    foreach ($meusProdutos as $produtos) {
        
        $res = array ('id' => $produtos->getId(), 'nome' => $produtos->getNome(), 'descricao' => $produtos->getDescricao(), 'valor' => $produtos->getValor() );
        
        array_push($array_produtos, $res);
    }

    return $app['twig']->render('listagem.twig', array ('lista' => $array_produtos)  );
   
})
->bind('listar');

// /////////////////////////////////////////////////////////////////////////////////////////
// FORM INSERIR NOVO PRODUTO
// /////////////////////////////////////////////////////////////////////////////////////////
$app->get('/produtos/insert', function() use ($app) {

    return $app['twig']->render('cadastro.twig', array());
    
})->bind('inserir');

// /////////////////////////////////////////////////////////////////////////////////////////
// SALVAR NOVO PRODUTO
// /////////////////////////////////////////////////////////////////////////////////////////
$app->post('/produtos/save', function(Silex\Application $app, Request $request) use($em) {

    $data = $request->request->all();
    $produtos = new \SON\Entity\Produtos();
    $produtos->setNome($data['nome']);
    $produtos->setDescricao($data['descricao']);
    $produtos->setValor($data['valor']);
    
    $em->persist($produtos);
    $em->flush();

    if ($produtos->getId()) {
        return $app->redirect($app['url_generator']->generate('sucesso'));
    } else {
        $app->abort(500, 'Erro de processamento');
    }
})
->bind('novo');

// /////////////////////////////////////////////////////////////
// LISTA 1 PRODUTO
// /////////////////////////////////////////////////////////////

$app->get('/produtos/{id}', function(Request $request, $id) use ($em, $app) {
    
    $produtos   = $em->find('\SON\Entity\Produtos', $id);
    $nome       = $produtos->getNome();
    $descricao  = $produtos->getDescricao();
    $valor      = $produtos->getValor();
    
    return $app['twig']->render('lista_um.twig', array ('id'=> $id, 'nome' => $nome , 'descricao' => $descricao, 'valor' => $valor ));
    
})
->bind('listar_unico');

// /////////////////////////////////////////////////////////////////////////////////////////
// GET /produtos/edit/{id} - para abrir o formulário de edição de produtos
// /////////////////////////////////////////////////////////////////////////////////////////
$app->get('/produtos/edit/{id}', function(Request $request, $id) use ($em, $app) {
    
    $produtos   = $em->find('\SON\Entity\Produtos', $id);
    $nome       = $produtos->getNome();
    $descricao  = $produtos->getDescricao();
    $valor      = $produtos->getValor();
    
    return $app['twig']->render('editar.twig', array ('id'=> $id, 'nome' => $nome , 'descricao' => $descricao, 'valor' => $valor ));
    
})
->bind('editar');

// /////////////////////////////////////////////////////////////////////////////////////////
// POST /produtos/update/{id} - para atualizar um produto
// /////////////////////////////////////////////////////////////////////////////////////////
$app->post('/produtos/update/{id}', function(Silex\Application $app, Request $request, $id) use($em) {
    
    $data = $request->request->all();
   
    $produtos = $em->find('\SON\Entity\Produtos', $id);
    
    if (!$produtos) {
        throw $this->createNotFoundException(
            'No products found for id '.$produtos
        );
    }    
   
    $produtos->setNome($data['nome']);
    $produtos->setDescricao($data['descricao']);
    $produtos->setValor($data['valor']);
    
    $em->flush();

    return $app->redirect($app['url_generator']->generate('sucesso'));
    
})
->bind('atualizar');


// /////////////////////////////////////////////////////////////////////////////////////////
// GET /produtos/delete/{id} - para excluir o produto
// /////////////////////////////////////////////////////////////////////////////////////////
$app->get('/produtos/delete/{id}', function(Silex\Application $app, Request $request, $id) use($em) {
    
    $data = $request->request->all();
   
    $produtos = $em->find('\SON\Entity\Produtos', $id);
    
    if (!$produtos) {
        throw $this->createNotFoundException(
            'No products found for id '.$produtos
        );
    }     

    $em->remove($produtos);
    $em->flush();    
    
    return $app->redirect($app['url_generator']->generate('sucesso'));
    
})
->bind('apagar');

// /////////////////////////////////////////////////////////////////////////////////////////
// MENSAGEM DE SUCESSO
// /////////////////////////////////////////////////////////////////////////////////////////
$app->get('/sucesso', function() use ($app) {
    return $app['twig']->render('sucesso.twig', array());
})
->bind('sucesso');



$app->run();
