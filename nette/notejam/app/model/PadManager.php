<?php


namespace App\Model;

use Nette;


/**
 * Pads management.
 */
class PadManager
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
	 * Finds all pads.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->database->table(self::TABLE_NAME);
	}

	/**
	 * Adds new pad.
	 * @param string $name
	 */
	public function add($name)
	{
		$this->database->table(self::TABLE_NAME)->insert([
			self::COLUMN_NAME => $name,
			self::COLUMN_USER => $this->user->getId(),
		]);
	}

	/**
	 * Updates pad with given id.
	 * @param int    $id
	 * @param string $name
	 */
	public function update($id, $name)
	{
		$this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->update([
			self::COLUMN_NAME => $name,
		]);
	}

	/**
	 * Deletes pad with given id.
	 * @param int $id
	 */
	public function delete($id)
	{
		$this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
