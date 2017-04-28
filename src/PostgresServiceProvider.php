<?php

namespace Shanginn\Postgresql;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Shanginn\Postgresql\Query\Grammars\PostgresGrammar as QueryGrammar;
use Shanginn\Postgresql\Schema\Grammars\PostgresGrammar as SchemaGrammar;
use Shanginn\Postgresql\Query\Processors\PostgresProcessor as PostProcessor;

class PostgresServiceProvider extends ServiceProvider
{
    protected $customDbTypes = [
        'event_format'    => 'text',
        'event_audience'  => 'text',
        'language_level'  => 'text',
        'age_category'    => 'text',
        'reservation'     => 'text',
        'adult_presence'  => 'text',
        'price_per'       => 'text',
        'payment_method'  => 'text',
        'scheduling_type' => 'text',
        'event_status'    => 'text'
    ];

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

    public function registerCustomDbTypes(PostgresConnection $connection)
    {
        $schema = $connection->getDoctrineSchemaManager();
        $databasePlatform = $schema->getDatabasePlatform();

        foreach ($this->customDbTypes as $yourTypeName => $doctrineTypeName) {
            $databasePlatform->registerDoctrineTypeMapping($yourTypeName, $doctrineTypeName);
        }
    }
}
