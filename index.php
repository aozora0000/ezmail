<?php
	//call class file
	//クラスファイル呼び出し
	require_once('class.ezmail.php');
	
	//make instance
	//インスタンス作成
	$mail = new Ezmail();
	
	//template directory(default: "./templates/" )
	//remember make directory!!!
	//テンプレートディレクトリ(デフォルト: "./templates/")
	//ディレクトリ作成を忘れないでね！
	$mail->setTempdir();
	
	//set template file
	//テンプレートファイル呼び出し
	$mail->setTempfile("mail_tmp.txt");
	
	//set subject
	//件名設定
	$mail->setSubject("無題");
	
	//set from adrress
	//送信元設定
	$mail->setFrom("from@hoge.com");
	
	//set to adrress
	//送信先設定
	$mail->setTo("to@hoge.com");

	//set variable to template like smarty
	//available array
	//変数設定（スマーティー風）
	//連想配列も使えます
	$mail->assign("body","test");
	$mail->assign("array",array("array"=>"testarray"));
	
	
	//templatefile charcode(default:"utf-8")
	//テンプレートファイルの文字コード設定(デフォルト:"utf-8")
	$mail->setChar("utf-8");
	
	//send mail!!!
	//送信！
	$mail->execute();
?>