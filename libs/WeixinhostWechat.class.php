<?php
/***
 * Class HousiteWechat
 * 为降低开发者学习成本，
 * 侯斯特应用在接口上兼容了大部分 https://github.com/dodgepudding/wechat-php-sdk
 * 的接口。
 *
 */
class WeixinhostWechat
{

    private $account = null;
    private $_receive = null;
    private $params = null;
    private $reply = null;

    public function init($account,$message,$params = array()){
        $this->account = (array)$account;
        $this->_receive = (array)$message;
        $this->params = (array)$params;
    }

    /**
     * 获取微信服务器发来的信息
     */
    public function getRev()
    {

        return $this;
    }

    /**
     * 获取微信服务器发来的信息
     */
    public function getRevData()
    {
        return $this->_receive;
    }

    /**
     * 获取消息发送者
     */
    public function getRevFrom() {
        if (isset($this->_receive['FromUserName']))
            return $this->_receive['FromUserName'];
        else
            return false;
    }

    /**
     * 获取消息接受者
     */
    public function getRevTo() {
        if (isset($this->_receive['ToUserName']))
            return $this->_receive['ToUserName'];
        else
            return false;
    }

    /**
     * 获取接收消息的类型
     */
    public function getRevType() {
        if (isset($this->_receive['MsgType']))
            return $this->_receive['MsgType'];
        else
            return false;
    }

    /**
     * 获取消息ID
     */
    public function getRevID() {
        if (isset($this->_receive['MsgId']))
            return $this->_receive['MsgId'];
        else
            return false;
    }

    /**
     * 获取消息发送时间
     */
    public function getRevCtime() {
        if (isset($this->_receive['CreateTime']))
            return $this->_receive['CreateTime'];
        else
            return false;
    }

    /**
     * 获取接收消息内容正文
     */
    public function getRevContent(){
        if (isset($this->_receive['Content']))
            return $this->_receive['Content'];
        else if (isset($this->_receive['Recognition'])) //获取语音识别文字内容，需申请开通
            return $this->_receive['Recognition'];
        else
            return false;
    }

    /**
     * 获取接收消息图片
     */
    public function getRevPic(){
        if (isset($this->_receive['PicUrl']))
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'picurl'=>(string)$this->_receive['PicUrl'],    //防止picurl为空导致解析出错
            );
        else
            return false;
    }

    /**
     * 获取接收消息链接
     */
    public function getRevLink(){
        if (isset($this->_receive['Url'])){
            return array(
                'url'=>$this->_receive['Url'],
                'title'=>$this->_receive['Title'],
                'description'=>$this->_receive['Description']
            );
        } else
            return false;
    }

    /**
     * 获取接收地理位置
     */
    public function getRevGeo(){
        if (isset($this->_receive['Location_X'])){
            return array(
                'x'=>$this->_receive['Location_X'],
                'y'=>$this->_receive['Location_Y'],
                'scale'=>$this->_receive['Scale'],
                'label'=>$this->_receive['Label']
            );
        } else
            return false;
    }

    /**
     * 获取上报地理位置事件
     */
    public function getRevEventGeo(){
        if (isset($this->_receive['Latitude'])){
            return array(
                'x'=>$this->_receive['Latitude'],
                'y'=>$this->_receive['Longitude'],
                'precision'=>$this->_receive['Precision'],
            );
        } else
            return false;
    }

    /**
     * 获取接收事件推送
     */
    public function getRevEvent(){
        if (isset($this->_receive['Event'])){
            $array['event'] = $this->_receive['Event'];
        }
        if (isset($this->_receive['EventKey'])){
            $array['key'] = $this->_receive['EventKey'];
        }
        if (isset($array) && count($array) > 0) {
            return $array;
        } else {
            return false;
        }
    }


    /**
     * 获取接收语音推送
     */
    public function getRevVoice(){
        if (isset($this->_receive['MediaId'])){
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'format'=>$this->_receive['Format'],
            );
        } else
            return false;
    }

    /**
     * 获取接收视频推送
     */
    public function getRevVideo(){
        if (isset($this->_receive['MediaId'])){
            return array(
                'mediaid'=>$this->_receive['MediaId'],
                'thumbmediaid'=>$this->_receive['ThumbMediaId']
            );
        } else
            return false;
    }

    /**
     * 获取接收TICKET
     */
    public function getRevTicket(){
        if (isset($this->_receive['Ticket'])){
            return $this->_receive['Ticket'];
        } else
            return false;
    }

    /**
     * 获取二维码的场景值
     */
    public function getRevSceneId (){
        if (isset($this->_receive['EventKey'])){
            return str_replace('qrscene_','',$this->_receive['EventKey']);
        } else{
            return false;
        }
    }



    /*** 回复文字消息
     * @param $message string
     * @return $this
     */
    public function text($message){

        $this->reply = array(
            'action'=>'reply',
            'data'=>array(
                'type'=>'text',
                'message'=>strval($message)
            ),
            'log'=>1,
            'exit'=>1
        );
        return $this;
    }

    /*** 回复图文消息
     * @param $news array
     * @return $this
     */

    public function news($news){
        $this->reply = array(
            'action'=>'reply',
            'data'=>array(
                'type'=>'news',
                'message'=>$news
            ),
            'log'=>1,
            'exit'=>1
        );
        return $this;
    }

    public function reply(){
        return $this->reply;
    }

}