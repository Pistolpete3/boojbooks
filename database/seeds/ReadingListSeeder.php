<?php

use App\ReadingList;
use Illuminate\Database\Seeder;

class ReadingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ReadingList::class, 10)->create();
    }
}
