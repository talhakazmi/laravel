<?php

namespace Tests\Unit;

use App\Blog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use WithFaker,RefreshDatabase;


    /** @test */
    public function blog_has_attribute()
    {
        $blog= create(Blog::class,[
            'author' => $author = $this->faker->name,
            'title_en' => $title_en = $this->faker->text(100),
            'title_ar' => $title_ar = $this->faker->text(100),
            'description_en' => $description_en = $this->faker->text,
            'description_ar' => $description_ar = $this->faker->text,
            'content_en'     => $content_en = $this->faker->text,
            'content_ar'     => $content_ar = $this->faker->text,
            'image'          => $image      = $this->faker->text(100),
            'priority'       => $priority   = RAND(1,10),
            'status'         => $status     = RAND(0,1)
        ]);

        $this->assertEquals($blog->author, $author);
        $this->assertEquals($blog->title_en, $title_en);
        $this->assertEquals($blog->title_ar, $title_ar);
        $this->assertEquals($blog->description_en, $description_en);
        $this->assertEquals($blog->description_ar, $description_ar);
        $this->assertEquals($blog->content_en, $content_en);
        $this->assertEquals($blog->content_ar, $content_ar);
        $this->assertEquals($blog->image, $image);
        $this->assertEquals($blog->priority, $priority);
        $this->assertEquals($blog->status, $status);
    }
}
