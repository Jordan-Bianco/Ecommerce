<?php

namespace Tests\Unit;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_a_product_belongs_to_a_category()
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Category::class, $product->category);
    }

    public function test_product_belongs_to_many_orders()
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Collection::class, $product->orders);
    }

    public function test_product_has_many_images()
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Collection::class, $product->images);
    }
}
