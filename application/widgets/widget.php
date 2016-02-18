<?php
/**
 * 单例模式实现widget.
 *
 * widget即小组件包含自己的控制器，视图，模型(可以共用普通model)。
 * 通常用来实现各页面都有的公共部分
 *
 * @author ricky
 * @since  2010/12/24 09:00
 */
class Widget extends CI_Controller
{
    /**
     * 静态ci对象
     */
    public static $_ci;

    /**
     * 私有构造函数用于实现单例模式
     */
    public function __construct()
    {
        parent::__construct();
        self::$_ci = & get_instance();//php 5.3中self改为static
       
       // var_dump($_ci);
       // exit;
      

    }
    /**
     * 获取当前类名
     */
    private static function _getClass()
    {
        return __CLASS__;
    }
    /**
     * 普通控制器方法
     */
    public static function footer()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('footer');
    }

        /**
     * 普通控制器方法
     */
    public static function navigate()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('navigate');
    }






    /**
     * 普通控制器方法
     */
    public static function head()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('home/home_head');
    }

    /**
     * 普通控制器方法
     */
    public static function header()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('widgets/header');
    }


    /**
     * 普通控制器方法
     */
    public static function top()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('home/home_top');
    }

    /**
     * 普通控制器方法
     */
    public static function sidebar()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        //$instance->load->view('home/home_sidebar');
        //echo __FUNCTION__;
    }

    /**
     * 普通控制器方法
     */
    public static function page_heade()
    {
        /**
         * 开发自己的方法必需包含此两行代码
         */
        $class = self::_getClass();
        //$instance = & new $class();//延迟绑定
        $instance = new $class();//延迟绑定

        $instance->load->view('home/home_page_head');
    }



}
