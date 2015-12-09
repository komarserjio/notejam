<?php

namespace App\Model;

use Nette;


/**
 * Notes management.
 */
class NoteManager extends Nette\Object
{

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
		return $this->findAll()->where('id', $id)->fetch();
	}

	/**
	 * Finds all notes.
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->getTable()->where('user_id', $this->user->getId());
	}

	/**
	 * Finds notes in given pad.
	 * @param int $padId
	 * @return Nette\Database\Table\Selection
	 */
	public function findByPad($padId)
	{
		return $this->findAll()->where('pad_id', $padId);
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
		return $this->getTable()->insert([
			'name'       => $name,
			'text'       => $text,
			'pad_id'        => $padId,
			'user_id'       => $this->user->getId(),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
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
		return $this->getTable()->where([
			'id'   => $id,
			'user_id' => $this->user->getId(),
		])->update([
			'name'       => $name,
			'text'       => $text,
			'pad_id'        => $padId,
			'updated_at' => date('Y-m-d H:i:s'),
		]);
	}

	/**
	 * Deletes note with given id.
	 * @param int $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->getTable()->where([
			'id'   => $id,
			'user_id' => $this->user->getId(),
		])->delete();
	}

	/**
	 * @return Nette\Database\Table\Selection
	 */
	protected function getTable()
	{
		return $this->database->table('notes');
	}

}
