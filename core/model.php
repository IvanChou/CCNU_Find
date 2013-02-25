<?php defined('INDEX_PAGE') or die('no entrance'); ?>
<?php
/**
 * 模型原型
 * 建议继承此原型，后期可能会写功能
 *
 * filename:    model.php
 * charset:        UTF-8
 * create date: 2013-1-31
 *
 */

abstract class Model
{

    public function __construct() {
        $this->db = $this->connect_db();
    }

    /**
     * Get a Db Link Instance
     *
     * @author  ichou   <xwormc@gmial.com>  2013/01/31
     * @param   string  $group  The database setting group name.
     * @return  object
     */
    protected function connect_db($group = 'default')
    {
        return DbDriver::singleton($group);
    }

}
