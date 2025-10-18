<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by field
        $adminUser = User::where('email', 'admin@bazaarjakarta.id')->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // Get all event categories
        $categories = EventCategory::all();
        $categoryIds = $categories->pluck('id')->toArray();

        // Sample event data
        $events = [
            [
                'title' => 'Jakarta Food Festival 2024',
                'description' => 'Experience the best culinary delights Jakarta has to offer. This festival features over 100 food vendors from across the city, showcasing traditional Indonesian dishes and international cuisine.',
                'start_date' => '2024-11-15',
                'end_date' => '2024-11-17',
                'time' => '10:00:00',
                'location' => 'Jakarta Convention Center',
                'status' => 'published',
                'meta_title' => 'Jakarta Food Festival 2024 | Bazaar Jakarta',
                'meta_description' => 'Join us for the biggest food festival in Jakarta with over 100 vendors.',
                'meta_keywords' => 'food festival, jakarta, culinary, bazaar',
                'canonical_url' => 'events/jakarta-food-festival-2024',
                'thumbnail' => 'events/jakarta-food-festival.jpg'
            ],
            [
                'title' => 'Tech Innovation Summit',
                'description' => 'A premier technology conference bringing together innovators, entrepreneurs, and tech enthusiasts. Features keynote speeches, workshops, and networking opportunities.',
                'start_date' => '2024-12-05',
                'end_date' => '2024-12-06',
                'time' => '09:00:00',
                'location' => 'Grand Indonesia',
                'status' => 'published',
                'meta_title' => 'Tech Innovation Summit | Bazaar Jakarta',
                'meta_description' => 'Connect with tech leaders and innovators at our annual summit.',
                'meta_keywords' => 'tech, innovation, summit, jakarta',
                'canonical_url' => 'events/tech-innovation-summit',
                'thumbnail' => 'events/tech-summit.jpg'
            ],
            [
                'title' => 'Traditional Art Exhibition',
                'description' => 'Celebrate Indonesia\'s rich cultural heritage with this exhibition of traditional arts and crafts. Features batik demonstrations, wayang performances, and traditional music.',
                'start_date' => '2024-11-20',
                'end_date' => '2024-11-30',
                'time' => '08:00:00',
                'location' => 'National Gallery of Indonesia',
                'status' => 'published',
                'meta_title' => 'Traditional Art Exhibition | Bazaar Jakarta',
                'meta_description' => 'Experience Indonesia\'s traditional arts and crafts at this special exhibition.',
                'meta_keywords' => 'art, traditional, culture, indonesia',
                'canonical_url' => 'events/traditional-art-exhibition',
                'thumbnail' => 'events/art-exhibition.jpg'
            ],
            [
                'title' => 'Jakarta Fashion Week',
                'description' => 'The most prestigious fashion event in Indonesia, showcasing local and international designers. Features runway shows, designer meet-and-greets, and pop-up boutiques.',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-15',
                'time' => '14:00:00',
                'location' => 'Senayan City',
                'status' => 'published',
                'meta_title' => 'Jakarta Fashion Week | Bazaar Jakarta',
                'meta_description' => 'Discover the latest fashion trends at Jakarta Fashion Week.',
                'meta_keywords' => 'fashion, jakarta, runway, designers',
                'canonical_url' => 'events/jakarta-fashion-week',
                'thumbnail' => 'events/fashion-week.jpg'
            ],
            [
                'title' => 'Music & Arts Festival',
                'description' => 'A vibrant celebration of music and arts featuring local bands, artists, and performers. Multiple stages, art installations, and food vendors.',
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-26',
                'time' => '15:00:00',
                'location' => 'Kemang Village',
                'status' => 'published',
                'meta_title' => 'Music & Arts Festival | Bazaar Jakarta',
                'meta_description' => 'Enjoy live music and art at our weekend festival.',
                'meta_keywords' => 'music, arts, festival, live performance',
                'canonical_url' => 'events/music-arts-festival',
                'thumbnail' => 'events/music-festival.jpg'
            ],
            [
                'title' => 'Startup Pitch Day',
                'description' => 'An exciting event where startups pitch their ideas to investors. Features presentations from promising startups and networking sessions with venture capitalists.',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-01',
                'time' => '13:00:00',
                'location' => 'Kemang Innovation Hub',
                'status' => 'published',
                'meta_title' => 'Startup Pitch Day | Bazaar Jakarta',
                'meta_description' => 'Watch startups pitch their innovative ideas to investors.',
                'meta_keywords' => 'startup, pitch, investment, entrepreneurship',
                'canonical_url' => 'events/startup-pitch-day',
                'thumbnail' => 'events/startup-pitch.jpg'
            ],
            [
                'title' => 'Jakarta Book Fair',
                'description' => 'A paradise for book lovers with thousands of titles from local and international authors. Features author signings, book launches, and reading sessions.',
                'start_date' => '2024-12-08',
                'end_date' => '2024-12-12',
                'time' => '10:00:00',
                'location' => 'Istora Senayan',
                'status' => 'published',
                'meta_title' => 'Jakarta Book Fair | Bazaar Jakarta',
                'meta_description' => 'Find your next favorite book at Jakarta\'s largest book fair.',
                'meta_keywords' => 'books, literature, reading, jakarta',
                'canonical_url' => 'events/jakarta-book-fair',
                'thumbnail' => 'events/book-fair.jpg'
            ],
            [
                'title' => 'Wellness & Health Expo',
                'description' => 'Discover the latest in health and wellness with fitness demonstrations, nutrition workshops, and wellness product exhibitions.',
                'start_date' => '2024-11-18',
                'end_date' => '2024-11-19',
                'time' => '09:00:00',
                'location' => 'Balai Kartini',
                'status' => 'published',
                'meta_title' => 'Wellness & Health Expo | Bazaar Jakarta',
                'meta_description' => 'Transform your health and wellness at our comprehensive expo.',
                'meta_keywords' => 'wellness, health, fitness, nutrition',
                'canonical_url' => 'events/wellness-health-expo',
                'thumbnail' => 'events/wellness-expo.jpg'
            ],
            [
                'title' => 'Gaming Convention 2024',
                'description' => 'The ultimate gaming experience with tournaments, new game releases, cosplay competitions, and meet-and-greets with game developers.',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-22',
                'time' => '10:00:00',
                'location' => 'Jakarta International Expo',
                'status' => 'published',
                'meta_title' => 'Gaming Convention 2024 | Bazaar Jakarta',
                'meta_description' => 'Level up your gaming experience at Jakarta\'s biggest gaming convention.',
                'meta_keywords' => 'gaming, convention, esports, cosplay',
                'canonical_url' => 'events/gaming-convention-2024',
                'thumbnail' => 'events/gaming-convention.jpg'
            ],
            [
                'title' => 'Jakarta Film Festival',
                'description' => 'Celebrating cinematic excellence with screenings of local and international films, director Q&As, and film industry workshops.',
                'start_date' => '2024-12-03',
                'end_date' => '2024-12-07',
                'time' => '11:00:00',
                'location' => 'CGV Cinemas Grand Indonesia',
                'status' => 'published',
                'meta_title' => 'Jakarta Film Festival | Bazaar Jakarta',
                'meta_description' => 'Experience the best of cinema at our annual film festival.',
                'meta_keywords' => 'film, cinema, festival, movies',
                'canonical_url' => 'events/jakarta-film-festival',
                'thumbnail' => 'events/film-festival.jpg'
            ],
            [
                'title' => 'Kids & Family Carnival',
                'description' => 'A fun-filled day for the whole family with games, rides, entertainment shows, and educational activities for children of all ages.',
                'start_date' => '2024-11-23',
                'end_date' => '2024-11-24',
                'time' => '09:00:00',
                'location' => 'Taman Mini Indonesia Indah',
                'status' => 'published',
                'meta_title' => 'Kids & Family Carnival | Bazaar Jakarta',
                'meta_description' => 'Create lasting memories with your family at our fun carnival.',
                'meta_keywords' => 'kids, family, carnival, fun',
                'canonical_url' => 'events/kids-family-carnival',
                'thumbnail' => 'events/kids-carnival.jpg'
            ],
            [
                'title' => 'Sustainable Living Expo',
                'description' => 'Learn about eco-friendly practices and sustainable products. Features workshops, green product exhibitions, and environmental awareness campaigns.',
                'start_date' => '2024-12-14',
                'end_date' => '2024-12-15',
                'time' => '10:00:00',
                'location' => 'Eco Park Ancol',
                'status' => 'published',
                'meta_title' => 'Sustainable Living Expo | Bazaar Jakarta',
                'meta_description' => 'Discover sustainable solutions for a better future.',
                'meta_keywords' => 'sustainable, eco-friendly, environment, green',
                'canonical_url' => 'events/sustainable-living-expo',
                'thumbnail' => 'events/sustainable-expo.jpg'
            ],
            [
                'title' => 'Photography Workshop',
                'description' => 'Master the art of photography with professional photographers. Learn techniques, composition, and post-processing in this hands-on workshop.',
                'start_date' => '2024-11-29',
                'end_date' => '2024-11-30',
                'time' => '08:00:00',
                'location' => 'Jakarta Arts Center',
                'status' => 'published',
                'meta_title' => 'Photography Workshop | Bazaar Jakarta',
                'meta_description' => 'Enhance your photography skills with professional guidance.',
                'meta_keywords' => 'photography, workshop, art, learning',
                'canonical_url' => 'events/photography-workshop',
                'thumbnail' => 'events/photography-workshop.jpg'
            ],
            [
                'title' => 'Jakarta Marathon',
                'description' => 'Join thousands of runners in Jakarta\'s premier marathon event. Multiple race categories available for all fitness levels.',
                'start_date' => '2024-12-08',
                'end_date' => '2024-12-08',
                'time' => '05:00:00',
                'location' => 'Monas National Monument',
                'status' => 'published',
                'meta_title' => 'Jakarta Marathon | Bazaar Jakarta',
                'meta_description' => 'Challenge yourself at Jakarta\'s biggest marathon event.',
                'meta_keywords' => 'marathon, running, fitness, sports',
                'canonical_url' => 'events/jakarta-marathon',
                'thumbnail' => 'events/marathon.jpg'
            ],
            [
                'title' => 'Digital Marketing Conference',
                'description' => 'Stay ahead of the curve with the latest digital marketing trends. Features industry experts sharing insights on SEO, social media, and content marketing.',
                'start_date' => '2024-12-11',
                'end_date' => '2024-12-11',
                'time' => '09:00:00',
                'location' => 'Shangri-La Hotel Jakarta',
                'status' => 'published',
                'meta_title' => 'Digital Marketing Conference | Bazaar Jakarta',
                'meta_description' => 'Learn cutting-edge digital marketing strategies from industry leaders.',
                'meta_keywords' => 'digital marketing, SEO, social media, conference',
                'canonical_url' => 'events/digital-marketing-conference',
                'thumbnail' => 'events/marketing-conference.jpg'
            ],
            [
                'title' => 'Jakarta Craft Beer Festival',
                'description' => 'Sample craft beers from local and international breweries. Live music, food pairings, and brewing demonstrations throughout the event.',
                'start_date' => '2024-12-16',
                'end_date' => '2024-12-17',
                'time' => '16:00:00',
                'location' => 'Kemang Square',
                'status' => 'published',
                'meta_title' => 'Jakarta Craft Beer Festival | Bazaar Jakarta',
                'meta_description' => 'Taste the best craft beers at our annual festival.',
                'meta_keywords' => 'craft beer, brewery, festival, drinks',
                'canonical_url' => 'events/craft-beer-festival',
                'thumbnail' => 'events/beer-festival.jpg'
            ],
            [
                'title' => 'Home & Design Expo',
                'description' => 'Transform your living space with ideas from top designers and home improvement experts. Features furniture, decor, and smart home technology.',
                'start_date' => '2024-12-13',
                'end_date' => '2024-12-15',
                'time' => '10:00:00',
                'location' => 'Jakarta Convention Center',
                'status' => 'published',
                'meta_title' => 'Home & Design Expo | Bazaar Jakarta',
                'meta_description' => 'Discover the latest trends in home design and decor.',
                'meta_keywords' => 'home, design, furniture, interior',
                'canonical_url' => 'events/home-design-expo',
                'thumbnail' => 'events/home-expo.jpg'
            ],
            [
                'title' => 'Jakarta Jazz Festival',
                'description' => 'An evening of smooth jazz featuring renowned local and international jazz artists. An intimate setting perfect for jazz enthusiasts.',
                'start_date' => '2024-12-19',
                'end_date' => '2024-12-19',
                'time' => '19:00:00',
                'location' => 'Jalan Asia Afrika',
                'status' => 'published',
                'meta_title' => 'Jakarta Jazz Festival | Bazaar Jakarta',
                'meta_description' => 'Enjoy world-class jazz performances in the heart of Jakarta.',
                'meta_keywords' => 'jazz, music, festival, concert',
                'canonical_url' => 'events/jakarta-jazz-festival',
                'thumbnail' => 'events/jazz-festival.jpg'
            ],
            [
                'title' => 'Startup Networking Night',
                'description' => 'Connect with fellow entrepreneurs, investors, and mentors in a relaxed atmosphere. Great opportunity to build your professional network.',
                'start_date' => '2024-12-21',
                'end_date' => '2024-12-21',
                'time' => '18:00:00',
                'location' => 'Co-working Space Kemang',
                'status' => 'published',
                'meta_title' => 'Startup Networking Night | Bazaar Jakarta',
                'meta_description' => 'Expand your network at our exclusive startup networking event.',
                'meta_keywords' => 'networking, startup, business, entrepreneurs',
                'canonical_url' => 'events/startup-networking-night',
                'thumbnail' => 'events/networking-night.jpg'
            ],
            [
                'title' => 'Year-End Bazaar',
                'description' => 'The perfect place to find unique gifts and holiday treats. Hundreds of vendors offering special deals and exclusive products.',
                'start_date' => '2024-12-23',
                'end_date' => '2024-12-25',
                'time' => '10:00:00',
                'location' => 'Grand Indonesia',
                'status' => 'published',
                'meta_title' => 'Year-End Bazaar | Bazaar Jakarta',
                'meta_description' => 'Find the perfect gifts and enjoy holiday shopping at our year-end bazaar.',
                'meta_keywords' => 'bazaar, shopping, holiday, gifts',
                'canonical_url' => 'events/year-end-bazaar',
                'thumbnail' => 'events/year-end-bazaar.jpg'
            ]
        ];

        // Create events and associate with categories
        foreach ($events as $eventData) {
            // Generate slug from title
            $eventData['slug'] = Str::slug($eventData['title']);
            $eventData['created_by'] = $adminId;

            // Create event
            $event = Event::create($eventData);

            // Attach random categories to each event (1-3 categories per event)
            $randomCategories = array_rand($categoryIds, rand(1, min(3, count($categoryIds))));
            if (!is_array($randomCategories)) {
                $randomCategories = [$randomCategories];
            }

            foreach ($randomCategories as $index) {
                $event->categories()->attach($categoryIds[$index]);
            }
        }
    }
}