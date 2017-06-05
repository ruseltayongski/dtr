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
        $user->username = "admin";
        $user->fname = 'Lourence Rex';
        $user->lname = 'Traya';
        $user->mname = 'B.';
        $user->password = 'admin';
        $user->usertype = 1;
        $user->save();
    }
}
