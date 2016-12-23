<?php

namespace SON\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="clientes")
 */
class Cliente {



    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * 
     */
    
    private $id;
    
    private $nome;

    /**
     *     
     * @ORM\Column(type="string", length=255)     
     * 
     */
    
    private $email;

    /**
     * 
     * @return mixed
     */
    function getEmail() {
        return $this->email;
    }

    /**
     * 
     * @param mixed $email
     */
    
    
    function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    /**
     * 
     * @return mixed
     */    

    
    
    function getNome() {
        return $this->nome;
    }

    
    /**
     * 
     * @param mixed $nome
     */    
    
    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function getId() {
        return $this->id;
    }

    /**
     * 
     * @param mixed 
     */
    
    function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @return mixed 
     */    
    
    
    
}
