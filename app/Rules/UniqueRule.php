<?php


namespace App\Rules;


use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    protected $fillableParams = ['table', 'column'];

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);
        $table = $this->parameter('table');
        $column = $this->parameter('column');

        return !$this->databaseManager->table($table)
            ->where($column, '=', $value)
            ->exists();
    }
}