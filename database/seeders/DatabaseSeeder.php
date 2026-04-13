<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure we have a few local placeholder images for seeded posts.
        $disk = Storage::disk('public');
        $disk->makeDirectory('uploads');

        foreach (['poza.png', 'poza2.webp', 'poza3.png'] as $name) {
            $src = public_path('images/'.$name);
            $dst = 'uploads/'.$name;

            if (File::exists($src) && !$disk->exists($dst)) {
                $disk->put($dst, File::get($src));
            }
        }

        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );

        Category::factory(10)
            ->has(Post::factory()->withTags()->count(20))
            ->create();

        $this->call(RaceSeeder::class);
    }
}
