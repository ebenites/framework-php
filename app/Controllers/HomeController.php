<?php
namespace Application\Controllers;

use Application\Models\Entities\User;

class HomeController {
    
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
    
    public function index(){
        $this->view->render('home.twig');
    }
    
}