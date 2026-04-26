<?php
/**
 * +----------------------------------------------------------------------
 * | wxpusher-sdk-php
 * +----------------------------------------------------------------------
 * | Copyright (c) 2020 Meloncn All rights reserved.
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Github： ( https://github.com/wxpusher/wxpusher-sdk-php )
 * +----------------------------------------------------------------------
 * | Version： v1.1
 * +----------------------------------------------------------------------
 * | LastUpdate： 2020-03-19
 * +----------------------------------------------------------------------
 */

class Wxpusher
{
    protected $appToken;
    protected $appMsgCheckGate;
    protected $appMsgGate;
    protected $appUserFunGate;
    protected $appQrCreatGate;

    function __construct($Token = 0){
        $this->appToken = $Token;
        $this->appMsgGate = 'http://wxpusher.zjiecode.com/api/send/message';
        $this->appMsgCheckGate = 'http://wxpusher.zjiecode.com/api/send/query';
        $this->appUserFunGate = 'http://wxpusher.zjiecode.com/api/fun/wxuser';
        $this->appQrCreatGate = 'http://wxpusher.zjiecode.com/api/fun/create/qrcode';
    }

    /**
     *  Post请求工具
     *  用于向服务器快速发送json格式数据
     */
    private function post_json($url, $jsonStr){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonStr)
        ));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return  $response;
    }

    /**
     * 快速发送文本信息
     * 使用方法：
     *      $wx->quickSend('用户id','主题id','内容','http://domain',false);
     *          成功返回    true
     *          失败返回    服务器提示信息
     *
     *  用户ID与主题ID使用哪一个填写哪一个，不使用留空
     *
     *  最后一个参数debug （bool）
     *      true    失败返回服务器提示信息
     *      false   失败返回false
     */
    public function quickSend($uid = null , $topicId = null , $content = 'Hello',$url = null,$debug = false){
        $data = http_build_query(
            array(
                'appToken' => $this->appToken,
                'content' => $content,
                'uid' => $uid,
                'topicId' => $topicId,
                'url'   => urlencode($url),
            ));
        $result = json_decode(file_get_contents($this->appMsgGate.'/?'.$data),TRUE);

        if ($result['data'][0]['code'] == 1000){
            return true;
        }else{
            if ($debug){
                return $result['data'][0]['status'];
            }else{
                return false;
            }
        }
    }

    /**
     * @param null $content
     * @param int $contentType
     * @param int $summary
     * @param bool $isUids
     * @param array int $id
     * @param string $url
     * @return string
     *
     * 标准信息发送方式
     * 需调用CURL
     *
     * $content: 您要发送的内容 \n换行
     * $summary: 消息摘要 \n换行  可为空
     * $contentType:
     *     |- 1表示文字
     *     |- 2表示html
     *     |- 3表示markdown
     *
     * $isUids:
     *     |- true    发送到用户
     *     |- false   发送到主题
     *
     * $url 需要添加协议头 http://或https://
     *
     * $array_id:  单条可使用int类型，多条使用数组方式
     *
     * 执行结果：
     *  是否开启$getMessageId:
     *      |—true    执行完毕后返回messageId和错误信息 多维数组形式
     *      |—false   执行完毕后仅返回错误信息，若无错误返回TRUE
     *
     * 使用方法实例：
     *      $wx->send('内容','摘要','类型','是否为用户id',id或数组id,'需传送的url',是否返回messageID))
     */
      public function send($content = null, $summary = null, $contentType = 1, $isUids = true, $array_id = [], $url = '', $getMessageId = false, $verifyPay = false)
    {
        $type = $isUids ? 'uids' : 'topicIds';
    
        // 如果 $array_id 不是数组，将其转换为数组
        if (!is_array($array_id)) {
            $array_id = ["$array_id"];
        }
    
        // 构造 POST 数据
        $postdata = [
            'appToken' => $this->appToken,
            'content' => $content,
            'summary' => $summary,
            $type => $array_id,
            'url' => $url,
            'verifyPay' => $verifyPay,
        ];
    
        $jsonStr = json_encode($postdata);
        $result_Original = json_decode($this->post_json($this->appMsgGate, $jsonStr), true); // 执行 POST 请求v

        if ($result_Original['success'] === true && $result_Original['code'] === 1000) {
            return true; // 消息发送成功
        }
    
        return false; // 失败，返回 false
    }


    /**
     * @param string $extra
     * @param int $validTime
     * @return mixed
     *
     * 创建自定义二维码
     *  $extra      自定义参数，为空则根据当前时间随机生成，最长不可超过64位
     *  $validTime  时间，单位秒。默认1800秒即30分钟
     *
     * 执行成功后返回多维数组
     *  |
     *  | -- 'expires' 过期时间
     *  | -- 'code'
     *  | -- 'shortUrl 生成二维码短连接
     *  | -- 'extra'   传递进的参数
     *  | -- 'url'     二维码长链接
     *
     *  执行失败返回错误原因 （string）
     */

    public function Qrcreate($extra = '',$validTime = 1800){

        if ($extra == ''){
            $extra = md5(time().microtime().'wxpusher');
        }
        $postdata = array(
            'appToken' => $this->appToken,
            'extra' => $extra,
            'validTime' => $validTime,
        );
        $jsonStr = json_encode($postdata);
        $result = json_decode($this->post_json($this->appQrCreatGate, $jsonStr),TRUE);
        if ($result['success']){
            return $result['data'];
        }else{
            return $result['msg'];
        }
    }
    
    
    /**
     * 查询扫码用户的 UID
     * 使用此方法查询通过二维码扫描后的用户 UID
     * 
     * @param string $code 二维码的code参数，通过创建二维码接口获得
     * @return mixed 返回扫码的用户UID，若查询失败则返回错误信息
     */
    public function getScanQrcodeUid($code)
    {
        // 构建查询的 URL
        $url = 'https://wxpusher.zjiecode.com/api/fun/scan-qrcode-uid?code=' . $code;
    
        // 发送 GET 请求
        $result = json_decode(file_get_contents($url), true);
        // 判断请求是否成功
        if ($result['code'] == 1000) {
            return $result['data'];  // 返回扫码用户的 UID
        } else {
            return ;  // 返回错误信息
        }
    }

    /**
     * @param $messageId
     * @return bool
     *  信息查询状态
     *  信息发送成功返回 True
     *  其余状态返回服务器提示信息(msg)
     */
    public function checkStatus($messageId){
        $result = json_decode(file_get_contents($this->appMsgCheckGate.'/'.$messageId));
        if ($result->code == 1000){
            return true;
        }else{
            return $result->msg;
        }
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param string $uid
     * @return null|string
     *
     * 获取关注用户信息
     *  $uid 默认为空，返回所有关注用户数据    多维数组
     *       输入uid，输出指定用户信息        多维数组
     *
     * 远程服务器执行返回success继续执行
     *  否则返回远程服务器错误信息
     *
     * 查询数据
     *      得到数据返回多维数组
     *      空数据返回 NULL
     */

    public function getFunInfo($page = 1,$pageSize = 100,$uid = ''){
        $data = http_build_query(
            array(
                'appToken' => $this->appToken,
                'page' => $page,
                'pageSize' => $pageSize,
                'uid'   => $uid
            ));
        $result = json_decode($result = file_get_contents($this->appUserFunGate.'/?'.$data),true);
        if ($result['code'] == 1000){ //判断服务器是否执行成功
            $data = $result['data']['records'];
            if (empty($data)){
                return null;
            }else{
                return $data;
            }
        }else{
            return $result['msg']; //反馈服务器给出的错误信息
        }
    }
    /**
     * @return mixed
     *  返回用户关注总数 int
     */
    public function getFunTotal(){
        $data = http_build_query(
            array(
                'appToken' => $this->appToken,
                'page' => 1,
                'pageSize' => 1,
            ));
        $result = json_decode($result = file_get_contents($this->appUserFunGate.'/?'.$data),true);
        if ($result['code'] == 1000){ //判断服务器是否执行成功
            return $result['data']['total'];
        }else{
            return $result['msg']; //反馈服务器给出的错误信息
        }
    }
}