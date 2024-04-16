<?php

namespace Kblais\LaravelHelpers\Tests;

use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderInterface;
use Kblais\LaravelHelpers\Eloquent\OrderByDefaultOrderTrait;

final class OrderByDefaultTest extends TestCase
{
    public function testModelHasDefaultDefaultOrder()
    {
        $user = new class () extends Model implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';
        };

        $query = $user::query()
            ->applyScopes()
            ->getQuery()
        ;

        $this->assertContains([
            'column' => 'created_at',
            'direction' => 'asc',
        ], $query->orders);
    }

    public function testRemoveDefaultOrder()
    {
        $user = new class () extends Model implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';
        };

        $query = $user::withoutDefaultOrder()
            ->applyScopes()
            ->getQuery()
        ;

        $this->assertEmpty($query->orders);
    }

    public function testModelHasCustomDefaultOrder()
    {
        $user = new class () extends Model implements OrderByDefaultOrderInterface {
            use OrderByDefaultOrderTrait;

            protected $table = 'user';

            protected array $defaultOrder = [
                'column' => 'id',
                'asc' => false,
            ];
        };

        $query = $user::query()->applyScopes()->getQuery();

        $this->assertContains([
            'column' => 'id',
            'direction' => 'desc',
        ], $query->orders);
    }
}
