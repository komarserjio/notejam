<?php

namespace App\Model;

use Nette;


/**
 * Pads management.
 */
class PadManager extends Nette\Object
{

	/** @var Nette\Database\Context */
	private $database;

	/** @var Nette\Security\User */
	private $user;

	/**
	 * PadManager constructor.
	 * @param Nette\Database\Context $database
	 * @param Nette\Security\User    $user
	 */
	public function __construct(Nette\Database\Context $database, Nette\Security\User $user)
	{
		$this->database = $database;
		$this->user = $user;
	}

	/**
	 * Finds pad with given id.
	 * @param int $id
	 * @return Nette\Database\Table\IRow|bool The pad or FALSE if not found.
	 */
	public function find($id)
	{
		return $this->findAll()->where('id', $id)->fetch();
	}

	/**
	 * Finds all pads.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->getTable()->where('user_id', $this->user->getId());
	}

	/**
	 * Adds new pad.
	 * @param string $name
	 * @return bool|int|Nette\Database\Table\IRow
	 */
	public function add($name)
	{
		return $this->getTable()->insert([
			'name'    => $name,
			'user_id' => $this->user->getId(),
		]);
	}

	/**
	 * Updates pad with given id.
	 * @param int    $id
	 * @param string $name
	 * @return int
	 */
	public function update($id, $name)
	{
		return $this->getTable()->where([
			'id'      => $id,
			'user_id' => $this->user->getId(),
		])->update([
			'name' => $name,
		]);
	}

	/**
	 * Deletes pad with given id.
	 * @param int $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->getTable()->where([
			'id'      => $id,
			'user_id' => $this->user->getId(),
		])->delete();
	}

	/**
	 * @return Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->database->table('pads');
	}

}
