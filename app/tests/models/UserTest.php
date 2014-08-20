<?php

class UserTest extends TestCase {

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        $this->user = User::first();
        DB::beginTransaction();
    }

    public function testUserModel()
    {
        $this->assertInstanceOf('User', $this->user);
        $this->assertInternalType('string', $this->user->username);
        $this->assertContains('@', $this->user->email);
        $this->assertRegExp('/[a-z0-9]+/', $this->user->downcase);
        $this->assertCount(1, User::all());
    }

    public function testNormalUser()
    {
        $this->assertTrue($this->user->normalUser());
    }

    public function testProfile()
    {
        $this->assertInstanceOf('Profile', $this->user->profile);
    }

    public function testStat()
    {
        $this->assertInstanceOf('Stat', $this->user->stat);
    }

    public function testTopics()
    {
        $this->assertInstanceOf('Topic', $this->user->topics->first());
    }

    public function testFollowers()
    {

    }

    public function testFollowing()
    {

    }

    public function testReplies()
    {

    }

    public function testLiking()
    {

    }

    public function testEvents()
    {

    }

    public function testPhotos()
    {

    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
