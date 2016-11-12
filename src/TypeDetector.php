<?php
namespace Yarco\TypeDetector;

define('ORDED_TYPES', [
    'smallint', 'bigint', 'int', 'decimal', 'float', 
    'password', 'color', 'email', 'url',
    'date', 'time', 'datetime',
    'string', 'text'
]);

class TypeDetector
{
    private $_queue;
    private $_types;
    
    protected function initPriorityQueue()
    {
        $this->_queue = ORDED_TYPES;
    }
    
    protected function initTypeDefinitions()
    {
        $p = & $this->_types;
        $p['smallint'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_INT) && $value < 100;
        }; 
        $p['bigint'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_INT) && $value >= 10000;
        }; 
        $p['int'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_INT);
        }; 
        $p['decimal'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_FLOAT) && filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|\.\d{2,3}$|']]);
        }; 
        $p['float'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_FLOAT);
        }; 
        $p['password'] = function($name, $value) {
            return $value === '***';
        }; 
        $p['color'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^#[0-9a-fA-F]{6}$|']]);
        }; 
        $p['email'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }; 
        $p['url'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_URL);
        }; 
        $p['date'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^\d{2}/\d{2}/\d{4}$|']]) ||
                filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^\d{4}-\d{2}-\d{2}$|']]);
        }; 
        $p['time'] = function($name, $value) {
            return filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^\d{2}:\d{2}:\d{2}$|']]) ||
                filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^\d{2}:\d{2}$|']]);
        }; 
        $p['datetime'] = function($name, $value) {
            return strtotime($value) !== false || filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '|^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}(?::\d{2})?$|']]);
        }; 
        $p['string'] = function($name, $value) {
            return strlen($value) <= 27;
        }; 
        $p['text'] = function($name, $value) {
            return true;
        };        
    }
    
    protected function determine($k, $v)
    {
        foreach($this->_queue as $t) {
            $callback = $this->_types[$t];
            if (call_user_func($callback, $k, $v)) {
                return $t;
            }
        }
    }
    
    public function __construct()
    {
        $this->initPriorityQueue();
        $this->initTypeDefinitions();
    }
    
    public static function detect(array $array)
    {
        $ret = [];
        $obj = new self;
        foreach($array as $k => $v) {
            $ret[$k] = $obj->determine($k, $v);
        }
        return $ret;
    }
}