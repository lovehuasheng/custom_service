<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
// 
// 

/**
 * http返回码
 * @staticvar array $_status
 * @param type $code
 */
function send_http_status($code) {
    $_status = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily ', // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',
        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );
    if (array_key_exists($code, $_status)) {
        header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
    }

    return true;
}

/**
  +----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
  +----------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function rand_string($len = 6, $type = '', $addChars = '') {
    $str = '';
    switch ($type) {
        case 0:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 1:
            $chars = str_repeat('0123456789', 3);
            break;
        case 2:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
            break;
        case 3:
            $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
            break;
        default:
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
            break;
    }
    if ($len > 10) {
        //位数过长重复字符串一定次数
        $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
    }
    if ($type != 4) {
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
    } else {
        // 中文随机字
        for ($i = 0; $i < $len; $i++) {
            $str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
        }
    }
    return $str;
}

/**
 * 密码加密，统一加密方式
 * @param type $pwd
 * @return type
 */
function set_password($pwd, $salt = '') {
    $tmp = cache('pwd_public_key');
    if (empty($tmp)) {
        $key = db('SysSecret')->where(['id' => 1])->value('key');
        $public_key = md5($key);
        cache('pwd_public_key', $public_key, 24 * 3600);
    } else {
        $public_key = $tmp;
    }

    return md5(sha1($pwd . $salt) . $public_key);
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip[$type];
    }

    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }

            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 设置session签名
 * @param type $data
 * @return type
 */
function set_user_session_sign($data) {
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = md5(sha1($code)); //生成签名
    return $sign;
}

/**
 * 取七牛图片地址
 * @param type $pic
 * @param type $w
 * @param type $h
 * @return type
 */
function getQiNiuPic($path, $w = 0, $h = 0) {
    $url = 'http://' . config('qiniu.baseUrl') . '/';
    $picture = new \org\upload\driver\qiniu\QiniuStorage(config('qiniu'));
    return $picture->privateDownloadUrl($url . $path . "?imageView2/1/w/{$w}/h/{$h}");
}

function get_invented_currency_num($cid = 0) {


    $num = 100;
    switch ($cid) {
        case 1:
            $num = 100;
            break;
        case 2:
            $num = 200;
            break;
        case 3:
            $num = 300;
            break;
        case 4:
            $num = 400;
            break;
        case 5:
            $num = 500;
            break;
        default : $num = 100;
            break;
    }

    return $num;
}

/**
 * 随机数
 * @param type $num
 * @return type
 */
function get_rand_num($num = 6) {
    $str = '0123456789';
    $len = strlen($str);
    $r = '';
    for ($i = 0; $i < 6; $i++) {
        $rand = mt_rand(0, $len - 1);
        $r .= substr($str, $rand, 1);
    }

    return $r;
}

/**
 * http请求[post]
 * @param type $url
 * @param type $param
 * @param type $data
 * @param type $httpType
 * @param type $header
 * @return type
 */
function api_http_request($url, $data, $header = array()) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //SSL证书认证
    curl_setopt($ch, CURLOPT_URL, $url);
//        $header = array('Accept-Charset: utf-8');
//        $header[] = 'charset: utf-8';
    //$header[] = 'Content-Type: application/x-www-form-urlencoded';
    //  $header[] = 'Content-Type: multipart/form-data';
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格认证
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // post传输数据
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 显示输出结果

    $tmpInfo = curl_exec($ch);
    curl_close($ch);
    return $tmpInfo;
}

/**
 * 获取页码列表
 * @param   int $total          记录总数
 * @param   int $current_page   当前页码
 * @param   int $per_page       每页显示记录数
 * @param   int $page_list      显示的页码数
 * @return  array               成功返回包含page_list个元素的页码数组，否则返回空数组
 */
function get_pagination($total, $current_page = 1, $per_page = 20, $page_list = 5) {
    $pages = array();
    //获取当前页码左右两侧的页码数
    $ceil_mean = ceil($page_list / 2);
    //获取最大页码
    $max = ceil($total / $per_page);
    //计算左侧页码
    $left = max($current_page - $ceil_mean, 1);
    //计算右侧页码
    $right = $left + $page_list - 1;
    //重新计算right,防止right超过最大页码数
    $right = min($max, $right);
    //重新计算left,确保显示的页数为page_list指定的页数
    $left = max($right - $page_list + 1, 1);

    for ($i = $left; $i <= $right; $i++) {
        $pages['page_list'][] = $i;
    }
    $pages['max_page'] = $max;
    $pages['current_page'] = min($current_page, $max);
    return $pages;
}

//判断账户类型, 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包
// 6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包

function get_user_account_field($type) {
    if (empty($type)) {
        return false;
    }
    switch ($type) {
        case 1:
            $field = 'activate_currency';
            break;
        case 2:
            $field = 'guadan_currency';
            break;
        case 3:
            $field = 'invented_currency';
            break;
        case 4:
            $field = 'wallet_currency';
            break;
        case 5:
            $field = 'manage_wallet';
            break;
        case 6:
            $field = 'order_taking';
            break;
        case 7:
            $field = 'poor_wallet';
            break;
        case 8:
            $field = 'needy_wallet';
            break;
        case 9:
            $field = 'comfortably_wallet';
            break;
        case 10:
            $field = 'kind_wallet';
            break;
        case 11:
            $field = 'wealth_wallet';
            break;
        default:
            $field = '';
            break;
    }

    return $field;
}

//判断账户类型, 1-善种子 2-善心币 3-善金币 4-出局钱包 5-管理钱包
// 6-接单钱包 7-特困钱包 8-贫穷钱包 9-小康钱包 10-德善钱包 11-富人钱包
function get_user_account_name($type) {
    if (empty($type)) {
        return false;
    }
    switch ($type) {
        case 1:
            $field = '善种子';
            break;
        case 2:
            $field = '善心币';
            break;
        case 3:
            $field = '善金币';
            break;
        case 4:
            $field = '出局钱包';
            break;
        case 5:
            $field = '管理钱包';
            break;
        case 6:
            $field = '接单钱包';
            break;
        case 7:
            $field = '特困钱包';
            break;
        case 8:
            $field = '贫穷钱包';
            break;
        case 9:
            $field = '小康钱包';
            break;
        case 10:
            $field = '德善钱包';
            break;
        case 11:
            $field = '富人钱包';
            break;
        default:
            $field = '';
            break;
    }

    return $field;
}

/**
 * 创蓝短信
 * @param type $mobile
 * @param type $text
 * @param type $rand
 * @return boolean
 */
function sendSms($mobile, $text = '你正在进行账号注册,有效时间为5分钟。您好，您的验证码是', $rand = '') {

    $data = $text . $rand;
    $post_data = array();
    //账号
    $post_data['account'] = iconv('GB2312', 'GB2312', config('tel_sms.account'));
    //密码
    $post_data['pswd'] = iconv('GB2312', 'GB2312', config('tel_sms.pswd'));
    //接收的手机
    $post_data['mobile'] = $mobile;
    //接收的内容
    $post_data['msg'] = mb_convert_encoding("{$data}", 'UTF-8', 'UTF-8');

    $post_data['needstatus'] = 'true';
    //请求地址
    $url_arr = config('tel_sms.request_url');

    $index = array_rand($url_arr);

    $url = $url_arr[$index];
    //组装数据
    $post_data = http_build_query($post_data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $result = curl_exec($ch);
    //file_put_contents(LOG_PATH . 'sms.log',"mobile:{$mobile},result:{$result}\r\n",FILE_APPEND|LOCK_EX);
    $p = explode(',', $result);
    if (empty($p)) {
        return false;
    }
    $p1 = substr($p[1], 0, 1);
    if (intval($p1) === 0) {
        return true;
    }
    return false;
}

/**
 * 对象转数组
 * @param type $obj
 * @return type
 */
function get_array_to_object($obj) {
    return json_decode(json_encode($obj), true);
}

function get_log_type_text($type, $remark, $url) {
    $str = '';
    switch ($type) {
        case 1:
            $str = '【修改更新】' . $remark . ';操作地址：' . $url;
            break;
        case 2:
            $str = '【添加数据】' . $remark . ';操作地址：' . $url;
            break;
        case 3:
            $str = '【删除数据】' . $remark . ';操作地址：' . $url;
            break;
        case 4:
            $str = '【转币】' . $remark . ';操作地址：' . $url;
            break;
        default :
            $str = '【登录后台】' . $remark . ';操作地址：' . $url;
            break;
    }

    return $str;
}

/**
 * 将数据添加到队列,失败则写入到本地文件中
 * @param  string $queue_name 队列名称
 * @param  array  $data       要同步的数据
 */
function add_to_queue($queue_name = '', $data = [],$group = 'default') {
    
    $queue_name = $queue_name ? $queue_name : config('log_queue');
    //同步标志
    $syn_flag = true;
    try {
        //实例化redis
        $redis = \org\RedisLib::get_instance($group);
        //推送数据到同步队列
        if (!$redis->lPush($queue_name, json_encode($data))) {
            $syn_flag = false;
        }
    } catch (Exception $e) {
        $syn_flag = false;
    }

    //redis推送失败,将失败数据写入到文件,等待后续同步 ,文件以队列名称命名
    if (!$syn_flag) {
        $file = LOG_PATH . $queue_name . '.log';
        file_put_contents($file, json_encode($data), FILE_APPEND | LOCK_EX);
    }
}


/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc') {
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data) {
            $refer[$i] = $data[$field];
        }

        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc': // 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val) {
            $resultSet[] = &$list[$key];
        }

        return $resultSet;
    }
    return false;
}

/**
 * 获取文件的扩展名
 * @param  string $file_name 文件名
 * @return string            文件的后缀名
 */
function get_extend($file_name) 
{
    $extend = explode ( '.', $file_name );
    $count    = count ( $extend ) - 1;
    return $extend [$count];
}


function get_year($start = 2016,$num = 10) {
    $arr = [];
    for($i=$start;$i<($start+$num);$i++) {
        $arr[] = $i;
    }
    
    return $arr;
}


/**
 * 分表数
 * @param type $value
 * @param type $expr
 * @return type
 */
function get_table_seq($value,$expr = 3) {
    return ceil(date('m', $value)/$expr);
}

/**
 * 表名
 * @param type $table
 * @param type $seq
 * @return type
 */
function get_table_name($table,$seq) {
     return $table .'_'.date('Y',time()). '_' . $seq;
}


function get_partition_uine_table_name($table,$num,$partition_time='') {
	if( ! $partition_time){
		$partition_time = time();
	}
    $tableName = [];
     $count =  count($num);
     $n = '';
    for ($i = 0; $i < $count ; $i++) {
    	$n =  intval($num[$i]);
    	if( $n ==  0){
    		$year = date('Y',$partition_time) -1;
    		$M    = 4;
    	}else{
    		$year = date('Y',$partition_time);
    		$M    =$num[$i];
    	}
    	
      $tableName[] = 'SELECT * FROM ' . $table .'_'.$year . '_' .$M;
    	
    }

    $tableName = '( ' . implode(" UNION ", $tableName) . ') AS a ';
    return $tableName;
}


function get_partition_sql_name($table,$num,$partition_time=''){
	if( ! $partition_time ){
		$partition_time = time();
	}
	 
	$tableName = [];
	if( $num ==  0){
		$year = date('Y',$partition_time) -1;
		$M    = 4;
	}else{
		$year = date('Y',$partition_time);
		$M    =$num;
	}
		
	return $tableName  = $table .'_'.$year . '_' .$M;
	 
}

//设置会员密码
function set_member_password($pwd,$security='') {
    $public_key = md5('FR4ehHBBbjD7ZBNEv_GCvXBsmNSq0zLV');
    return md5(sha1($pwd . $security) . $public_key);
}

//设置会员二级密码
function set_member_secondary_password($pwd) {
    $pwd = md5($pwd);
    $public_key = md5('FR4ehHBBbjD7ZBNEv_GCvXBsmNSq0zLV');
    return md5(sha1($pwd . '') . $public_key);
}

//获取随机字符串
function random_str($len=6)
{
    $str = 'abcdefghijklmnoqprstuvwxyzABCDEFGHIJKLMNOQPRSTUVWXYZ0123456789';

    return substr(str_shuffle($str),0,$len);
}

/**
 * 时间换成当前季度的第一天的时间
 * @param int $time
 */
function getQuarterLowTime($time){
	$year = date("Y",$time);
	$month = (int)(date("m",$time));
	if($month==1 || $month==2 ||$month==3){
		$quarter = 1;
	}elseif($month==4 || $month==5 ||$month==6){
		$quarter = 4;
	}elseif($month==7 || $month==8 ||$month==9){
		$quarter = 7;
	}else{
		$quarter = 10;
	}
	$date = $year."-".$quarter."-1 00:00:00";//当前季度的第一天
	return strtotime($date);
}


/**
 * 通过时间戳得到分表名
 * @param unknown $time
 * @return string
 */
function getTimeTableName($time){
	$year = date("Y",$time);
	$month = (int)(date("m",$time));
	if($month==1 || $month==2 ||$month==3){
		$quarter = 1;
	}elseif($month==4 || $month==5 ||$month==6){
		$quarter = 2;
	}elseif($month==7 || $month==8 ||$month==9){
		$quarter = 3;
	}else{
		$quarter = 4;
	}
	return $year."_".$quarter;
}
