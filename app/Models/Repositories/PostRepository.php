<?php
namespace Application\Models\Repositories;

use Application\Models\Entities\Post;
use Doctrine\ORM\EntityRepository;

/**
 * Extendiendo funcionalidades a nuestro EntityRepository para Post
 */
class PostRepository extends EntityRepository {

	protected $entity = Post::class;

	public function getPostsPaginated (int $offset = 0, int $limit = 10) {
		$dql = "SELECT p FROM {$this->entity} p ORDER BY p.id";
		$query = $this->_em->createQuery($dql)
			->setFirstResult( $offset)
			->setMaxResults( $limit);

		return $query->execute();
	}
}