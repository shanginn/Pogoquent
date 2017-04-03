<?php

namespace Shanginn\Postgresql\Eloquent\Concerns;

use Shanginn\Postgresql\Query\Builder as QueryBuilder;
use Shanginn\Postgresql\Eloquent\Builder;

trait Postgresed
{
    /**
     * {@inheritdoc}
     *
     * @return QueryBuilder
     */
    protected function newBaseQueryBuilder()
    {
        /** @var \Illuminate\Database\Connection $connection */
        $connection = $this->getConnection();

        return new QueryBuilder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return \Shanginn\Postgresql\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}