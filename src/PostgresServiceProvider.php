<?php

namespace Shanginn\Postgresql;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Shanginn\Postgresql\Query\Grammars\PostgresGrammar as QueryGrammar;
use Shanginn\Postgresql\Schema\Grammars\PostgresGrammar as SchemaGrammar;
use Shanginn\Postgresql\Query\Processors\PostgresProcessor as PostProcessor;

class PostgresServiceProvider extends ServiceProvider
{
    /**
     * Register our pgsql connection.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('pgsql', function ($connection, $database, $prefix, $config) {
            $pgConnection = new PostgresConnection($connection, $database, $prefix, $config);
            $pgConnection->setSchemaGrammar(new SchemaGrammar);
            $pgConnection->setQueryGrammar(new QueryGrammar);
            $pgConnection->setPostProcessor(new PostProcessor);

            return $pgConnection;
        });
    }
}
