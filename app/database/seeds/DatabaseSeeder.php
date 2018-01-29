<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		//$this->call('UsersTableSeeder');
		$this->call('TypeTableSeeder');
		$this->call('LeaveTableSeeder');
	}

}

class LeaveTableSeeder extends Seeder {
	public function run()
	{

		DB::table('leave_type')->insert(['id' => '1', 'code' => 'VL', 'desc' => 'VICATION LEAVE' ,'created_at' => 'NOW()','updated_at' => 'NOW()']);
		DB::table('leave_type')->insert(['id' => '2', 'code' => 'SL', 'desc' => 'SICK LEAVE','created_at' => 'NOW()','updated_at' => 'NOW()']);
		DB::table('leave_type')->insert(['id' => '3', 'code' => 'PL', 'desc' => 'PATERNITY LEAVE','created_at' => 'NOW()','updated_at' => 'NOW()']);
		DB::table('leave_type')->insert(['id' => '4', 'code' => 'ML', 'desc' => 'MATERNITY LEAVE','created_at' => 'NOW()','updated_at' => 'NOW()']);

	}
}

?>