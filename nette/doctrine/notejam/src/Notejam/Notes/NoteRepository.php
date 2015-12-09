<?php

namespace Notejam\Notes;

use Kdyby\Doctrine\EntityRepository;



/**
 * @method Note|NULL find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Note|NULL findOneBy(array $criteria, array $orderBy = NULL)
 */
class NoteRepository extends EntityRepository
{

	/**
	 * Returns the order by field
	 *
	 * @param string $orderBy
	 * @return array
	 */
	public function buildOrderBy($orderBy = NULL)
	{
		static $ordering = [
			'name' => array('name' => 'ASC'),
			'-name' => array('name' => 'DESC'),
			'updated_at' => array('updatedAt' => 'ASC'),
			'-updated_at' => array('updatedAt' => 'DESC')
		];

		return isset($ordering[$orderBy]) ? $ordering[$orderBy] : $ordering['name'];
	}

}
