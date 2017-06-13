<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        	'前端' => [
        		'vuejs',
        		'bootstrap',
        		'webpack',
        		'jquery'
        	],
        	'后端' => [
        		'php',
        		'mysql',
        		'nginx',
        		'apache'
        	]
        ];
        $order = 1;
        foreach ($categories as $k => $v) {
        	//第一级类别
        	$pid = DB::table('categories')->insertGetId([
        		'category_name' => $k,
        		'parent_id' => 0,
        		'display_order' => $order++,
        		'created_at' => date('Y-m-d H:i:s'),
        		'updated_at' => date('Y-m-d H:i:s'),
        	]);
        	foreach ($v as $vv) {
        		DB::table('categories')->insert([
	        		'category_name' => $vv,
	        		'parent_id' => $pid,
	        		'display_order' => $order++,
	        		'created_at' => date('Y-m-d H:i:s'),
	        		'updated_at' => date('Y-m-d H:i:s'),
	        	]);
        	}
        }
    }
}
