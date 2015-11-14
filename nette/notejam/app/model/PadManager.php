<?php


namespace App\Model;

use Nette;


/**
 * Pads management.
 */
class PadManager extends Nette\Object
{

	const
		TABLE_NAME = 'pads',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'name',
		COLUMN_USER = 'user_id';


	/** @var Nette\Database\Context */
	private $database;

	/** @var Nette\Security\User */
	private $user;

	/**
	 * NoteManager constructor.
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
		return $this->findAll()->where(self::COLUMN_ID, $id)->fetch();
	}

	/**
	 * Finds all pads.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_USER, $this->user->getId());
	}

	/**
	 * Adds new pad.
	 * @param string $name
	 * @return bool|int|Nette\Database\Table\IRow
	 */
	public function add($name)
	{
		return $this->database->table(self::TABLE_NAME)->insert([
			self::COLUMN_NAME => $name,
			self::COLUMN_USER => $this->user->getId(),
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
		return $this->database->table(self::TABLE_NAME)->where([
			self::COLUMN_ID   => $id,
			self::COLUMN_USER => $this->user->getId(),
		])->update([
			self::COLUMN_NAME => $name,
		]);
	}

	/**
	 * Deletes pad with given id.
	 * @param int $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->database->table(self::TABLE_NAME)->where([
			self::COLUMN_ID   => $id,
			self::COLUMN_USER => $this->user->getId(),
		])->delete();
	}

}
