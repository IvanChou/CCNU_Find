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

    /**
     * Get a Db Link Instance of the given table.
     *
     * @author    ichou    <xwormc@gmial.com>    2013/01/31
     * @param    string    $table    The given table's name.
     * @param    string    $group    The database setting group name.
     * @return    object|false
     */
    protected function set_db_table($table = null, $group = 'default')
    {
        if ($table == null) {
            log_error("the function \"set_db_table\" must have a parm as table name.");
            show_error("the function \"set_db_table\" must have a parm as table name.");
            die();
        }
        return DbDriver::singleton($table, 'default');
    }

}
