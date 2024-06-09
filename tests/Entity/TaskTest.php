<?php
namespace App\Tests\Entity;
use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use DateTime;
use DateTimeInterface;

class TaskTest extends TestCase
{

    public function testGetId()
    {
        $task = new Task();
        $this->assertNull($task->getId());
    }

    public function testCreatedAt()
    {
        $task = new Task();
        $this->assertInstanceOf(DateTimeInterface::class, $task->getCreatedAt());

        $date = new DateTime();
        $task->setCreatedAt($date);
        $this->assertSame($date, $task->getCreatedAt());
    }

    public function testTitle()
    {
        $task = new Task();
        $title = 'Test Title';

        $task->setTitle($title);
        $this->assertSame($title, $task->getTitle());
    }

    public function testContent()
    {
        $task = new Task();
        $content = 'Test Content';

        $task->setContent($content);
        $this->assertSame($content, $task->getContent());

        $task->setContent(null);
        $this->assertNull($task->getContent());
    }

    public function testIsDone()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());

        $task->setDone(true);
        $this->assertTrue($task->isDone());

        $task->setDone(false);
        $this->assertFalse($task->isDone());
    }

    public function testToggle()
    {
        $task = new Task();

        $task->toggle(true);
        $this->assertTrue($task->isDone());

        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }

    public function testUser()
    {
        $task = new Task();
        $user = new User();

        $task->setUser($user);
        $this->assertSame($user, $task->getUser());
    }

    public function testGetUser()
    {
        $task = new Task();
        $user = new User();

        $task->setUser($user);
        $this->assertSame($user, $task->getUser());
    }

}
