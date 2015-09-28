<?php
use Phinx\Migration\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('notes');
        $table
            ->addColumn('pad_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'pad_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $table = $this->table('pads');
        $table
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $table = $this->table('users');
        $table
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 75,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => false,
            ])
            ->create();

        $this->table('notes')
            ->addForeignKey(
                'pad_id',
                'pads',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('pads')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

    }

    public function down()
    {
        $this->table('notes')
            ->dropForeignKey(
                'pad_id'
            )
            ->dropForeignKey(
                'user_id'
            )
            ->update();

        $this->table('pads')
            ->dropForeignKey(
                'user_id'
            )
            ->update();

        $this->dropTable('notes');
        $this->dropTable('pads');
        $this->dropTable('users');
    }
}
