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
        $this->assertInternalType('string', $this->user->backendable);
        $this->assertContains('@', $this->user->email);
        $this->assertRegExp('/[a-z0-9]+/', $this->user->downcase);
        // assertCount
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

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
