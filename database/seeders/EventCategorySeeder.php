<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCategory;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Music',
                'slug' => 'music',
                'description' => 'Concerts, music festivals, performances, and music-related workshops.'
            ],
            [
                'name' => 'Business & Entrepreneurship',
                'slug' => 'business-entrepreneurship',
                'description' => 'Business conferences, networking events, startup pitches, and entrepreneurship workshops.'
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Workshops, seminars, book fairs, and learning-focused events.'
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Fitness events, wellness expos, health workshops, and medical seminars.'
            ],
            [
                'name' => 'Gaming & Entertainment',
                'slug' => 'gaming-entertainment',
                'description' => 'Gaming conventions, esports tournaments, cosplay events, and entertainment shows.'
            ],
            [
                'name' => 'Film & Cinema',
                'slug' => 'film-cinema',
                'description' => 'Film festivals, movie screenings, director Q&As, and film industry events.'
            ],
            [
                'name' => 'Family & Kids',
                'slug' => 'family-kids',
                'description' => 'Family-friendly events, children\'s activities, and kid-focused entertainment.'
            ],
            [
                'name' => 'Environment & Sustainability',
                'slug' => 'environment-sustainability',
                'description' => 'Eco-friendly events, sustainability workshops, and environmental awareness campaigns.'
            ],
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Photography exhibitions, workshops, and photo walks.'
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Marathons, sports competitions, fitness challenges, and athletic events.'
            ],
            [
                'name' => 'Marketing & Digital',
                'slug' => 'marketing-digital',
                'description' => 'Digital marketing conferences, social media workshops, and advertising events.'
            ],
            [
                'name' => 'Home & Lifestyle',
                'slug' => 'home-lifestyle',
                'description' => 'Home improvement shows, interior design events, and lifestyle exhibitions.'
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'description' => 'Professional networking events, meetups, and community gatherings.'
            ],
            [
                'name' => 'Shopping & Bazaar',
                'slug' => 'shopping-bazaar',
                'description' => 'Markets, bazaars, fairs, and shopping events.'
            ]
        ];

        foreach ($categories as $category) {
            EventCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}