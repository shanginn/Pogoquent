<?php

namespace Shanginn\Postgresql;

use Shanginn\Postgresql\Schema\Blueprint;
use Shanginn\Postgresql\Schema\PostgresBuilder;
use Shanginn\Postgresql\Query\Builder as QueryBuilder;

class PostgresConnection extends \Illuminate\Database\PostgresConnection
{
    /**
     * Override Illuminate's default schema builder instance with ours.
     *
     * @return \Shanginn\Postgresql\Schema\PostgresBuilder
     */
    public function getSchemaBuilder()
    {
        $builder = new PostgresBuilder($this);
        $builder->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });

        return $builder;
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Shanginn\Postgresql\Query\Builder
     */
    public function query()
    {
        return new QueryBuilder($this, $this->getQueryGrammar(), $this->getPostProcessor());
    }
}
