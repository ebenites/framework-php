
     ,-----.,--.                  ,--. ,---.   ,--.,------.  ,------.
    '  .--./|  | ,---. ,--.,--. ,-|  || o   \  |  ||  .-.  \ |  .---'
    |  |    |  || .-. ||  ||  |' .-. |`..'  |  |  ||  |  \  :|  `--, 
    '  '--'\|  |' '-' ''  ''  '\ `-' | .'  /   |  ||  '--'  /|  `---.
     `-----'`--' `---'  `----'  `---'  `--'    `--'`-------' `------'
    ----------------------------------------------------------------- 


## Composer Install

```
composer init

{
    "name": "ebenites/framework-php",
    "description": "Framework MVC con PHP",
    "type": "project",
    "require": {
        "kint-php/kint": "^3.1",
        "php-di/php-di": "^6.0",
        "nikic/fast-route": "^1.3",
        "twig/twig": "^2.6",
        "robmorgan/phinx": "^0.10.6",
        "fzaninotto/faker": "^1.8",
        "doctrine/orm": "^2.6",
        "symfony/validator": "^4.2",
        "respect/validation": "^1.1",
        "aura/session": "^2.1",
        "jasongrimes/paginator": "^1.0"
    },
    "authors": [
        {
            "name": "Erick Benites Cuenca",
            "email": "erick.benites@gmail.com"
        }
    ]
}
    
composer install
```

## Bower Install

```
npm install -g bower

bower init

{
  name: 'framework-php',
  authors: [
    'Erick Benites Cuenca <erick.benites@gmail.com>'
  ],
  description: 'Framework MVC con PHP',
  main: '',
  license: 'MIT',
  homepage: '',
  ignore: [
    '**/.*',
    'node_modules',
    'bower_components',
    'test',
    'tests'
  ]
}

mkdir public

nano .bowerrc

{
    "directory": "public/components/"
}

bower install bootstrap --save
```

## Autoload

```
nano composer.json

    "autoload": {
        "psr-4": {
            "Application\\": "app/"
        },
        "files": [
            "app/helpers.php"
        ]
    }
    
composer dump-autoload

```
    
## Database install

```
echo "create database framework_php" | mysql -u root

php vendor/bin/phinx init

    development:
        adapter: mysql
        host: 127.0.0.1
        name: framework_php
        user: root
        pass: ''
        port: 3306
        charset: utf8
        
mkdir db/migrations

php vendor/bin/phinx create CreateUsersTable

    public function change()
    {
        $users = $this->table('users');
        $users->addColumn('name', 'string', ['limit' => 80]);
        $users->addColumn('email', 'string', ['limit' => 80]);
        $users->addColumn('password', 'string', ['limit' => 100]);
        $users->addColumn('create_at', 'datetime');
        $users->addColumn('updated_at', 'datetime', ['null' => true]);
        $users->create();
    }

php vendor/bin/phinx migrate -e development

[deshacer] php vendor/bin/phinx rollback -e development

php vendor/bin/phinx seed:create UserSeeder

    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for($i = 0; $i < 10; $i++){
            $data[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->insert('users', $data);
    }
    
php vendor/bin/phinx seed:run -e development

[seeder específico] php vendor/bin/phinx seed:run -e development -s PostSeeder

[status] php vendor/bin/phinx status -e development

```


