<?php

use Illuminate\Database\Seeder;

class MainSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = '{"en":"Laravel Dashboard","ar":"لوحه التحكم"}';
        $content = '{"en":"Laravel Dashboard","ar":"لوحه التحكم"}';
        $mobile = '1234567890';
        $email = 'info@ladash.com';
        $address = '{"en":"asdsa","ar":"asdsa"}';
        $logo = '{"en":"en_logo.png","ar":"ar_logo.png"}';
        $meta_title = '{"en":"en_meta_title","ar":"ar_meta_title"}';
        $meta_desc = '{"en":"en_meta_desc","ar":"ar_meta_desc"}';
        $meta_keywords = '{"en":"en_meta_keywords","en":"ar_meta_keywords"}';
        $socialmedia = '{"fb":"https://www.facebook.com","tw":"https://www.twitter.com"}';

        $mainsettings = new \App\Models\MainSetting();
        $mainsettings->title = $title;
        $mainsettings->content = $content;
        $mainsettings->mobile = $mobile;
        $mainsettings->email = $email;
        $mainsettings->address = $address;
        $mainsettings->logo = $logo;
        $mainsettings->meta_title = $meta_title;
        $mainsettings->meta_desc = $meta_desc;
        $mainsettings->meta_keywords = $meta_keywords;
        $mainsettings->socialmedia = $socialmedia;
        $mainsettings->save();
    }
}
