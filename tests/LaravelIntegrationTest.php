<?php

namespace atk4\LaravelAD\tests;

use atk4\data\Persistence;
use atk4\dsql\Query;
use atk4\LaravelAD\AgileDataServiceProvider;
use atk4\schema\Migration;
use Orchestra\Testbench\TestCase;

class User extends \atk4\data\Model
{
    public $table = 'user';

    public function init()
    {
        parent::init();

        $this->addField('name');
        $this->addField('surname');
    }
}

class LaravelIntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AgileDataServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('agiledata.connection', 'default');
    }

    public function testDILoaded()
    {
        $db = $this->app->make('agiledata');

        $this->assertInstanceOf(Persistence::class, $db);
    }

    public function testDIAliasLoaded()
    {
        $db = $this->app->make(Persistence::class);

        $this->assertInstanceOf(Persistence::class, $db);
    }

    public function testPersistenceSanityCheck()
    {
        $db = $this->app->make('agiledata');

        $q = [
            'user' => [
                ['name' => 'Vinny', 'surname' => 'Shira'],
                ['name' => 'Zoe', 'surname' => 'Shatwell'],
            ],
        ];

        $this->setDB($q, $db);

        $m = new User($db);

        $m->set(['name' => 'John', 'surname' => 'Smith']);
        $m->save();

        $m->load(3);
        $user = $m->get();
        $this->assertEquals('John', $user['name']);
    }

    protected function setDB($db_data, $db)
    {
        $this->tables = array_keys($db_data);

        // create databases
        foreach ($db_data as $table => $data) {
            $s = new Migration(['connection' => $db->connection]);
            $s->table($table)->drop();

            $first_row = current($data);

            foreach ($first_row as $field => $row) {
                if ($field === 'id') {
                    $s->id('id');
                    continue;
                }

                if (is_int($row)) {
                    $s->field($field, ['type' => 'integer']);
                    continue;
                }

                $s->field($field);
            }

            if (!isset($first_row['id'])) {
                $s->id();
            }

            $s->create();

            $has_id = (bool) key($data);

            foreach ($data as $id => $row) {
                $s = new Query(['connection' => $db->connection]);
                if ($id === '_') {
                    continue;
                }

                $s->table($table);
                $s->set($row);

                if (!isset($row['id']) && $has_id) {
                    $s->set('id', $id);
                }

                $s->insert();
            }
        }
    }
}
