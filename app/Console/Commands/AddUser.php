<?php

namespace App\Console\Commands;

use App\Models\DynamoDbUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Exception;
use Illuminate\Support\Str;


class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a user to DynamoDB user table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $username = Str::lower($this->argument('username'));
            $password = $this->argument('password');

            $user = DynamoDbUser::where('username', $username)->first();
            if ($user != null) {
                echo "User already exists\n";
                return;
            }

            var_dump($password);
            $hash = hash('sha256', $password);
            $id = Uuid::uuid4()->toString();

            $user = new DynamoDbUser();

            $user->id = $id;
            $user->username = $username;
            $user->password = $hash;
            $result = $user->save();

            echo "Saved \n\n";
        } catch (Exception $e) {
            var_dump($e);
        }


    }

}
