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

	public function addColumn(array $array)
	{
		if(!isset($array['type'])) {
			$type = 'text';
		} else {
			$type = $array['type'];
		}

		unset($array['type']);

		$class = "\\DataTable\\Column\\".ucfirst($type);

		$this->_columns[$array['name']] = new $class($array);

		return $this;
	}

	public function addColumns(array $array)
	{
		foreach($array as $name => $config) {
			$config['name'] = $name;

			$this->addColumn($config);
		}

		return $this;
	}

	public function render()
	{
		 require 'views/dom.php';
	}

	public function setBaseUrl($url)
	{
		$this->_baseUrl = $url;

		return $this;
	}

	public function setDataSource($sourceType, $sourceData)
	{
		if(!in_array($sourceType, self::$_types)) {
			throw new Exception('Invalid Data Source Type Specified');
		}

		$this->_type = $sourceType;
		$this->_data = $sourceData;

		return $this;
	}

	public function setName($name)
	{
		$this->_name = $name;

		return $this;
	}
}
