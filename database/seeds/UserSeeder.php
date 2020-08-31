<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->password = \Hash::make('password');
        $user->email = 'admin@admin.com';
        $user->avatar = 'avatar.png';
        $user->save();

        if(Role::where('name','Admin')->get()->count() == 0){
            Role::create(['name' => 'Admin']);
            $user->assignRole('Admin');
        }else{
            $user->assignRole('Admin');
        }
    }
}
