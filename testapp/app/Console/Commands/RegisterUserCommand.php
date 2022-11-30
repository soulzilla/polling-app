<?php

namespace App\Console\Commands;

use App\DTO\RegisterUserDTO;
use App\Services\UsersService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Консольная команда для регистрации нового пользователя
 */
class RegisterUserCommand extends Command
{
    public function __construct(private readonly UsersService $usersService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers new user through console';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $data['name'] = $this->ask('Enter username: ');
        $data['email'] = $this->ask('Enter email: ');
        $data['password'] = $this->ask('Enter password: ');

        // валидируем введённые данные, правила идентичные как для апи, так и для консольной команды
        $validator = Validator::make([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ], [
            'name' => 'required|unique:users|min:4',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
        ]);

        // если валидация не прошла, отображаем ошибки, завершаем работу команды
        if ($validator->fails()) {
            $this->info('User not created.');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return static::FAILURE;
        }

        // регистрация по апи и по консоли имеет единую логику, поэтому регистрируем пользователя через сервис
        $dto = RegisterUserDTO::instance($data);
        if ($token = $this->usersService->register($dto)) {
            $this->info('User created.');
            $this->info('Use this token below: ');
            $this->info($token);

            return static::SUCCESS;
        }

        $this->error('User not created.');
        return static::FAILURE;
    }
}
