<?php


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Users();
        $user->username = "hr_admin";

        $user->fname = 'DOH HR';
        $user->lname = 'DOH_HR';
        $user->password = Hash::make('hr_admin');
        $user->usertype = 1;
        $user->unique_row = 'hr_admin';
        $user->save();
    }
}
