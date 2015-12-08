<?php namespace GiordanoLima\DecimalMutators;

trait DecimalMutators
{
    
    private $decimalsOptionsDefault = [
        "setDecimalsFrom" => ",",
        "setDecimalsTo" => ".",
        "setThounsandFrom" => ".",
        "setThounsandTo" => "",
        "getDecimalsFrom" => ".",
        "getDecimalsTo" => ",",
        "getThounsandFrom" => ",",
        "getThounsandTo" => "",
    ];
    
    public function hasGetMutator($key)
    {
        if (property_exists($this, "decimalsFields")) {
            if (is_array($this->decimalsFields) && in_array($key, $this->decimalsFields)) {
                return true;
            }
        }
        return parent::hasGetMutator($key);
    }
    
    protected function mutateAttribute($key, $value)
    {
        if (in_array($key, $this->decimalsFields)) {
            return $this->getDecimal($value);
        } else {
            return parent::mutateAttribute($key, $value);
        }
    }
    public function hasSetMutator($key)
    {
        if (property_exists($this, "decimalsFields")) {
            if (is_array($this->decimalsFields) && in_array($key, $this->decimalsFields)) {
                return true;
            }
        }
        return parent::hasSetMutator($key);
    }
    
    public function setAttribute($key, $value)
    {       
        if (in_array($key, $this->decimalsFields)) {
            return $this->setDecimal($key,$value);
        }
        return parent::setAttribute($key, $value);
        
    }
    
    private function getDecimal($value)
    {
        $decFrom = $this->decimalsOptionsDefault["getDecimalsFrom"];
        $decTo = $this->decimalsOptionsDefault["getDecimalsTo"];
        $thouFrom = $this->decimalsOptionsDefault["getThounsandFrom"];
        $thouTo = $this->decimalsOptionsDefault["getThounsandTo"];
        if (property_exists($this, "decimalsOptions") && is_array($this->decimalsOptions)) {
            if(array_key_exists("getDecimalsFrom", $this->decimalsOptions))
                $decFrom = $this->decimalsOptions["getDecimalsFrom"];
            if(array_key_exists("getDecimalsTo", $this->decimalsOptions))
                $decTo = $this->decimalsOptions["getDecimalsTo"];
            if(array_key_exists("getThounsandFrom", $this->decimalsOptions))
                $thouFrom = $this->decimalsOptions["getThounsandFrom"];
            if(array_key_exists("getThounsandTo", $this->decimalsOptions))
                $thouTo = $this->decimalsOptions["getThounsandTo"];
        }
        return str_replace($decFrom, $decTo, str_replace($thouFrom, $thouTo, $value));
    }
    
    private function setDecimal($key,$value)
    {
        $decFrom = $this->decimalsOptionsDefault["setDecimalsFrom"];
        $decTo = $this->decimalsOptionsDefault["setDecimalsTo"];
        $thouFrom = $this->decimalsOptionsDefault["setThounsandFrom"];
        $thouTo = $this->decimalsOptionsDefault["setThounsandTo"];
        if (property_exists($this, "decimalsOptions") && is_array($this->decimalsOptions)) {
            if(array_key_exists("setDecimalsFrom", $this->decimalsOptions))
                $decFrom = $this->decimalsOptions["setDecimalsFrom"];
            if(array_key_exists("setDecimalsTo", $this->decimalsOptions))
                $decTo = $this->decimalsOptions["setDecimalsTo"];
            if(array_key_exists("setThounsandFrom", $this->decimalsOptions))
                $thouFrom = $this->decimalsOptions["setThounsandFrom"];
            if(array_key_exists("setThounsandTo", $this->decimalsOptions))
                $thouTo = $this->decimalsOptions["setThounsandTo"];
        }
        $this->attributes[$key] = str_replace($decFrom, $decTo, str_replace($thouFrom, $thouTo, $value));
        return $this;
    }
}