<?php
namespace Application\Providers;

use Application\Utils\TwigFunctions;

class View {
    
    /**
     * @Inject
     * @var Application\Providers\Session
     */
    protected $session;
    
    private $twig;
    
    public function __construct() {
        $loader = new \Twig_Loader_Filesystem(base_path('app/Views'));
        $this->twig = new \Twig_Environment($loader);
        
        $this->initTwigFunctions();
    }
    
    private function initTwigFunctions() {
        // Globals vars
        $this->twig->addGlobal('session', $_SESSION);   // sesison.app.foo
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->twig->addGlobal('post', $_POST);
        $this->twig->addGlobal('get', $_GET);
        
        // Twig Functions
        $this->twig->addFunction(new \Twig_Function('url', function ($url, $withFullPath = false) {
    		return base_url($url, $withFullPath);
        }));
        
        $this->twig->addFunction(new \Twig_Function('flash', function ($type) {
    		$flash = $this->session->getFlash($type);
    		if($flash){
    		    return sprintf('<div class="alert alert-%s">%s</div>', $type, nl2br($flash));
    		}
    		return null;
        }, ['is_safe' => ['html']]));
    }
    
    public function render(string $view, array $data = []) {
        echo $this->twig->render($view, $data);
        exit;
    }
    
    public function redirect(string $url) {
		header('Location: ' . base_url($url));
		exit;
	}
    
}