<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['css多行省略', '环境配置', 'ueditor图片上传', '环境搭建', '好歌推荐', '查看log', 'linux命令', '软件安装', '经验分享', 'php函数学习', 'mysql命令学习', 'redis学习', 'git命令学习', '版本控制工具', 'curl', 'php学习路线', 'mysql设置', 'mac命令', 'nginx配置', 'apache配置', 'smarty注释', 'php扩展安装', 'windows平台', 'js/jquery小技巧', 'wamp设置'];
        foreach ($tags as $k => $v) {
        	DB::table('tags')->insert([
        		'tag_name' => $v,
                'display_order' => $k+1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
        	]);
        }

    }
}
