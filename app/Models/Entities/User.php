<?php
namespace Application\Models\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * */
    public $id;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="El nombre no puede estar vacío")
     * @Assert\Length(min="2", minMessage="El nombre debe tener al menos 2 caracteres")
     * */
    public $name;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="El correo electrónico no puede estar vacío")
     * @Assert\Email(message="El correo electrónico no es válido")
     * */
    public $email;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="El password no puede estar vacío")
     * @Assert\Length(min="6", minMessage="El password debe tener al menos 6 caracteres")
     * */
    public $password;
    
    /**
     * @ORM\Column(type="datetime")
     * */
    public $created_at;
    
    /**
     * @ORM\Column(type="datetime")
     * */
    public $updated_at;
    
    /**
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
	 */
	public $posts;
    
    public function __construct() {
        $this->created_at = new \Datetime('now');
        $this->posts = new ArrayCollection();
    }
    
}