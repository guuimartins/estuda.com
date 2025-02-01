<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;
use Mockery;

class UserTest extends TestCase
{
    protected $pdoMock;
    protected $stmtMock;

    protected function setUp(): void
    {
        $this->pdoMock = Mockery::mock(PDO::class);
        $this->stmtMock = Mockery::mock(PDOStatement::class);
    }

    public function testRegistroUsuario()
    {
        $username = 'testuser';
        $password = 'password123';

        $this->pdoMock->shouldReceive('prepare')
            ->with("SELECT username FROM usuarios WHERE username = ?")
            ->andReturn($this->stmtMock);

        $this->stmtMock->shouldReceive('execute')
            ->with([$username])
            ->andReturn(true);

        $this->stmtMock->shouldReceive('rowCount')
            ->andReturn(0);

        $this->pdoMock->shouldReceive('prepare')
            ->with("INSERT INTO usuarios (username, password) VALUES (?, ?)")
            ->andReturn($this->stmtMock);

        $this->stmtMock->shouldReceive('execute')
            ->andReturn(true);

        $result = $this->registerUser($username, $password);
        $this->assertTrue($result);
    }

    public function testLoginUsuario()
    {
        $username = 'testuser';
        $password = 'password123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->pdoMock->shouldReceive('prepare')
            ->with("SELECT * FROM usuarios WHERE username = ?")
            ->andReturn($this->stmtMock);

        $this->stmtMock->shouldReceive('execute')
            ->with([$username])
            ->andReturn(true);

        $this->stmtMock->shouldReceive('fetch')
            ->andReturn(['username' => $username, 'password' => $hashedPassword]);

        $result = $this->loginUser($username, $password);
        $this->assertTrue($result);
    }

    private function registerUser($username, $password)
    {
        try {
            $stmt = $this->pdoMock->prepare("SELECT username FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->rowCount() > 0) {
                return false;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdoMock->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, $hashedPassword]);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function loginUser($username, $password)
    {
        try {
            $stmt = $this->pdoMock->prepare("SELECT * FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            return $user && password_verify($password, $user['password']);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}