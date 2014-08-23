<?php

class TopicTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        $this->topic = Topic::first();
        DB::beginTransaction();
    }

    public function testUser()
    {
        $this->assertInstanceOf('User', $this->topic->user);
    }

    public function testCategory()
    {
        $this->assertInstanceOf('Category', $this->topic->category);
    }

    public function testReplies()
    {
        $this->assertInstanceOf('Reply', $this->topic->replies->first());
    }

    public function testText()
    {
        $this->assertInstanceOf('Text', $this->topic->text);
    }

    public function testLikers()
    {

    }

    public function testTags()
    {

    }

    public function testWatchers()
    {

    }

    public function testCreatedAt()
    {
        // $this->topic->createdAt();
    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
