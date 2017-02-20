<?php

namespace Shanginn\Postgresql\Query;

class Builder extends \Illuminate\Database\Query\Builder
{
    /**
     * The database connection instance.
     *
     * @var Processors\PostgresProcessor;
     */
    public $processor;

    /**
     * The database connection instance.
     *
     * @var \Shanginn\Postgresql\PostgresConnection
     */
    public $connection;

    /**
     * @var Grammars\PostgresGrammar The database query grammar instance.
     */
    public $grammar;

    /**
     * Performs UPSERT statement against selected database
     *
     * @param array $values
     * @param string $unique
     *
     * @return bool
     */
    public function upsert(array $values, $unique)
    {
        if (empty($values)) {
            return true;
        }

        if (! is_array(reset($values))) {
            $values = [$values];
        } else {
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        $bindings = [];

        foreach ($values as $record) {
            foreach ($record as $value) {
                $bindings[] = $value;
            }
        }

        $sql = $this->grammar->compileUpsert($this, $values, $unique);
        $bindings = $this->cleanBindings($bindings);

        // we can use insert since upsert is customized insert
        return $this->connection->insert($sql, $bindings);
    }

    /**
     * Add a "group by" clause with "grouping sets" to the query.
     *
     * @param array ...$args
     * @return $this
     */
    public function groupByGroupingSets(...$args)
    {
        $expr = $this->grammar->compileGroupingSets($args);
        $this->groups[] = $this->connection->raw($expr);
        return $this;
    }

    /**
     * Add a "group by" clause with "rollup" to the query.
     *
     * @param array ...$args
     * @return $this
     */
    public function groupByRollup(...$args)
    {
        $expr = $this->grammar->compileRollup($args);
        $this->groups[] = $this->connection->raw($expr);
        return $this;
    }

    /**
     * Add a "group by" clause with "cube" to the query.
     *
     * @param array ...$args
     * @return $this
     */
    public function groupByCube(...$args)
    {
        $expr = $this->grammar->compileCube($args);
        $this->groups[] = $this->connection->raw($expr);
        return $this;
    }
}