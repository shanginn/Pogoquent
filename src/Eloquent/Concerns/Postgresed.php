<?php

namespace Shanginn\Postgresql\Eloquent\Concerns;

use Shanginn\Postgresql\Query\Builder;

trait Postgresed
{
    /**
     * {@inheritdoc}
     *
     * @return Builder
     */
    protected function newBaseQueryBuilder()
    {
        /** @var \Illuminate\Database\Connection $connection */
        $connection = $this->getConnection();

        return new Builder(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor()
        );
    }
}