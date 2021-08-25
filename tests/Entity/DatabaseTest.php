<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Backup;
use App\Entity\Database;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function testId(): void
    {
        $entity = new Database();
        self::assertNull($entity->getId());
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, 9);
        self::assertSame(9, $entity->getId());
    }

    public function testToString(): void
    {
        $entity = new Database();
        $entity->setName('test');
        self::assertSame('test', (string) $entity);
    }

    public function testEmail(): void
    {
        $entity = new Database();
        $entity->setHost('localhost');
        self::assertSame('localhost', $entity->getHost());
    }

    public function testPort(): void
    {
        $entity = new Database();
        self::assertNull($entity->getPort());
        $entity->setPort(3307);
        self::assertSame(3307, $entity->getPort());
    }

    public function testUser(): void
    {
        $entity = new Database();
        $entity->setUser('admin');
        self::assertSame('admin', $entity->getUser());
    }

    public function testPassword(): void
    {
        $entity = new Database();
        $entity->setPassword('redacted');
        self::assertSame('redacted', $entity->getPassword());
    }

    public function testName(): void
    {
        $entity = new Database();
        $entity->setName('db_name');
        self::assertSame('db_name', $entity->getName());
    }

    public function testMaxBackups(): void
    {
        $entity = new Database();
        $entity->setMaxBackups(3);
        self::assertSame(3, $entity->getMaxBackups());
    }

    public function testPlainPassword(): void
    {
        $entity = new Database();
        self::assertNull($entity->getPlainPassword());
        $entity->setPlainPassword('random');
        self::assertSame('random', $entity->getPlainPassword());
    }

    public function testCreatedAt(): void
    {
        $entity = new Database();
        $date = new \DateTimeImmutable();
        self::assertInstanceOf(\DateTimeImmutable::class, $entity->getCreatedAt());
        $entity->setCreatedAt($date);
        self::assertSame($date, $entity->getCreatedAt());
    }

    public function testOwner(): void
    {
        $entity = new Database();
        $user = new User();
        self::assertNull($entity->getOwner());
        $entity->setOwner($user);
        /* @phpstan-ignore-next-line */
        self::assertSame($user, $entity->getOwner());
    }

    public function testBackups(): void
    {
        $entity = new Database();
        $backup = new Backup();
        self::assertCount(0, $entity->getBackups());
        self::assertNull($backup->getDatabase());

        $entity->addBackup($backup);
        self::assertCount(1, $entity->getBackups());
        self::assertSame($backup, $entity->getBackups()[0]);
        self::assertSame($entity, $backup->getDatabase());

        $entity->removeBackup($backup);
        self::assertCount(0, $entity->getBackups());
        self::assertNull($backup->getDatabase());
    }
}
