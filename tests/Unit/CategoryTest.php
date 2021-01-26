<?php

namespace Tests\Unit;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use WithFaker,RefreshDatabase;


    /** @test */
    public function category_has_attributes()
    {
        $category = create(Category::class,[
            'name_en'  => $name_en = $this->faker->text(100),
            'name_ar'  => $name_ar = $this->faker->text(100),
            'status'   => $status  = RAND(0,1),
            'priority' => $priority = RAND(1,9),
            'icon'     => $icon = $this->faker->text(100),
            'parent_id' => $parent_id = create(Category::class)->categoryID
        ]);
        $this->assertEquals($category->name_en, $name_en);
        $this->assertEquals($category->name_ar, $name_ar);
        $this->assertEquals($category->status, $status);
        $this->assertEquals($category->priority, $priority);
        $this->assertEquals($category->icon, $icon);
        $this->assertEquals($category->parent_id, $parent_id);
    }

    /** @test * */
    public function category_belongs_to_parent()
    {
        $category = create(Category::class, [ 'parent_id' => create(Category::class)->categoryID]);
        $this->assertInstanceOf(Category::class, $category->Parent);
    }
    /** @test */
    public function category_has_many_children(){
        $parentCategory = create(Category::class);
        $childCategory = create(Category::class, ['parent_id' => $parentCategory->categoryID]);
        $this->assertInstanceOf(Category::class, $parentCategory->Children->first());
        $this->assertEquals($childCategory->name_en, $parentCategory->Children->first()->name_en);
    }
}
