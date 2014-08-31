<?php

class SessionControllerTest extends TestCase {

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->migrateAndSeed();
        $this->user = User::first();
        DB::beginTransaction();
    }

    public function testSessionCreated()
    {
        Auth::shouldReceive('check')->once()->andReturn(true);

        $this->call('GET', 'login');
        $this->assertRedirectedToRoute('home');
    }

    public function testSessionCreate()
    {
        $this->call('GET', 'login');
        $this->assertViewHas('title');
        $this->assertResponseOk();
    }

    public function testSessionStoreFailed()
    {
        // Auth::shouldReceive('attempt')->once()->andReturn(false);

        // $this->call('POST', 'session/store');
        // $this->assertSessionHas('message');
        // $this->assertRedirectedTo('login');
    }

    public function testSessionCreateSuccessfully()
    {
        // Auth::shouldReceive('attempt')->once()->andReturn(true);
        // Auth::shouldReceive('user')->once()->andReturn($this->user);

        // Event::shouldReceive('fire')->once()->andReturn(true);

        // $this->call('POST', 'session/store');
        // $this->assertRedirectedTo('home');
    }

    public function testSessionDestroy()
    {
        $this->call('DELETE', 'logout');
        $this->assertRedirectedToRoute('home');
    }

    public function testLogout()
    {
        $this->call('GET', 'logout');
        $this->assertViewHas('title');
        $this->assertResponseOk();
    }

    public function tearDown()
    {
        DB::rollback();
        Mockery::close();
    }
}
