<?php
/** 
 * @author noah
 * @date 3/2/11
 * @brief
 * 
*/

class Table {

	protected static $_types = array(
		'server-side',
		'dom'
	);

	protected static $_namespaces = array();

	protected $_actions = array();

	protected $_add = array();

	protected $_baseUrl;

	protected $_columns = array();

	protected $_data;

	protected $_name;

	protected $_actionCount = 0;

	protected $_type;

		/**
	 * @param  $file
	 * @return bool
	 */
    protected static function _findFile($file)
    {
        return file_exists($file) && is_readable($file);
    }

	/**
	 * @param  string $class
	 * @return bool|string
	 */
    public static function autoload($class)
    {
 		if(!count(self::$_namespaces)) {
			self::registerNamespace('Table', __DIR__.'/Table/');
		}
		
        $parts = explode("\\", $class);

        if(isset(self::$_namespaces[$parts[0]])) {
        	if(class_exists($class)) {
				return $class;
			} else {
				$path = $parts;
				unset($path[0]);

				$path = join('/', $path);

				$file = self::$_namespaces[$parts[0]].$path.'.php';
				if(self::_findFile($file)) {
					require $file;
					return $class;
				}
			}
        } else {
            $namespaces = array_reverse(self::$_namespaces);
            foreach ($namespaces as $ns => $path) {
            	if(substr($class, 0, 1) == '\\') {
            		$tmp = substr($class, 1);
            	} else {
					$tmp = $class;
            	}

                $file = $path.str_replace("\\", "/", $tmp).'.php';

                if(self::_findFile($file)) {
                	$class = $ns.$class;

                	if(class_exists($class)) {
                		return $class;
                	} else {
                		require $file;
                    	return $class;
                	}
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
				case 'columns':
					$this->addColumns($v);
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
	 * @return Table
	 */
	public function addColumn(array $array)
	{
		if(!isset($array['type'])) {
			$type = 'text';
		} else {
			$type = $array['type'];
		}

		unset($array['type']);
		$array['baseUrl'] = $this->_baseUrl;
		
		$class = "\\Table\\Column\\".ucfirst($type);

		if(isset($array['name']) && isset($array['header'])) {
			$this->_columns[$array['name']] = new $class($array);
		} else {
			$this->_columns['action'.$this->_actionCount++] = new $class($array);
		}


		return $this;
	}

	/**
	 * @param array $array
	 * @return Table
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
	 * @param array $config
	 * @return Table
	 */
	public function registerAdd(array $config)
	{
		if(!isset($config['classes'])) {
			$config['classes'] = array();
		}
		
		$this->_add = $config;

		return $this;
	}

	/**
	 * @return void
	 */
	public function render()
	{
		 require __DIR__.'/views/'.$this->_type.'.php';
	}

	/**
	 * @param  $url
	 * @return Table
	 */
	public function setBaseUrl($url)
	{
		if(substr($url, -1) != '/')
		{
			$url .= '/';
		}
		
		$this->_baseUrl = $url;

		return $this;
	}

	/**
	 * @throws Exception
	 * @param  $sourceType
	 * @param  $sourceData
	 * @return Table
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
	 * @return Table
	 */
	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}
}
