<?php
use Stichoza\GoogleTranslate\GoogleTranslate;

function BuildFields($name , $value = null , $type="text" ,$other = null){
    $lang = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLanguagesKeys();
    $out = "";
    if($other != null)
    {
        $others = "";
        foreach($other as $key => $o){
            $others .= "$key ='$o' ";
        }
    }else{
        $others = null;
    }
    foreach($lang as  $key => $lan){
        $newValue = $value != null ? $value[$lan] : null;
        $out .='<div class="col-lg-6" style="margin-bottom:10px;">';
        $out .='<label for="'.$name.'['.$lan.']" >'.ucfirst($name).' Language ['.$lan.']</label >';
        if($type != 'textarea'){
            $out .='<input type = "'.$type.'" class="form-control"  name="'.$name.'['.$lan.']" id = "'.$name.'['.$lan.']" placeholder="'.$name.' in '.$lan.'" '.$others.' value="'.$newValue.'"  />';
        }else{
            $out .='<textarea name="'.$name.'['.$lan.']" id="'.$name.'['.$lan.']" class="form-control ckeditor">'.$newValue.'</textarea>';
        }
        $out .='</div>';
    }
    return $out;
}

function megaMenu($chunk = 4 , $mainName = 'Cats'  , $field = 'title' , $url = 'cat/' , $urlFiled = 'id' , $data){
    $chunkArray = [
        4 => 3,
        3 => 4,
        6 => 2,
        2 => 6 ,
        12 =>1
    ];
    if(!$chunkArray[$chunk]){
        dd('This number of cols not valid');
    }
    $out ='<li class="nav-item dropdown">';
    $out .='<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    $out .= $mainName;
    $out .='</a>';
    $out .='<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
    foreach($data->chunk($chunk) as $d){
        $out .='<div class="col-lg-'.$chunkArray[$chunk].'">';
        foreach($d as $item){
            $out .='<a class="dropdown-item" href="'.url($url.$item->{$urlFiled}).'">'.$item->{$field}.'</a>';
        }
        $out .='</div>';
    }
    $out .='</div>';
    $out .='</li>';
    return $out;
}

function getDir()
{
      return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection();
}

function getDirection()
{
      $cD = getDir();
      return $cD == 'rtl' ? 'right' : 'left';
}

function getReverseDirection()
{
      $cD = getDir();
      return $cD == 'rtl' ? 'left' : 'right';
}

function checkIfLinkyouTube($url){
    $rx = '~
                ^(?:https?://)?              # Optional protocol
                 (?:www\.)?                  # Optional subdomain
                 (?:youtube\.com|youtu\.be)  # Mandatory domain name
                 /watch\?v=([^&]+)           # URI with video id as capture group 1
                 ~x';
    $has_match = preg_match($rx,  $url , $matches);
    if(isset($matches[1]) && $matches[1] != ''){
      return true;
    }else{
        return false;
    }
}


function statisticsWidget($data){
    $statisticsHtml = '';
    for ($i=0; $i < count($data); $i++) {
        ($data[$i][3] == '') ? $data[$i][3] = 'azura' : $data[$i][3] = $data[$i][3];
        $statisticsHtml .= '
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-'.$data[$i][3].' text-white rounded-circle"><i class="fa fa-'.$data[$i][2].'"></i></div>
                        <div class="ml-4">
                            <span>'.$data[$i][1].'</span>
                            <h4 class="mb-0 font-weight-medium">'.$data[$i][0].'</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
    }
    return $statisticsHtml;
}

function breadcrumbWidget($currentPageName,$pages){
    $breadcrumb = '';
    if (count($pages) == 0) {
        $breadcrumb = '<h1>'.$currentPageName.'</h1>';
    }else{
        $breadcrumb .= '
        <h1>'.$currentPageName.'</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">';
            $breadcrumb .= '<li class="breadcrumb-item"><a href="'.route("home").'">'.transWord('Home').'</a></li>';
            for ($i=0; $i < count($pages); $i++) {
                if ($pages[$i][1] == '' || $pages[$i][1] == '#') {
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="">'.$pages[$i][0].'</a></li>';
                }else if(is_array($pages[$i][1])){
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="'.route($pages[$i][1][0],$pages[$i][1][1]).'">'.$pages[$i][0].'</a></li>';
                }else{
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="'.route($pages[$i][1]).'">'.$pages[$i][0].'</a></li>';
                }
            }
            $breadcrumb .= '</ol>
        </nav>
        ';
    }
    return $breadcrumb;
}

function getLang(){
    $lang = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLanguagesKeys();
    return $lang;
}

function datatableLang(){
    $lang = \Lang::getLocale();
    if($lang == 'ar')
        return '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json';
    else
        return '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json';
}

function menuActive($name,$arrange){
    if(request()->segment($arrange) == $name){
        return "active";
    } 
}

function getUserRole($userId){
    $user = \App\User::findOrfail($userId);
    $roles = [];
    foreach ($user->getRoleNames() as $role) {
        array_push($roles,$role);
    }
    return $roles;
}

function getDataFromJson($json){
    $data = json_decode($json, true);
    return $data;
}

function getDataFromJsonByLanguage($json){
    $lang = \Lang::getLocale();
    $data = json_decode($json, true)[$lang];
    return $data;
}

function changeLanguageMenu(){
    $menu = '';
    foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
        $menu .= '<a class="dropdown-item pt-2 pb-2" href="'.LaravelLocalization::getLocalizedURL($localeCode, null, [], true).'">'.$properties["native"].'</a>';
    }
    return $menu;
}

function socialMediaInputs($data){
    $socials = getDataFromJson($data);
    $socialsOutput = '';
    foreach($socials as $key => $value){
        $socialsOutput .= '<div class="col-lg-6" style="margin-bottom:10px;">';
        $socialsOutput .= '<label for="'.$key.'">'.ucfirst($key).'</label>';
        $socialsOutput .= '<input id="'.$key.'" type="url" name="soicalmedia['.$key.']" class="form-control" value="'.$value.'" placeholder="'.__("tr.".ucfirst($key)).'">';
        $socialsOutput .= '</div>';
    }
    return $socialsOutput;
}

function checkHasValue($data){
    if (isset($data)) {
        if ($data != null) {
            return $data;
        }
    }
}

function translateWords($word){
    $lang = \Lang::getLocale();
    return GoogleTranslate::trans($word, $lang, 'en');
}

function mainSettingsData(){
    if(\App\Models\MainSetting::count() > 0)
    {
        $settings = \App\Models\MainSetting::findOrfail(1);
        $main_settings = [];
        $main_settings['title'] = getDataFromJsonByLanguage($settings->title);
        $main_settings['content'] = getDataFromJsonByLanguage($settings->content);
        $main_settings['address'] = getDataFromJsonByLanguage($settings->address);
        $main_settings['meta_title'] = getDataFromJsonByLanguage($settings->meta_title);
        $main_settings['meta_desc'] = getDataFromJsonByLanguage($settings->meta_desc);
        $main_settings['meta_keywords'] = getDataFromJsonByLanguage($settings->meta_keywords);
        $main_settings['logo'] = getDataFromJsonByLanguage($settings->logo);
        $main_settings['mobile'] = $settings->mobile;
        $main_settings['email'] = $settings->email;
        return $main_settings;
    }else{
        return null;
    }
}

function transWord($word){
    $lang = \Lang::getLocale();
    if(\App\Models\LanguageTranslate::where('word',$word)->where('key',$lang)->count() > 0){
        $transData = \App\Models\LanguageTranslate::where('word',$word)->where('key',$lang)->get()->first();
        return $transData->translation;
    }else{
        return $word;
    }
}

function convertToTags($text){
    if(strpos($text,",") != null){
        $tags = explode(',',$text);
        $tags_html = '';
        foreach ($tags as $tag) {
            $tags_html .= '<span class="badge badge-success" style="font-weight: bold;">'.$tag.'</span>';
        }
        return $tags_html;
    }else{
        return $text;
    }
}