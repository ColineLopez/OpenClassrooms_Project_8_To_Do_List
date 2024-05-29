<?php
namespace App\Tests\Entity;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetId()
    {
        $user = new user();
        $this->assertNull($user->getId());
    }

    public function testEmail()
    {
        $user = new User();
        $email = 'test@example.com';

        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($email, $user->getUserIdentifier());
    }

    public function testRoles()
    {
        $user = new User();
        $this->assertSame(['ROLE_USER'], $user->getRoles());

        $roles = ['ROLE_ADMIN'];
        $user->setRoles($roles);
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testPassword()
    {
        $user = new User();
        $password = 'password';
        
        $user->setPassword($password);
        $this->assertSame($password, $user->getPassword());
    }

    public function testUsername()
    {
        $user = new User();
        $username = 'Test username';

        $user->setUsername($username);
        $this->assertSame($username, $user->getUsername());

    }

    public function testEraseCredentials()
    {
        $user = new User();
        $user->eraseCredentials();
        $this->assertTrue(true);
    }

    public function testTaskCollection()
    {
        $user = new User();
        $this->assertInstanceOf(Collection::class, $user->getTask());
        $this->assertCount(0, $user->getTask());

        $task = new Task();
        $user->addTask($task);
        $this->assertCount(1, $user->getTask());
        $this->assertTrue($user->getTask()->contains($task));

        $user->removeTask($task);
        $this->assertCount(0, $user->getTask());
        $this->assertFalse($user->getTask()->contains($task));
    }

    public function testAddAndRemoveTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertTrue($user->getTask()->contains($task));
        $this->assertSame($user, $task->getUser());

        $user->removeTask($task);
        $this->assertFalse($user->getTask()->contains($task));
        $this->assertNull($task->getUser());
    }
    

}
