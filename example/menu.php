<?php
header("Content-type: text/html; charset=utf-8");

define("ACCESS_TOKEN", 'A7UuaKm2iPJb678wPrwFOtN-9eQFJBipg2a9Ej8_EjpuKC40p-mVz3XOndnBXzfm4Oj3p89vIAidl9K5ojJOb8c-xYYsdyTZdQdAP32rQG7VJP6HnXLKTUqW_XEfV9wtDVAoPpNywJkMiSiXEM045w');

//创建菜单
function createMenu($data){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tmpInfo = curl_exec($ch);
if (curl_errno($ch)) {
return curl_error($ch);
}
curl_close($ch);
return $tmpInfo;
}


$data = ' {
"button":[

{
"name":"查询信息",
"sub_button":[
{
"type":"view",
"name":"查询成绩",
"url":"http://jwxt.sxau.edu.cn/"
},
{
"type":"click",
"name":"列车信息",
"key":"liechexinxi"
},
{
"type":"click",
"name":"查询自习室",
"key":"chaxunzixishi"
},
{
"type":"click",
"name":"查询通讯录",
"key":"chaxuntongxunlu"
}]
},
{
"name":"学习信息",
"sub_button":[
{
"type":"click",
"name":"课表安排",
"key":"kebiaoanpai"
},
{
"type":"click",
"name":"特色课程",
"key":"tesekecheng"
},
{
"type":"click",
"name":"行业动态",
"key":"hangyedongtai"
},
{
"type":"click",
"name":"学习动态",
"key":"xuexidongtai"
},
{
"type":"view",
"name":"进入图书馆",
"url":"http://m.5read.com/sxnydxyd"
}]
},
{
"name":"其他信息",
"sub_button":[
{
"type":"click",
"name":"学院动态",
"key":"xueyuandongtai"
},
{
"type":"click",
"name":"就业信息",
"key":"jiuyexinxi"
},
{
"type":"click",
"name":"创业信息",
"key":"chuangyexinxi"
},
{
"type":"click",
"name":"班团干部",
"key":"bantuanganbu"
},
{
"type":"click",
"name":"反馈意见",
"key":"fankuiyijian"
}
]
}




]
}';


echo createMenu($data);//创建菜单

?>