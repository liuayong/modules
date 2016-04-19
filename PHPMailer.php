<?php

header("content-type:text/html;charset=utf-8");




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


require 'PHPMailer/class.phpmailer.php';

try {
	$mail = new PHPMailer(true); 
	$mail->IsSMTP();
	$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
	$mail->SMTPAuth   = true;                  //开启认证
	$mail->Port       = $GLOBALS['config']['MAIL_PORT'];                  
	$mail->Host       = $GLOBALS['config']['MAIL_SMTP']; 
	$mail->Username   = $GLOBALS['config']['MAIL_LOGINNAME']; 
	$mail->Password   = $GLOBALS['config']['MAIL_PASSWORD'];    
	
	//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
	$mail->AddReplyTo( $GLOBALS['config']['MAIL_ADDRESS'] ,  $GLOBALS['config']['MAIL_FROM'] );//回复地址
	$mail->From       = $GLOBALS['config']['MAIL_ADDRESS'] ;
	$mail->FromName   = "www.phpddt.com";
	$to = "404842799@qq.com";
	$mail->AddAddress($to);
	$mail->Subject  = "phpmailer测试标题";
	$mail->Body = "<h1>phpmail演示</h1>这是php点点通（<font color=red>www.phpddt.com</font>）对phpmailer的测试内容";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
	$mail->WordWrap   = 80; // 设置每行字符串的长度
	//$mail->AddAttachment("f:/test.png");  //可以添加附件
	$mail->IsHTML(true); 
	$ret = $mail->Send();
	echo '邮件已发送';
} catch (phpmailerException $e) {
	echo "邮件发送失败：".$e->errorMessage();
}
    ?>