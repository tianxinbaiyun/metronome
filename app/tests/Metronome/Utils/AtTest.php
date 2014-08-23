<?php namespace Metronome\Utils;

use DB;
use Mockery;
use TestCase;

class AtTest extends TestCase {

    protected $at;

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        $this->at = new At('@Suzy @ChoA @J-Min Hello, world.');
        DB::beginTransaction();
    }

    public function testMentions()
    {
        $this->assertEquals([], $this->at->mentions());
    }

    public function testContent()
    {
        $this->assertEquals('<a href="/Suzy">@Suzy</a> <a href="/ChoA">@ChoA</a> @J-Min Hello, world.', $this->at->content());
    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
