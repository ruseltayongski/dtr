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
        $user->fname = 'DOH';
        $user->lname = '';
        $user->mname = 'B.';
        $user->password = Hash::make('hr_admin');
        $user->usertype = 1;
        $user->save();
    }
}
