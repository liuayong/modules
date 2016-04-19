<ul class="list">
		<li><a href="swiftmailer.php?q=send"> 发邮件 </a></li>
		<li><a href="swiftmailer.php?q=set"> 配置参数 </a></li>
	</ul>
<?php


require_once 'swiftmailer/lib/swift_required.php';

$config =  [
	/* 发邮件配置 */
    'MAIL_ADDRESS' => 'huaqiang56@163.com', // 发件人的email
    'MAIL_FROM' => '轻松自学网',			// 发件人姓名
    'MAIL_SMTP' => 'smtp.163.com',			// 邮件服务器的地址
    'MAIL_PORT' => 25,						// 端口
    'MAIL_LOGINNAME' => 'qszxw',
     //	'MAIL_PASSWORD' => '86010149661981',
    'MAIL_PASSWORD' => 'qszxw123',
     
    /* 发邮件配置 
    'MAIL_ADDRESS' => '652273118@qq.com', // 发件人的email
    'MAIL_FROM' => '轻松自学网', // 发件人姓名
    'MAIL_SMTP' => 'smtp.qq.com', // 邮件服务器的地址
    'MAIL_LOGINNAME' => 'qszxw',
    'MAIL_PASSWORD' => 'mybabyis',
	 */
];


function  sendMail () {

	$transport = Swift_SmtpTransport::newInstance($GLOBALS['config']['MAIL_SMTP'], $GLOBALS['config']['MAIL_PORT']);
	$transport->setUsername($GLOBALS['config']['MAIL_ADDRESS']);
	$transport->setPassword($GLOBALS['config']['MAIL_PASSWORD']);

	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance();
	$message->setFrom(array($GLOBALS['config']['MAIL_ADDRESS'] => $GLOBALS['config']['MAIL_FROM']));

	// 发送人
	$message->setTo(array('liuyingyong0901@163.com' => 'Mr.Right', '404842799@qq.com' => 'Mr.Wrong'));
	$message->setSubject('就知道');		// 邮件标题
	$message->setBody('dfsdfsdfsdf就知道', 'text/html', 'utf-8');

	// $message->attach(Swift_Attachment::fromPath('pic.jpg', 'image/jpeg')->setFilename('rename_pic.jpg'));
	try{
		$ret = $mailer->send($message);
	} catch (Swift_ConnectionException $e) {
		$ret = false ;
		echo 'There was a problem communicating with SMTP: ' . $e->getMessage();
	}
	return $ret ;
}


/**
 * 获取一个函数的内容
 * @param $file 某个文件
 * @param $funName 函数名称
 */
function getFunContent($file, $funName) {
	$fp = fopen($file , 'r');
	if(!$fp) {
		exit('<h1>文件 '.$file.'不存在</h1>');
	}
	
	$funcStr =  '' ;
	$where = [];

	$fileContent = file_get_contents($file);

	$pattern = '/function\s+'.$funName. '/';
	if( preg_match($pattern, $fileContent, $match) ) {
		$startPos = strpos($fileContent, $match[0]);
		
	} else {
		exit('<h1>在文件中 '.$file.'没有搜索到函数 <span style="color:red;">'.$funName.' </span></h1>');
	}

	fseek ($fp, $startPos);		// 移动指针在这里
	$flag = true ;
	while ($flag &&  (false  !== ($char = fgetc($fp))) ) {
		
		if($char == '{' ) {
			array_push($where, $char);
		}
		if($char == '}') {
			array_pop($where);
			empty($where) && $flag = false ; 
		}
		$funcStr .= $char ;
	}

	return  "<?php \n\n". $funcStr ;
}

$funContent =  getFunContent(__FILE__,'sendMail');

highlight_string($funContent);


// 替换配置文件的内容
if(isset($_GET['q']) && $_GET['q'] == 'set') {
	require 'static/setting.html' ;
}


// 测试发送邮件
if(isset($_GET['q']) && $_GET['q'] == 'send') {
	sendMail();
}

// post方法
if(!empty($_POST)) {
	$pattern = '/\$GLOBALS\[\'config\'\]\[(.+?)\]/';
	$res     = preg_replace($pattern, $_POST['config']. '($1)', $funContent);
	highlight_string($res);
}

