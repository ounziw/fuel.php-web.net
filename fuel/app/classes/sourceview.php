<?php
/**
 * Source_View
 *
 * @author Fumito MIZUNO <mizuno@php-web.net>
 * @license LGPL 2.1 or later {@link http://www.gnu.org/copyleft/lesser.html}
 */
class SourceView extends ReflectionClass {
    protected $data = array();
    protected $methods_start_end = array();
    protected $inherited_methods = array();
    function __construct($reflect)
    {
        parent::__construct($reflect);
        $this->_createFileData();
        $this->_createMethodInfo();
    }
    /**
     * createFileData
     *
     * @access public
     * @return object
     */
    public function _createFileData() {
        $filename = $this->getFileName();
        if(!file_exists($filename)) {
            throw new RuntimeException("Classname " . $this->name . " is not found.");
        }
        if(false === $this->data = file($filename)) {
            throw new RuntimeException("Failed to open file: " . $filename);
        }
        return $this;
    }
    /**
     * outdata
     *
     * @param bool $escape
     * @access public
     * @return array
     */
    public function outData($escape='escape') {
        $startline = $this->getStartLine();
        $endline = $this->getEndLine();
        $out = array();
        // ソースコードの行数は1からスタートするが、配列は0からスタートする
        for($i=$startline-1;$i<$endline;$i++) {
            // 明示的に「エスケープしない」を選択しない限りエスケープする
            // 「エスケープしない」場合は、コード中に「not-escapte」と記述するので、エスケープしていないことが分かり易い
            if ('not-escape' == $escape) {
                $out[1+$i] = $this->data[$i];
            } else {
                $out[1+$i] = htmlspecialchars($this->data[$i],ENT_QUOTES,'UTF-8');
            }
        }
        return $out;
    }

    function getMethodStartEnd() {
        return $this->methods_start_end;
    }
    function getInheritedMethods() {
        return $this->inherited_methods;
    }
    function _createMethodInfo() {
        $methods = $this->getMethods();
        if(!is_array($methods)) {
            throw new InvalidArgumentException("getMethods not return array");
        }
        if(array() == $methods) {
            throw new InvalidArgumentException("getMethods return empty array");
        }
        foreach ($methods as $method)
        {
            $methodobj = new reflectionMethod($method->class,$method->name);
            if ($method->class == $this->name)
            {
                $this->methods_start_end[] = array(
                    'method'=>$method->name,
                    'start'=>$methodobj->getStartLine(),
                    'end'=>$methodobj->getEndLine(),
                );
            }
            else
            {
                $this->inherited_methods[] = array(
                    'method'=>$method->name,
                    'class'=>$method->class,
                );
            }
        }
        return $this;
    }
}
