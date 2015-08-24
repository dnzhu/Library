<?php

/**
 * Proxy代理模式
 * 为其他对象提供一个代理以控制这个对象的访问
 * 参考1: http://designpatternsphp.readthedocs.org/en/latest/Structural/Proxy/README.html
 * 参考2: http://www.phppan.com/2011/10/php-design-pattern-proxy-and-reflection/
 */


/**
 * 抽象主题角色
 */
abstract class Subject
{
	abstract public function action();
}

/**
 * 真实主题角色
 */
 class RealSubject extends Subject
 {
	 public function __construct(){}
	 public function action()
	 {
		 echo 'action method in RealSubject<br>\r\n';
	 }
 }

 /**
  * 代理主题角色
	*/
 class ProxySubject extends Subject
 {
	 private $_real_subject = NULL;
	 public function __construct(){}
	 public function action()
	 {
		 $this->_beforeAction();
		 if (is_null($this->_real_subject)) {
			 $this->_real_subject = new RealSubject();
		 }
		 $this->_real_subject->action();
		 $this->_afterAction();
	 }

	 /**
	  * 请求前的操作
		*/
	 private function _beforeAction()
	 {
		 echo 'Before Action in ProxyAction<br>\r\n';
	 }

	 /**
	  * 请求后的操作
		*/
	 private function _afterAction()
	 {
		 echo 'After action in ProxySubject<br>\r\n';
	 }
 }



 /**
  * 客户端
	*/
	class Client
	{
		public static function main()
		{
			$subject = new ProxySubject();
			$subject->action();
		}


	}



	Client::main();
