<?php
/** 
 * @author noah
 * @date 3/2/11
 * @brief
 * 
*/

class DataTable
{
	protected static $_types = array(
		'server-side',
		'dom'
	);

	protected static $_availableActions = array(
		'add',
		'edit',
		'delete'
	);

	protected static $_namespaces = array();

	protected $_actions = array();

	protected $_columns = array();

	protected $_data;

	protected $_name;

	protected $_actionCount = 0;

	protected $_type;

	public static function autoload($class)
	{
		if(!count(self::$_namespaces)) {
			self::registerNamespace('DataTable', __DIR__);
		}
		
        $parts = explode("\\", $class);

        if(isset(self::$_namespaces[$parts[0]])) {
            $file = self::$_namespaces[$parts[0]].str_replace("\\", "/", $class).'.php';
            if(file_exists($file) && is_readable($file)) {
                require $file;
                return $class;
            }
        } else {
            $namespaces = array_reverse(self::$_namespaces);
            foreach ($namespaces as $ns => $path) {
                $file = $path.$ns.str_replace("\\", "/", $class).'.php';

                if(file_exists($file) && is_readable($file)) {
                    require $file;
                    return $ns . $class;
                }
            }
        }

        return false;
	}

	public static function registerNamespace($ns, $path)
	{
		if(substr($path, -1, 1) != '/') {
			$path .= '/';
		}

		self::$_namespaces[$ns] = $path;
	}

	public function __construct(array $config = array())
	{
		foreach($config as $k => $v) {
			switch($k) {
				case 'type':
					$this->setDataSource($v, $config['data']);
					break;
				case 'name':
					$this->setName($v);
					break;
				case 'baseUrl':
					$this->setBaseUrl($v);
					break;
			}
		}
		
	}

	/**
	 * @return array
	 */
	public function actions()
	{
		$_columns = $this->_columns;

		foreach($_columns as $key => $val) {
			if(!stristr($key, 'action')) {
				unset($_columns[$key]);
			}
		}

		return $_columns;
	}

	/**
	 * @param array $array
	 * @return DataTable
	 */
	public function addColumn(array $array)
	{
		if(!isset($array['type'])) {
			$type = 'text';
		} else {
			$type = $array['type'];
		}

		unset($array['type']);

		$class = "\\DataTable\\Column\\".ucfirst($type);

		if(isset($array['name']) && isset($array['header'])) {
			$this->_columns[$array['name']] = new $class($array);
		} else {
			$this->_columns['action'.$this->_actionCount++] = new $class($array);
		}


		return $this;
	}

	/**
	 * @param array $array
	 * @return DataTable
	 */
	public function addColumns(array $array)
	{
		foreach($array as $name => $config) {
			$config['name'] = $name;

			$this->addColumn($config);
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function columns()
	{
		$_columns = $this->_columns;

		foreach($_columns as $key => $val) {
			if(stristr($key, 'action')) {
				unset($_columns[$key]);
			}
		}

		return $_columns;
	}

	/**
	 * @return void
	 */
	public function render()
	{
		 require 'views/dom.php';
	}

	/**
	 * @param  $url
	 * @return DataTable
	 */
	public function setBaseUrl($url)
	{
		$this->_baseUrl = $url;

		return $this;
	}

	/**
	 * @throws Exception
	 * @param  $sourceType
	 * @param  $sourceData
	 * @return DataTable
	 */
	public function setDataSource($sourceType, $sourceData)
	{
		if(!in_array($sourceType, self::$_types)) {
			throw new Exception('Invalid Data Source Type Specified');
		}

		$this->_type = $sourceType;
		$this->_data = $sourceData;

		return $this;
	}

	/**
	 * @param  $name
	 * @return DataTable
	 */
	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}
}
