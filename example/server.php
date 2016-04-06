<?php
/**
 * 山西农业大学 软件学院
 *
 * sxaurjxy 
 */

  require('../src/Wechat.php');
require ('conn.php');
  /**
   * 微信公众平台演示类
   */
  class MyWechat extends Wechat {

    protected function onSubscribe() {
      $this->responseText('本微信正在测试中，部分功能未能完善，请谅解。输入时间即可回复时间，输入班级即可回复班级的课表，例1301，输入help或者帮助，回复帮助信息。');
    }

    /**
     * 用户取消关注时触发
     *
     * @return void
     */
    protected function onUnsubscribe() {
     $this->responseText('悄悄的我走了，正如我悄悄的来；我挥一挥衣袖，不带走一片云彩。');
    }

    /**
     * 收到文本消息时触发，回复收到的文本消息内容
     *
     * @return void
     */
    protected function onText() {
        $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);if(!$con){ die('could not connect:'.mysql_error()); }mysql_select_db(SAE_MYSQL_DB,$con);
                mysql_select_db("infosystem", $con);          //选择数据库 
        $class = array(1101=>1101,1102=>1102,1201=>1201,1202=>1202,1203=>1203,1204=>1204,1301=>1301,1302=>1302,1303=>1303,1304=>1304,1305=>1305,1306=>1306,1307=>1307,1308=>1308,1309=>1309,1310=>1310,1311=>1311,1312=>1312,1313=>1313,1314=>1314,1315=>1315);
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            switch ($keyword)
{
               
case '时间':
  				$msgType = "text";
                $contentStr = date("Y-m-d H:i:s",time());
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
  				break;  
case '翻译':
                $contentStr = '请输入翻译加需要翻译的内容，例如翻译时间。';
                $this->responseText($contentStr);
  				break;
          #      $msgType = "text";
           #     //$fanyi = 
           #    	$contentStr=$this->youdaoDic($str_key);
            #    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            #    echo $resultStr;
  			#	break;  
case '天气':
            	$msgType = "text";
                header("Content-type: text/html; charset=utf-8"); 
                
                $f = new SaeFetchurl();
    			$content = $f->fetch("http://m.weather.com.cn/data/101100408.html");
    			if($f->errno() == 0)  echo $content;
    			else echo $f->errmsg();
                
                
                /*     	$json=file_get_contents("http://m.weather.com.cn/data/101100408.html");
                $data = json_decode($json);
                echo $data["weatherinfo"]["date_y"].$data["weatherinfo"]["city"]."的天气是："; 
				echo $data["weatherinfo"]["temp1"].$data["weatherinfo"]["weather1"].$data["weatherinfo"]["wind1"]."&lt;br"; 
                print_r(json_decode($json));
             	
            	#$contentStr = "【".$data->weatherinfo->city."天气预报】\n".$data->weatherinfo->date_y." ".$data->weatherinfo->fchh."时发布"."\n\n实时天气\n".$data->weatherinfo->weather1." ".$data->weatherinfo->temp1." ".$data->weatherinfo->wind1."\n\n温馨提示：".$data->weatherinfo->index_d."\n\n明天\n".$data->weatherinfo->weather2." ".$data->weatherinfo->temp2." ".$data->weatherinfo->wind2."\n\n后天\n".$data->weatherinfo->weather3." ".$data->weatherinfo->temp3." ".$data->weatherinfo->wind3;erinfo->weather2." ".$data->weatherinfo->temp2." ".$data->weatherinfo->wind2."\n\n后天\n".$data->weatherinfo->weather3." ".$data->weatherinfo->temp3." ".$data->weatherinfo->wind3;
$contentStr = date("Y-m-d H:i:s",time());
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               	echo $resultStr;   */
  				break;
case '姓名':
                 $contentStr = '请输入姓名加上要查询的姓名';
                $this->responseText($contentStr);
  				break;
default:
             	$str = mb_substr($keyword,0,2,"UTF-8");
            	$str_key = mb_substr($keyword,0,2,"UTF-8");
                $word = mb_substr($keyword,2,220,"UTF-8");
            	if($str == '翻译' )
                {
                    $data = $this->youdaoDic($word);
                    $this->responseText($data);
                }
               #  && !empty($str_key)
                //查询课表
                
               if(array_key_exists($keyword,$class))
               {
                $class_inarray = array_search($keyword,$class);
                $kebiaourl = "http://sxaurjxy.sinaapp.com/kebiao/$class_inarray.jpg";
				$items = array(new NewsResponseItem($keyword.'班的课表', '', $kebiaourl, $kebiaourl),);
                        $this->responseNews($items);
               }
               
                
                
                if($str == '姓名')
                {
                    $q = "SELECT * FROM student where 姓名 = '".$word."'";                  //SQL查询语句 
                    mysql_query("SET NAMES UTF-8");
                    $rs = mysql_query($q, $con);                     //获取数据集 
                    if(!$rs)
                    {
                    die("Valid result!");
                    }
                    while($row=mysql_fetch_array($rs))
                    $contentStr = &$row[6];
                $this->responseText($contentStr);
                }
                
               	break;
            }
        }
    }

   
          
                //$this->responseText('收到了文字消息：' . $this->getRequest('content'));
			
           
        
    

    /**
     * 收到图片消息时触发，回复由收到的图片组成的图文消息
     *
     * @return void
     */
    protected function onImage() {
      $items = array(
        new NewsResponseItem('标题一', '描述一', $this->getRequest('picurl'), $this->getRequest('picurl')),
        new NewsResponseItem('标题二', '描述二', $this->getRequest('picurl'), $this->getRequest('picurl')),
      );

      $this->responseNews($items);
    }

    /**
     * 收到地理位置消息时触发，回复收到的地理位置
     *
     * @return void
     */
    protected function onLocation() {
        //$num = 1 / 0;
      // 故意触发错误，用于演示调试功能

      $this->responseText('收到了位置消息：' . $this->getRequest('location_x') . ',' . $this->getRequest('location_y'));
    }

    /**
     * 收到链接消息时触发，回复收到的链接地址
     *
     * @return void
     */
    protected function onLink() {
      $this->responseText('收到了链接：' . $this->getRequest('url'));
    }

    /**
     * 收到未知类型消息时触发，回复收到的消息类型
     *
     * @return void
     */
    protected function onUnknown() {
      $this->responseText('收到了未知类型消息：' . $this->getRequest('msgtype'));
    }
      
      private function weather($n){
        include("weather_cityId.php");
        $c_name=$weather_cityId[$n];
        if(!empty($c_name)){
            $json=file_get_contents("http://m.weather.com.cn/data/".$c_name.".html");
            return json_decode($json);
        } else {
            return null;
        }
    }
      public function youdaoDic($word){

        $keyfrom = "sxnydxrjxy";    //申请APIKEY时所填表的网站名称的内容
        $apikey = "1843776323";  //从有道申请的APIKEY
        
        //有道翻译-json格式
        $url_youdao = 'http://fanyi.youdao.com/fanyiapi.do?keyfrom='.$keyfrom.'&key='.$apikey.'&type=data&doctype=json&version=1.1&q='.$word;
        
        $jsonStyle = file_get_contents($url_youdao);

        $result = json_decode($jsonStyle,true);
        
        $errorCode = $result['errorCode'];
        
        $trans = '';

        if(isset($errorCode)){

            switch ($errorCode){
                case 0:
                    $trans = $result['translation']['0'];
                    break;
                case 20:
                    $trans = '要翻译的文本过长';
                    break;
                case 30:
                    $trans = '无法进行有效的翻译';
                    break;
                case 40:
                    $trans = '不支持的语言类型';
                    break;
                case 50:
                    $trans = '无效的key';
                    break;
                default:
                    $trans = '出现异常';
                    break;
            }
        }
        return $trans;
        
    }
	
    
}
  
//$contentStr = $this->youdaoDic($word);

  $wechat = new MyWechat('weixin', TRUE);
  $wechat->run();
