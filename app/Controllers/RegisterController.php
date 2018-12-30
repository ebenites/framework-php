<?php
namespace Application\Controllers;

use Symfony\Component\Validator\Validation;
use Exception;
use Application\Models\Entities\User;

class RegisterController {
    
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
    
    public function register() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            try {
                $email = $_POST['email'];
                $name = $_POST['name'];
                $password = $_POST['password'];
                
                $user = $this->doctrine->em->getRepository(User::class)->findOneBy(['email' => $email]);
                
                if($user){
                    throw new Exception('El correo electrónico ya se encuentra en uso.');
                }
                
                $user = new User();
                $user->email = $email;
                $user->name = $name;
                $user->password = $password;
                
                $validator = Validation::createValidatorBuilder()
                    ->enableAnnotationMapping()
                    ->getValidator();
                    
                $errors = $validator->validate($user);
                
                // Symfony\Component\Validator\ConstraintViolationListviolations to array messages
                $errors = array_map(function($e) { return $e->getMessage(); }, iterator_to_array($errors));
                
                if(!empty($errors)){
                    throw new Exception(join("\n", $errors));
                }
                
                $user->password = password_hash($password, PASSWORD_BCRYPT);
                
                $this->doctrine->em->persist($user);
                $this->doctrine->em->flush();
                
                $this->session->setFlash('success', 'Registro satisfactorio! Ya puedes acceder.');
                $this->view->redirect('login');
                
            } catch (Exception $exception) {
                $this->session->setFlashNow('danger', $exception->getMessage());
            }
            
        }
        
        $this->view->render('register.twig');
    }
    
}