<?php defined('INDEX_PAGE') or die('no entrance');
/**
 * 数据库模型，建议继承此模型
 * 
 * filename:	model.php
 * charset:		UTF-8
 * create date: 2012-5-25
 * update date: 2012-8-14 改用单例模式，调用方法发生变化，具体方式见类说明
 * update date: 2012-9-20 更新单例模式，启用新数据库配置时重新链接，增加数据库时间检测
 * update date: 2012-12-24 对内不同库多次实例，改善主从机制，一个主库配一个从库
 * 	                       （若存在多个从库，可在数据库配置文件跟据一定算法确定具体库）
 * update date: 2012-12-25 更新命名规范，方法下划线，属性下划线
 *
 * @author Zhao Binyan <itbudaoweng@gmail.com>
 * @copyright 2011-2012 Zhao Binyan
 * @link http://yungbo.com
 * @link http://weibo.com/itbudaoweng
 */

/**
 * 模型基类
 * 
 * 如需显示sql请提前设置 xxx::$show_sql 为 true
 * $model = Model::singleton();
 * $model->query();
 * $model->db->query();
 * $model->db_slave->query();
 * 以下注释中，Model 也可以是其子类，不再赘述 
 * 
 * 或者直接不用此模型类
 * $model = db_init();//默认使用主数据库，db_init() 直接连库，返回一个 Mysqli 实例
 * 
 * @author Think
 */
class DbDriver {

	//连接之后的数据库资源
	public $db;
	
	//从数据库资源
	public $db_slave;

	//数据表名
	public $tb_name;
		
	//是否输出 sql 语句
	public static $show_sql;

	//当前实例数据库组
	public $db_group;

	//所有的连库资源，array
	public static $connection_arr;

	//实例的对象
	private static $singleton;
	
	/**
	 * 连接数据库
	 * @param string $db_group 数据库组 default 
	 */
	private function __construct($db_group = 'default') {

        switch (SYS_MODE) {
            case 'development' : self::$show_sql = TRUE;
                break;
            case 'testing' : self::$show_sql = FALSE;
                break;
            case 'production' : self::$show_sql = FALSE;
                break;
            default : self::$show_sql = FALSE;
        }

		return self::connect($db_group);
	}
	
	/**
	 * 不是单例了
	 * 只是为了用最少次数去链接数据库
	 * Model::singleton()
	 * @param string $tb_name 默认表名，使用过程中可以随时变更 Model::$tb_name = 'new_tb_name';
	 * @param string $db_group 数据库配置文件
	 */
	public static function singleton($db_group = 'default') {
	
		//当不存在对象或者启用新的数据库时重新连库
		if (!(self::$singleton instanceof self)) {
			self::$singleton = new self($db_group);
			self::$connection_arr[$db_group] = self::$singleton;
		} else if (!isset(self::$connection_arr[$db_group])) {
			self::$singleton = new self($db_group);
			self::$connection_arr[$db_group] = self::$singleton;
		} else {
			self::$singleton = self::$connection_arr[$db_group];
		}

		return self::$singleton;
	}
	
	private function connect($db_group = 'default') {
		$t1 = microtime(true);
		$this->db = db_init($db_group);
		$this->db_group = $db_group;
		$t2 = microtime(true);
		
		if (self::$show_sql) {
			$time = $this->timer($t1, $t2);
			echo "db group ${db_group} contructed!<br>\r\n",
			"db connection: $time<br>\n";
		}
	
		if (array_key_exists($db_group . '_slave', get_conf('db_conf'))) {
			$this->db_slave = db_init($db_group . '_slave');
		}
	}

    /**
     * 设置待操作表名
     *
     * @author  ichou   <xwormc@gamil.com>  2013/02/22
     * @param   string  $tb_name
     */
    public function set_table($tb_name) {
        $tb_name && $this->tb_name = $tb_name;
    }

	/**
	 * 增加数据
	 * $data
	 * array('id'=>'3', 'username'=>'胡锦涛')
	 * INSERT INTO `user` (`id`, `username`, `password`) 
	 * VALUES (NULL, '胡锦涛', '123456abc');
	 */
	public function insert($data = array()) {
		//组合后的 sql 语句
		$sql = '';

		if (!$this->tb_name) {
			return false;
		}

		//组合后的字段
		$fields = '';
		//组合后的字段值
		$values = '';

		foreach ($data as $key => $value) {
			$key = str_replace('`', '', $key);
			$fields .= ", `$key`";//whatch out the space bettwen `
			$values .= ", " . check_input($value); //过滤下
		}
		
		$fields = trim($fields, ', ');
		$values = trim($values, ', ');
		
		$sql .= 'INSERT INTO';
		$sql .= ' `' . $this->tb_name . '`';
		$sql .= ' (' . $fields . ') ';
		$sql .= ' VALUES (' . $values . ')';
		$ret = $this->query($sql);

		if ($ret) {
			$ret = $this->db->insert_id;
		}

		return $ret;
	}
	
	/**
	 * 删除数据，参数为必须
	 * @param string $where WHERE 条件以及后续语句
	 * @return bool $q 只要语句正常执行了就会是 true
	 */
	public function delete($where = null) {
		if (!$this->tb_name) {
			return false;
		}
		$sql = '';
		$q = false;

		$sqlwhere = ' WHERE ' . trim($where);

		$sql = 'DELETE FROM `' . $this->tb_name . '`' . $sqlwhere;
		if (!is_null($where)) {
			$q = $this->query($sql);
		} else {
			show_error("sql error: $sql");
		}

		return $q;
	}
	
	/**
	 * 修改数据，参数为必须
	 * @param string|array $data
	 * @param string $where WHERE 条件以及后续语句
	 * @return bool $q 只有语句执行成功就返回 true
	 */
	public function update($data = array(), $where = null) {
		if (!$this->tb_name) {
			return false;
		}
		$sql = '';
		$q = false;
		
		$sqlwhere       = ' WHERE ' . trim($where);

		$update_data = '';
		
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$update_data .= ", `{$k}` = " . check_input($v);
			}
		} else {
			$update_data = $data;
		}
		
		$update_data = trim($update_data, ', ');
		
		$sql = 'UPDATE `' . $this->tb_name . '` SET ' . $update_data . $sqlwhere;

		if (!is_null($where)) {
			$q = $this->query($sql);
		} else {
			show_error("sql error: $sql");
		}

		return $q;
	}
	
	/**
	 * 查询数据
	 * @param string|array $field
	 * @param string $where WHERE 条件，及limit等片段
	 * @return array $ret
	 */
	public function select($field = '*', $where = null) {
		if (!$this->tb_name) {
			return array();
		}
		$ret       = array();
		$field_new = '';
		if (is_array($field)) {
			foreach ($field as $f) {
				$field_new .= ', `' . $f . '`';
			}
		} else {
			$field_new = $field;
		}
		$field_new = trim($field_new, ',');
		
		is_null($where) or $where = ' WHERE ' . trim($where);
		
		$sql = 'SELECT ' . $field_new . ' FROM `' . $this->tb_name . '`' . $where;

		$q = $this->query($sql);
		
		if ($q && $q->num_rows > 0) {
			//mysqli_result::fetch_assoc
			while ($r = $q->fetch_assoc()) {
				$ret[] = $r;
			}
			$q->close();
		}

		return $ret;
	}
	
	/**
	 * 查询一行数据
	 * @param string|array $field
	 * @param string $where
	 * @return array $ret
	 */
	public function select_line($field = '*', $where = null) {
		if (!$this->tb_name) {
			return array();
		}
		$ret       = array();
		$field_new = '';
		if (is_array($field)) {
			foreach ($field as $f) {
				$field_new .= ', `' . $f . '`';
			}
		} else {
			$field_new = $field;
		}
		$field_new = trim($field_new, ',');
		
		!$where or $where = ' WHERE ' . trim($where);
		
		$sql = 'SELECT ' . $field_new . ' FROM `' . $this->tb_name . '`' . $where . ' LIMIT 1';
		
		//仅仅查询一条数据
		$sql = preg_replace('/limit.*/i', 'LIMIT 1', $sql);
		$q = $this->query($sql);

		if ($q && $q->num_rows > 0) {
			//mysqli_result::fetch_assoc
			$ret = $q->fetch_assoc();
			$q->close();
		}

		return $ret;
	}
	
	/**
	 * 主 query 函数，超时重连
	 * 提供原生的查询接口，并且自动设置主从
	 * @param string $sql
	 */
	public function query($sql) {
		$t1 = microtime(true);
		$sql = trim($sql);
		$ret = array();

		//如果是查库
		if (preg_match('/^select /i', $sql)) {
			if ($this->db_slave) {
				$ret = $this->_base_slave_query($sql);
			} else {
				$ret = $this->_base_query($sql);
			}
		} else {
			$ret = $this->_base_query($sql);
		}

		$t2 = microtime(true);
		self::show_mysql($sql, $t1, $t2);
		return $ret;
	}

    /**
     * 调用主 query 函数 并将结果转化成数组返回
     * @author  ichou   <xwormc@gmial.com>  2013/02/17
     * @param   string  $sql
     * @return  array
     */
    public function query2array($sql) {
        $q = $this->query($sql);
        if ($q && $q->num_rows > 0) {
            //mysqli_result::fetch_assoc
            while ($r = $q->fetch_assoc()) {
                $ret[] = $r;
            }
            $q->close();
        }

        return $ret;
    }

	//主库基础查询
	private function _base_query($sql) {
		if (!$this->db->ping() or $this->db->errno == 2006) {
			$this->connect($this->db_group);
		}
		$ret = $this->db->query($sql);
		return $ret;
	}

	//从库基础查询
	private function _base_slave_query($sql) {
		if (!$this->db_slave->ping() or $this->db_slave->errno == 2006) {
			$this->connect($this->db_group);
		}
		$ret = $this->db_slave->query($sql);
		return $ret;
	}
	
	/**
	 * 是否显示 sql
	 * @param string $sql
	 */
	public static function show_mysql($sql, $t1 = 0, $t2 = 0) {
		if (self::$show_sql) {
			$time = self::$singleton->timer($t1, $t2);
			echo "$sql<br>\n$time<br>\n";
		}
	}

	/**
	 * 计时器，从 $t1 到 $t2 消耗的时间
	 */
	public function timer($t1 = 0, $t2 = 0) {
		$t = $t2 - $t1;
		if ($t > 1) {
			$t = "<span style='color:red'>$t seconds</span>";
		} else {
			$t = "<span style='color:green'>$t seconds</span>";
		}
		return $t;
	}

	public final function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
	
	/**
	 * 关闭数据库
	 */
	public function __destruct() {
		//echo "model destructed!<br>\r\n";
		if ($this->db) {
			
			if ($this->db->errno) {
				show_error($this->db->errno . ':' . $this->db->error);
			}
			$this->db->close();
		}
		
		if ($this->db_slave) {
			$this->db_slave->close();
		}
	}
}
