<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'autoIncrement' => true, 'precision' => null, 'comment' => null],
        'email' => ['type' => 'string', 'length' => 75, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'email' => 'user1@example.com',
            // password is 111111
            'password' => '$2y$10$0hoGWxcL.dC6WWrhCDQUVezLFlxMkguhXDziDi.yQSLjhoBaI9FDO'
        ],
        [
            'id' => 2,
            'email' => 'user2@example.com',
            // password is 111111
            'password' => '$2y$10$0hoGWxcL.dC6WWrhCDQUVezLFlxMkguhXDziDi.yQSLjhoBaI9FDO'
        ],
    ];
}
