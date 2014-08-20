<?php

class TextTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        DB::beginTransaction();
    }

    public function testTextable()
    {
        $text = App::make('Text');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphTo', $text->textable());
    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
