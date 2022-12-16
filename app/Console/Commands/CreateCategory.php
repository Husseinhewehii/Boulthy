<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;

class CreateCategory extends Command
{
    use WithFaker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Category';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setUpFaker();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $locales = main_locales();

        $names = [];

        foreach ($locales as $locale) {

            $names[$locale] = $this->faker->name();
        }
        Category::create([
            'name' => $names,
            "active" => $this->faker->numberBetween(0,1),
        ]);
        $this->info("category created");
    }
}
