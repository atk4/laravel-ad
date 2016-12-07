<?php


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

/**
 * Tests basic create, update and delete operatiotns.
 */
class CRUDTest extends \atk4\schema\PHPUnit_SchemaTestCase
{
    public function testUpdate()
    {
        $q = [
            'user' => [
                ['name' => 'Vinny', 'surname' => 'Shira'],
                ['name' => 'Zoe', 'surname' => 'Shatwell'],
            ],
        ];
        $this->setDB($q);

        $m = new User($this->db);

        $m->tryLoadAny();
        $m['name'] = 'Ken';
        $m->save();

        $m->load(2);
        $m['name'] = 'Brett';
        $m->save();
        $m['name'] = 'Doug';
        $m->save();

        // TODO - add asserts
    }

    public function testAddDelete()
    {
        $q = [
            'user' => [
                ['name' => 'Jason', 'surname' => 'Dyck'],
                ['name' => 'James', 'surname' => 'Knight'],
            ],
        ];
        $this->setDB($q);
        $zz = $this->getDB('user');

        $m = new User($this->db);

        //$m->getElement('surname')->default = 'Pen';

        //$m->save(['name'=>'Robert']);

        $m->loadBy('name', 'Jason'); //->delete();

        $this->assertEquals('Dyck', $m['surname']);
    }
}
