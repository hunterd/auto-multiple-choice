<?php
namespace WpAmc\Tests;
require_once __DIR__ . "/../app/Models/Project.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    protected function setUp(): void
    {
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $capsule->schema()->create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path');
        });
    }

    protected function tearDown(): void
    {
        Capsule::schema()->drop('projects');
    }

    public function testCreateAndRetrieveProject()
    {
        $project = Project::create(['name' => 'Demo', 'path' => '/tmp/demo']);
        $this->assertEquals(1, Project::count());

        $found = Project::first();
        $this->assertEquals($project->id, $found->id);
        $this->assertEquals('Demo', $found->name);
        $this->assertEquals('/tmp/demo', $found->path);
    }
}
