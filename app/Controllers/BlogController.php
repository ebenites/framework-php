<?php
namespace Application\Controllers;

use Application\Models\Entities\Post;
use JasonGrimes\Paginator;

class BlogController {
    
    /**
     * @Inject
     * @var Application\Providers\View
     */
    protected $view;
    
    /**
     * @Inject
     * @var Application\Providers\Doctrine
     */
    protected $doctrine;
    
    public function index(?int $page = 1){
        $totalItems = $this->doctrine->em->getRepository(Post::class)->count([]);
        $itemsPerPage = 10;
		$page = ($page - 1) * $itemsPerPage;
		$urlPattern = '/blog/(:num)';
		
		$posts = $this->doctrine->em->getRepository(Post::class)->getPostsPaginated($page, $itemsPerPage);
// 		\Kint::dump($posts);

		$paginator = new Paginator($totalItems, $itemsPerPage, $page, $urlPattern);
		
        $this->view->render('blog.twig', compact('posts', 'paginator'));
    }
    
}