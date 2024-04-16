<?php

namespace Kblais\LaravelHelpers\Tests;

use Illuminate\Database\Eloquent\Model;
use Kblais\LaravelHelpers\Eloquent\SingularTableNameTrait;

final class SingularTableNameTest extends TestCase
{
    public function testUserModelHasSingularTableName()
    {
        $user = new User();

        static::assertSame($user->getTable(), 'user');
    }

    public function testPostModelHasCustomTableName()
    {
        $post = new Post();

        static::assertSame($post->getTable(), 'user_posts');
    }
}

class Post extends Model
{
    use SingularTableNameTrait;

    protected $table = 'user_posts';
}

class User extends Model
{
    use SingularTableNameTrait;
}
