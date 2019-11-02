<?php /** @noinspection ALL */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (\App\User::where('email', 'julien@sigerr.org')->count() === 0) {
            factory(\App\User::class)->create([
                'email' => 'julien@sigerr.org',
            ]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
