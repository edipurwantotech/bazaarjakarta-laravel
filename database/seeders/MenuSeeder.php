<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Events menu (parent)
        $eventsMenuId = DB::table('menus')->insertGetId([
            'parent_id' => null,
            'title' => 'Events',
            'url' => '#',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 1,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create All Events submenu (child of Events)
        DB::table('menus')->insert([
            'parent_id' => $eventsMenuId,
            'title' => 'All Events',
            'url' => '/admin/events',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 1,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create Create Event submenu (child of Events)
        DB::table('menus')->insert([
            'parent_id' => $eventsMenuId,
            'title' => 'Create Event',
            'url' => '/admin/events/create',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 2,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Master menu (parent)
        $masterMenuId = DB::table('menus')->insertGetId([
            'parent_id' => null,
            'title' => 'Master',
            'url' => '#',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 2,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create Category submenu (child of Master)
        DB::table('menus')->insert([
            'parent_id' => $masterMenuId,
            'title' => 'Category',
            'url' => '/admin/event-categories',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 1,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Pages submenu (child of Master)
        DB::table('menus')->insert([
            'parent_id' => $masterMenuId,
            'title' => 'Pages',
            'url' => '/admin/pages',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 2,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Partners submenu (child of Master)
        DB::table('menus')->insert([
            'parent_id' => $masterMenuId,
            'title' => 'Partners',
            'url' => '/admin/partners',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 3,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Highlight Events submenu (child of Master)
        DB::table('menus')->insert([
            'parent_id' => $masterMenuId,
            'title' => 'Highlight Events',
            'url' => '/admin/highlight-events',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 4,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Settings submenu (child of Master)
        DB::table('menus')->insert([
            'parent_id' => $masterMenuId,
            'title' => 'Settings',
            'url' => '/admin/settings',
            'position' => 'sidebar',
            'type' => 'admin',
            'order' => 5,
            'target' => '_self',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}