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
     * Register custom types in doctrine abstract platform
     *
     * @param PostgresConnection $connection
     */
    public function registerCustomDbTypes(PostgresConnection $connection)
    {
        $databasePlatform = $connection->getDoctrineSchemaManager()->getDatabasePlatform();

        foreach (config('pogoquent.custom_db_types') as $yourTypeName => $doctrineTypeName) {
            $databasePlatform->registerDoctrineTypeMapping($yourTypeName, $doctrineTypeName);
        }
    }

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
            $this->registerCustomDbTypes($pgConnection);

            return $pgConnection;
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/pogoquent.php' => config_path('pogoquent.php'),
        ], 'config');
    }
}
