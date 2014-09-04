<?php

use Illuminate\Support\Collection;

class TopicControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        DB::beginTransaction();
    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }

    /**
     * Testing TopicController index()
     */

    public function testIndex()
    {
        $this->action('GET', 'TopicController@index');
        $this->assertViewHas('title');
        $this->assertViewHas('topics');
        $this->assertViewHas('categories');
    }

    /**
     * Testing TopicController create()
     */

    public function testCreate()
    {
        $this->action('GET', 'TopicController@create');
        $this->assertViewHas('title');
        $this->assertViewHas('categories');
    }

    /**
     * Testing TopicController show($id)
     */

    public function testShow()
    {
        $this->action('GET', 'TopicController@show', ['id'=>1]);
        $this->assertViewHas('title');
        $this->assertViewHas('topic');
        $this->assertViewHas('replies');
    }

    /**
     * Testing TopicController store()
     */

    public function testStoreFails()
    {
        Validator::shouldReceive('make')->once()->andReturn(Mockery::mock([
            'messages' => new Collection(['Mockery', 'Laravel']),
            'fails'    => true
        ]));

        $this->action('POST', 'TopicController@store');
        $this->assertRedirectedToRoute('topic.new');
    }

    public function testStoreSuccessfully()
    {
        // Validator::shouldReceive('make')->once()->andReturn(
        //     Mockery::mock(['fails'=>false])
        // );

        // $this->be(User::find(1));
        // $this->action('POST', 'TopicController@store');
    }
}
