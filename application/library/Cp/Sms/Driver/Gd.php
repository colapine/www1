<?php
/**
 * 对 国都接口的封装
 */
namespace Cp\Sms\Driver;

class Gd implements \St\Sms\Driver\DriverInterface
{
    /**
     * 用户名
     * @var string
     */
    protected $openId = '';
    /**
     * 密码
     * @var string
     */
    protected $openPass = '';
    /**
     * 短信发送时间
     * @var int
     * YYYYMMDDHHMMSS格式
     */
    protected $sendTime = 0;
    /**
     * 消息存活有效期
     * @var int
     * YYYYMMDDHHMMSS格式
     */
    protected $validTiem = 0;
    /**
     * 扩展码  可扩展0001~9999
     * @var int
     */
    protected $appendID = 0;
    /**
     * 接收的手机集合
     * @var int | string
     * 单个时为11位手机号码  多个时为使用逗号分隔的手机号码串 最多支持500个号码
     */
    protected $desMobile = '';
    /**
     * 短信内容
     * @var string
     */
    protected $content = '';
    /**
     * 取值有15和8。15：以普通短信形式下发,8：以长短信形式下发。
     * @var int
     * 此字段已没有意义。 abu 20150301
     */
    protected $contenType = 8;
    protected $gateway = 'http://221.179.180.158:9007/QxtSms/QxtFirewall';
    /**
     * 成功返回码
     * @var array
     */
    protected $successCode = array('00','01','03');


    /**
     * @param $config array
     *    appkey     用户名
     *    appsecret  密码
     *
     */
    public function __construct($config)
    {
        $this->openId   = $config['appkey'];
        $this->openPass = $config['appsecret'];
    }

    public function send($desMobile, $content)
    {
        $this->desMobile = $desMobile;
        $this->content   = $content;
        $output = $this->request();

        return $this->response($output);
    }

    protected function request()
    {
        $ch  = curl_init();

        $url = $this->gateway . '?';
        $url .= 'OperID=' . $this->openId;
        $url .= '&OperPass=' . $this->openPass;
        $url .= '&ContentType=' . $this->contenType;
        if ($this->sendTime) {
            $url .= '&SendTiem=' . $this->sendTime;
        }
        if ($this->validTiem) {
            $url .= '&ValidTime=' . $this->validTiem;
        }
        if ($this->appendID) {
            $url .= '&AppendID=' . $this->appendID;
        }
        $url .= '&DesMobile=' . $this->desMobile;
        $url .= '&Content=' . $this->getContent($this->content);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);
/*
          $output = '<?xml version="1.0" encoding="gbk" ?><response><code>03</code><message><desmobile>13559104190</desmobile><msgid>D8457615030317133300</msgid></message></response>';
*/
        return $output;
    }

    /**
     *
     * @param $output  XML结构字符串
     *  <?xml version="1.0" encoding="gbk" ?><response><code>03</code><message><desmobile>13559104190</desmobile><msgid>D1984815030115031500</msgid></message></response>
     * @return array
     */
    protected function response($output)
    {
        $res = array();
        if(empty($output)){
            $res['code'] = 'st07';
            $res['success'] = false;
            return $res;
        }

        try{
            $output = json_decode(json_encode((array) simplexml_load_string($output)), true);
            $code = $output['code'];
            $res['code'] = $code;
            $res['success'] = true;
            if(in_array($code,$this->successCode)){
                $message = $output['message'];
                if(isset($message['desmobile'])){
                    $res['message'][] = array(
                        $message['desmobile'] => $message['msgid']
                    );
                }else{
                    foreach($message as $mes){
                        $res['message'][] = array(
                            $mes['desmobile'] => $mes['msgid']
                        );
                    }
                }
            }else{
                $res['success'] = false;
            }

        }catch (\Exception $e){
            /**
             * @todo 报错信息处理
             */
        }

        return $res;
    }

    protected function getContent($content)
    {
        return urlencode(iconv('UTF-8', 'GBK', $content));
    }


}
