<?php
$wsp_f='weather-script-preprocess.svg';
$w_f='weather.json';
$d_f='daily.json';

if(filesize($w_f) && filesize($d_f) && filesize($wsp_f) ) {

 $svgtmp=file_get_contents($wsp_f);

 $wd=file_get_contents($w_f);
 $w=json_decode($wd);

 $svgtmp=str_replace('ICON_W',substr($w->weather[0]->icon,0,2),$svgtmp);
 $svgtmp=str_replace('TEMP_W',round($w->main->temp),$svgtmp);
 $svgtmp=str_replace('WIND_W',round($w->wind->speed),$svgtmp);
 $svgtmp=str_replace('PRES_W',round($w->main->pressure),$svgtmp);
 $svgtmp=str_replace('HUMI_W',round($w->main->humidity),$svgtmp);

 $svgtmp=str_replace('DATE_VALPLACE',gmdate("Y-m-d H:i:s ", ($w->dt)+7200),$svgtmp);


 $d=file_get_contents($d_f);
 $a=json_decode($d);
 $napok=array('VASÁRNAP','HÉTFŐ','KEDD','SZERDA','CSÜTÖRTÖK','PÉNTEK','SZOMBAT');
 foreach($a->list as $k=>$v) {
   if(date('G')<17) $k=$k+1;
   $svgtmp=str_replace('ICON_'.$k,substr($v->weather[0]->icon,0,2),$svgtmp);
   $svgtmp=str_replace('DAY_'.$k,$napok[date('w',$v->dt)],$svgtmp);
   $svgtmp=str_replace('Min_'.$k,round($v->temp->min),$svgtmp);
   $svgtmp=str_replace('Max_'.$k,round($v->temp->max),$svgtmp);
 } 
 file_put_contents('weather-script-output.svg',$svgtmp);
}
?>
