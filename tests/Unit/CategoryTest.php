<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_has_many_products()
    {
        $category = Category::factory()->create();

        $this->assertInstanceOf(Collection::class, $category->products);
    }
}
