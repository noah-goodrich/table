<?php
/** 
 * @author noah
 * @date 3/2/11
 * @brief
 * 
*/

class Table {

	protected static $_types = array(
		'ajax',
		'dom'
	);

	protected static $_namespaces = array();

	protected $_actions = array();

	protected $_add = array();
	
	protected $_attr = array(
		'class' => 'display',
		'id' => 'table'
	);
	
	protected $_rowAttr = array(
		'class' => null,
		'id' => null
	);
	
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
					$this->setDataSource($config['data'], $v);
					break;
				case 'id':
					$this->attr('id', $v);
					break;
				case 'baseUrl':
					$this->setBaseUrl($v);
					break;
				case 'columns':
					$this->add($v);
					break;
			}
		}
		
	}

	/**
	 * @param array $array
	 * @return Table
	 */
	public function add(array $array)
	{
		if(isset($array['value']))
		{
			$array['baseUrl'] = $this->_baseUrl;
		
			$this->_columns[] = new \Table\Cell($array);
		}
		else
		{
			foreach($array as $column)
			{
				$this->add($column);
			}
		}
		
		return $this;
	}

	public function attr($attr, $value)
	{
		if($attr == 'class' && is_array($value))
		{
			$value = join(' ', $value);
		}
		
		$this->_attr[$attr] = $value;
		
		return $this;
	}

	/**
	 * @return void
	 */
	public function render()
	{
		$tbl_attr = '';
		
		foreach($this->_attr as $attr => $val) {
			$tbl_attr .= $attr.'="'.$val.'" ';	
		}
		
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
	public function setDataSource($data, $type = 'dom')
	{
		if(!in_array($type, self::$_types)) {
			throw new Exception('Invalid Data Source Type Specified');
		}

		$this->_type = $type;
		$this->_data = $data;

		return $this;
	}
}
