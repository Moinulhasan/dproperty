<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Top 10 Tips for First-Time Home Buyers in Dhaka',
                'content' => '<p>Buying your first home is an exciting milestone, but it can also be overwhelming. In this article, we share essential tips for navigating the Dhaka real estate market, from budgeting to final inspection.</p><p>Dhaka\'s real estate landscape is unique, with varying property values across neighborhoods like Gulshan, Dhanmondi, and Uttara. Understanding your needs and setting a realistic budget are the first steps toward a successful purchase.</p>',
                'image' => 'images/articles/article1.jpg', // Placeholder or real path
                'status' => 1,
                'meta_title' => 'First-Time Home Buyers Tips Dhaka',
                'meta_description' => 'Essential real estate tips for first-time home buyers in Dhaka, Bangladesh.',
            ],
            [
                'title' => 'Investment Opportunities in Commercial Real Estate 2026',
                'content' => '<p>The commercial real estate sector in Bangladesh is seeing significant growth. Learn about the emerging trends and high-yield areas for investment this year.</p><p>With the expansion of infrastructure and the rise of new business hubs, commercial spaces are becoming a lucrative asset class for investors seeking steady rental income and long-term appreciation.</p>',
                'image' => 'images/articles/article2.jpg',
                'status' => 1,
                'meta_title' => 'Commercial Real Estate Investment 2026',
                'meta_description' => 'Explore the best commercial real estate investment opportunities in Bangladesh for 2026.',
            ],
            [
                'title' => 'Interior Design Trends for Modern Apartments',
                'content' => '<p>Transform your living space with the latest interior design trends. From minimalist aesthetics to smart home integration, discover how to enhance your modern apartment.</p><p>Modern apartment living is all about maximizing space and incorporating personal style. We look at popular color palettes, sustainable materials, and clever storage solutions that are currently trending in Dhaka\'s upscale residences.</p>',
                'image' => 'images/articles/article3.jpg',
                'status' => 1,
                'meta_title' => 'Modern Apartment Interior Trends',
                'meta_description' => 'Discover the latest interior design trends for modern apartments in Dhaka.',
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
