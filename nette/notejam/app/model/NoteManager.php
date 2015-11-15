<?php


namespace App\Model;

use Nette;


/**
 * Notes management.
 */
class NoteManager extends Nette\Object
{

	const
		TABLE_NAME = 'notes',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'name',
		COLUMN_TEXT = 'text',
		COLUMN_CREATED_AT = 'created_at',
		COLUMN_UPDATED_AT = 'updated_at',
		COLUMN_USER = 'user_id',
		COLUMN_PAD = 'pad_id';


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
	 * Finds note with given id.
	 * @param int $id
	 * @return bool|mixed|Nette\Database\Table\IRow
	 */
	public function find($id)
	{
		return $this->findAll()->where(self::COLUMN_ID, $id)->fetch();
	}

	/**
	 * Finds all notes.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_USER, $this->user->getId());
	}

	/**
	 * Finds notes in given pad.
	 * @param int $padId
	 * @return Nette\Database\Table\Selection
	 */
	public function findByPad($padId)
	{
		return $this->findAll()->where(self::COLUMN_PAD, $padId);
	}

	/**
	 * Adds new note.
	 * @param string $name
	 * @param string $text
	 * @param int    $padId
	 * @return bool|int|Nette\Database\Table\IRow
	 */
	public function add($name, $text, $padId)
	{
		return $this->database->table(self::TABLE_NAME)->insert([
			self::COLUMN_NAME       => $name,
			self::COLUMN_TEXT       => $text,
			self::COLUMN_PAD        => $padId,
			self::COLUMN_USER       => $this->user->getId(),
			self::COLUMN_CREATED_AT => date('Y-m-d H:i:s'),
			self::COLUMN_UPDATED_AT => date('Y-m-d H:i:s'),
		]);
	}

	/**
	 * Updates note with given id.
	 * @param int    $id
	 * @param string $name
	 * @param string $text
	 * @param int    $padId
	 * @return int
	 */
	public function update($id, $name, $text, $padId)
	{
		return $this->database->table(self::TABLE_NAME)->where([
			self::COLUMN_ID   => $id,
			self::COLUMN_USER => $this->user->getId(),
		])->update([
			self::COLUMN_NAME       => $name,
			self::COLUMN_TEXT       => $text,
			self::COLUMN_PAD        => $padId,
			self::COLUMN_UPDATED_AT => date('Y-m-d H:i:s'),
		]);
	}

	/**
	 * Deletes note with given id.
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
