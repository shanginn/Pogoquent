<?php

namespace Shanginn\Postgresql\Schema;

class PostgresBuilder extends \Illuminate\Database\Schema\PostgresBuilder
{
    /**
     * The database connection instance.
     *
     * @var \Shanginn\Postgresql\PostgresConnection
     */
    protected $connection;

    /**
     * The schema grammar instance.
     *
     * @var Grammars\PostgresGrammar
     */
    protected $grammar;

    /** @var bool
     * Build indexes without taking any locks that prevent
     * concurrent inserts, updates, or deletes on the table
     *
     * @link https://www.postgresql.org/docs/9.5/static/sql-createindex.html#SQL-CREATEINDEX-CONCURRENTLY
     */
    public static $indexesConcurrently = false;

    /**
     * Set the default index creating behavior for migrations.
     *
     * @param  bool  $status
     * @return void
     */
    public static function buildIndexesConcurrently(bool $status)
    {
        static::$indexesConcurrently = $status;
    }

    public function createEnum(string $name, array $options)
    {
        return $this->connection->insert(
            $this->grammar->compileCreateEnum($name, $options)
        );
    }

    public function getEnum(string $name)
    {
        return json_decode($this->connection->selectOne(
            $this->grammar->compileGetEnum($name)
        )->json);
    }
}
