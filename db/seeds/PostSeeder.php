<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Definir dependencias del seed (primero ejecutará UserSeeder)
     */
    public function getDependencies() {
		return ['UserSeeder'];
	}
    
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
	    $data = [];
	    for ($i = 0; $i < 50; $i++)
	    {
		    $data[] = [
			    'title'          => $faker->sentence(3),
			    'body'           => $faker->paragraph(10),
			    'user_id'        => 1
		    ];
	    }

	    $this->insert('posts', $data);
    }
}
