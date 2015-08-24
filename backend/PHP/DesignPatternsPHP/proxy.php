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
	
//===============================================================================================

/**
 * 使用反射实现代理工厂 
 */

/**
 * 真实主题角色 A
 */
final class RealSubjectA {

    public function __construct() {
    }

    public function actionA() {
        echo "actionA method in RealSubject A <br />\r\n";
    }

}

/**
 * 真实主题角色 B
 */
final class RealSubjectB {

    public function __construct() {
    }

    public function actionB() {
        echo "actionB method in RealSubject B <br />\r\n";
    }

}

/**
 * 代理主题角色
 */
final class ProxySubject {

    private $_real_subjects = NULL;

    public function __construct() {
        $this->_real_subjects = array();
    }

    /**
     * 动态添加真实主题
     * @param type $subject
     */
    public function addSubject($subject) {
        $this->_real_subjects[] = $subject;
    }

    public function __call($name, $args) {
        foreach ($this->_real_subjects as $real_subject) {

            /* 使用反射获取类及方法相关信息　 */
            $reflection = new ReflectionClass($real_subject);

            /* 如果不存在此方法，下一元素 */
            if (!$reflection->hasMethod($name)) {
                continue;
            }

            $method = $reflection->getMethod($name);

            /* 判断方法是否为公用方法并且是否不为抽象方法 */
            if ($method && $method->isPublic() && !$method->isAbstract()) {
                $this->_beforeAction();

                $method->invoke($real_subject, $args);

                $this->_afterAction();

                break;
            }
        }
    }

    /**
     * 请求前的操作
     */
    private function _beforeAction() {
        echo "Before action in ProxySubject<br />\r\n";
    }

    /**
     * 请求后的操作
     */
    private function _afterAction() {
        echo "After action in ProxySubject<br />\r\n";
    }

}

/**
 * 客户端
 */
class Client {

    public static function main() {
        $subject = new ProxySubject();

        $subject->addSubject(new RealSubjectA());
        $subject->addSubject(new RealSubjectB());

        $subject->actionA();
        $subject->actionB();
    }

}

Client::main();
