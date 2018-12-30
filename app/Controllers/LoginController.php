<?php
namespace Application\Controllers;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Application\Models\Entities\User;

class LoginController {
    
    /**
     * @Inject
     * @var Application\Providers\View
     */
    protected $view;
    
    /**
     * @Inject
     * @var Application\Providers\Session
     */
    protected $session;
    
    /**
     * @Inject
     * @var Application\Providers\Doctrine
     */
    protected $doctrine;
    
    public function login() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            try {
                v::key('email', v::email())->key('password', v::length(6, 20))->assert($_POST); 
                
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $user = $this->doctrine->em->getRepository(User::class)->findOneBy(['email' => $email]);
                
                if($user){
                    if(password_verify($password, $user->password)){
                        $this->session->setUser($user);
                        $this->session->setFlash('success', 'Bienvenido ' . $user->name);
                        $this->view->redirect('/');
                    }
                }
                
                $this->session->setFlashNow('danger', 'Usuario y/o clave incorrectos');
                
            } catch (NestedValidationException $exception) {
                $errors = join("\n", array_filter($exception->findMessages([
			        'email' => 'El formato del campo {{name}} no es un email válido.',
                    'length' => 'El {{name}} debe tener entre {{minValue}} y {{maxValue}} caracteres.',
                ])));
                $this->session->setFlashNow('danger', $errors);
            }
            
        }
        
        $this->view->render('login.twig');
    }
    
    public function logout () {
		$this->session->clear();
		$this->session->setFlash('success', 'Su sesión he sido finalizada');
		$this->view->redirect('login');
	}
    
}