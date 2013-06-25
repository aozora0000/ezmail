<?php
class EzMail {
	//テンプレートセット
	private $templates_dir;
	public function setTempdir($templates_dir = NULL) {
		if(!is_null($templates_dir)) {
			$this->templates_dir = $templates_dir;
		} else {
			$this->templates_dir = './templates/';
		}
		return $this->templates_dir;
	}

	private $templateName;
	public function setTempfile($filename) {
		$this->templateName = $filename;
		return $this->templateName;
	}

	private $templatebody;
	private function __getTemplate() {
		if(file_exists($this->templates_dir.$this->templateName)) {
			$this->templatebody = file_get_contents($this->templates_dir.$this->templateName);
			$this->templatebody = mb_convert_encoding($this->templatebody, $this->char,"auto");
			return $this->templatebody;
		} else {
			return null;
		}
	}

	//From toセット
	private $from;
	public function setFrom($from = NULL) {
		if(!is_null($from)) {
			$this->from = "From : ".$from;
		} else {
			$this->from = NULL;
		}
		return $this->from;
	}
	private $to;
	public function setTo($to) {
		$this->to = $to;
		return $this->to;
	}

	//文字コードセット
	private $char;
	public function setChar($char = null) {
		if(!is_null($char)) {
			$this->char = $char;
		} else {
			$this->char = "utf-8";
		}
		return $this->char;
	}

	//件名セット
	private $subject;
	public function setSubject($subject = null) {
		if(!is_null($subject)) {
			$this->subject = $subject;
		} else {
			$this->subject = "無題";
		}
	}

	//変数取得
	private $data;
	public function assign($key,$value) {
		if(!is_array($value)) {
			$this->data[$key] = $value;
		} else {
			foreach($value as $k=>$v) {
				$this->data[$key][$k] = $v;
			}
		}
		return $this->data;
	}

	private $body;
	private function __setassing($body) {
		if(isset($this->data)) {
			foreach($this->data as $key=>$value) {
				if(is_array($value)) {
					foreach($value as $k=>$v) {
						$body = str_replace("{\$".$key.".".$k."}",$v,$body);
					}
				} else {
					$body = str_replace("{\$".$key."}",$value,$body);
				}
			}
		}
		return $body;
	}

	public function execute() {
		$body = $this->__getTemplate();
		$body = $this->__setassing($body);
		$subject = $this->subject;
		$from = $this->from;
		$to = $this->to;
		if(mb_send_mail($to,$subject,$body,$from)) {
			return true;
		} else {
			return false;
		}
	}

}
?>