<?php


namespace App\Model;

use Nette;


/**
 * Notes management.
 */
class NoteManager
{

	const
		TABLE_NAME = 'users',
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
	 * Finds all notes.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->database->table(self::TABLE_NAME);
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
	 */
	public function add($name, $text, $padId)
	{
		$this->database->table(self::TABLE_NAME)->insert([
			self::COLUMN_NAME       => $name,
			self::COLUMN_TEXT       => $text,
			self::COLUMN_PAD        => $padId,
			self::COLUMN_USER       => $this->user->getId(),
			self::COLUMN_CREATED_AT => new \DateTime(),
			self::COLUMN_UPDATED_AT => new \DateTime(),
		]);
	}

	/**
	 * Updates note with given id.
	 * @param int    $id
	 * @param string $name
	 * @param string $text
	 * @param int    $padId
	 */
	public function update($id, $name, $text, $padId)
	{
		$this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->update([
			self::COLUMN_NAME       => $name,
			self::COLUMN_TEXT       => $text,
			self::COLUMN_PAD        => $padId,
			self::COLUMN_UPDATED_AT => new \DateTime(),
		]);
	}

	/**
	 * Deletes note with given id.
	 * @param int $id
	 */
	public function delete($id)
	{
		$this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
