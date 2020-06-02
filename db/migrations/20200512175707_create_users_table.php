<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('users')
            ->addColumn('name', 'string', ['null' => false, 'limit' => 70])
            ->addColumn('surname', 'string', ['null' => false, 'limit' => 70])
            ->addColumn('email', 'string', ['null' => false, 'limit' => 250])
            ->addColumn('password', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('email_verified_at', 'datetime', ['null' => true, 'default' => null])
            ->addTimestamps()
            ->addIndex('email', ['unique'=>true])
            ->create();
    }
}
