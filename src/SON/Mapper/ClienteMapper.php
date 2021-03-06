<?php

namespace SON\Mapper;

use SON\Entity\Cliente;
use Doctrine\ORM\EntityManager;


//use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\Role\Role;

class ClienteMapper {
    
    public function __construct(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }    
    
    private $em;
    
    private $dados = [
        
        0 => [
            'id'        => 0,
            'nome'      => 'Cliente XPTO',
            'email'     => 'clientexpto@gmail.com'
        ],
        
        1 => [
            'id'        => 1,
            'nome'      => 'Cliente Y',
            'email'     => 'clientey@gmail.com'
        ],
    ];


    
    public function insert(Cliente $cliente) {
        
        $this->em->persist($cliente);
        $this->em->flush();
        
        return [
            'success' => true
        ];
    }
            
    public function update($id, array $array) {
        
        return [
            'success' => true
        ];
    }          
    
    public function find($id) {
        
        return $this->dados[$id];
    }   

    public function fetchAll() {
        
        $dados = $this->dados;
        return $dados;
        
    }       

    
}
