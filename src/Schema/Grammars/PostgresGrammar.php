<?php

namespace Shanginn\Postgresql\Schema\Grammars;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Blueprint;

class PostgresGrammar extends \Illuminate\Database\Schema\Grammars\PostgresGrammar
{
    use PostgresGrammarTypes;
    use PostgresGrammarEnums;

    /**
     * @var array Index methods supported by PostgreSQL
     */
    protected $indexTypes = ['btree', 'hash', 'gin', 'gist', 'spgist', 'brin'];

    /**
     * Check if this Grammar supports given index type
     *
     * @param string $indexType
     * @return bool
     */
    public function isSupportedIndexType(string $indexType)
    {
        return in_array($indexType, $this->indexTypes);
    }

    /**
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @return string
     */
    public function compileIndex(Blueprint $blueprint, Fluent $command)
    {
        $columns = $this->columnize($command->columns);
        $index = $this->wrap($command->index);

        // Check for any supported method and use it or default btree method
        $method = $this->isSupportedIndexType($command->algorithm) ? $command->algorithm : 'btree';

        return join(" ", array_filter([
            "create index", $command->concurrently, $index,          // CREATE INDEX [CONCURRENTLY] name
            "on", $this->wrapTable($blueprint),                      // ON table
            "using", $method,                                        // USING method
            "({$columns})"                                           // columns
        ]));
    }

    /**
     * Compile the query to determine the list of columns.
     *
     * @param  string $table
     * @param  bool $withTypes
     * @return string
     */
    public function compileColumnListing($table, $withTypes = false)
    {
        $columns = 'column_name' . ($withTypes ? ',data_type' : '');
        return "select {$columns} from information_schema.columns where table_name = '$table'";
    }
}
