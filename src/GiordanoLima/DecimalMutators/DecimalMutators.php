<?php

namespace GiordanoLima\DecimalMutators;

trait DecimalMutators
{
    private $decimalsOptionsDefault = [
        'setDecimalsFrom'  => ',',
        'setDecimalsTo'    => '.',
        'setThounsandFrom' => '.',
        'setThounsandTo'   => '',
        'getDecimalsFrom'  => '.',
        'getDecimalsTo'    => ',',
        'getThounsandFrom' => ',',
        'getThounsandTo'   => '',
        'decimals'   => 2,
    ];
    public static $disableGetMutator = false;
    public static $disableSetMutator = false;

    /**
     * Overriding the parent's method to apply the logic.
     *
     * @param string $key Field to test
     *
     * @return returns the value retuned by parent method
     */
    public function hasGetMutator($key)
    {
        if (property_exists($this, 'decimalsFields')) {
            if (is_array($this->decimalsFields) && in_array($key, $this->decimalsFields) && !self::$disableGetMutator) {
                return true;
            }
        }

        return parent::hasGetMutator($key);
    }

    /**
     * Overriding the parent's method to apply the logic.
     *
     * @param string $key   Field to mutate
     * @param string $value Value to mutate
     *
     * @return returns the value retuned by parent method
     */
    protected function mutateAttribute($key, $value)
    {
        if (in_array($key, $this->decimalsFields)) {
            return $this->getDecimal($value);
        } else {
            return parent::mutateAttribute($key, $value);
        }
    }

    /**
     * Overriding the parent's method to apply the logic.
     *
     * @param string $key Field to test
     *
     * @return returns the value retuned by parent method
     */
    public function hasSetMutator($key)
    {
        if (property_exists($this, 'decimalsFields')) {
            if (is_array($this->decimalsFields) && in_array($key, $this->decimalsFields) && !self::$disableSetMutator) {
                return true;
            }
        }

        return parent::hasSetMutator($key);
    }

    /**
     * Overriding the parent's method to apply the logic.
     *
     * @param string $key   Field to mutate
     * @param string $value Value to mutate
     *
     * @return returns the value retuned by parent method
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->decimalsFields)) {
            return $this->setDecimal($key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Transform the value.
     *
     * @param string $value Value to transform
     *
     * @return string the value formatted
     */
    private function getDecimal($value)
    {
        $decFrom = $this->decimalsOptionsDefault['getDecimalsFrom'];
        $thouFrom = $this->decimalsOptionsDefault['getThounsandFrom'];
        $decTo = $this->decimalsOptionsDefault['getDecimalsTo'];
        $thouTo = $this->decimalsOptionsDefault['getThounsandTo'];
        $decimals = $this->decimalsOptionsDefault['decimals'];
        if (property_exists($this, 'decimalsOptions') && is_array($this->decimalsOptions)) {
            if (array_key_exists('getDecimalsFrom', $this->decimalsOptions)) {
                $decFrom = $this->decimalsOptions['getDecimalsFrom'];
            }
            if (array_key_exists('getDecimalsTo', $this->decimalsOptions)) {
                $decTo = $this->decimalsOptions['getDecimalsTo'];
            }
            if (array_key_exists('getThounsandFrom', $this->decimalsOptions)) {
                $thouFrom = $this->decimalsOptions['getThounsandFrom'];
            }
            if (array_key_exists('getThounsandTo', $this->decimalsOptions)) {
                $thouTo = $this->decimalsOptions['getThounsandTo'];
            }
            if (array_key_exists('decimals', $this->decimalsOptions)) {
                $decimals = $this->decimalsOptions['decimals'];
            }
        }

        $parts = explode($decFrom, $value);
        $temp = str_replace($decFrom, '+++|||', str_replace($thouFrom, '|||+++', $value));
        $temp = str_replace(['|||+++', '+++|||'], ['', '.'], $temp);

        return number_format((float) $temp, $decimals, $decTo, $thouTo);
    }

    /**
     * Transform the value.
     *
     * @param string $key   The field that will receive the formatted value
     * @param string $value The value to transform
     *
     * @return The object $this
     */
    private function setDecimal($key, $value)
    {
        $decFrom = $this->decimalsOptionsDefault['setDecimalsFrom'];
        $decTo = $this->decimalsOptionsDefault['setDecimalsTo'];
        $thouFrom = $this->decimalsOptionsDefault['setThounsandFrom'];
        $thouTo = $this->decimalsOptionsDefault['setThounsandTo'];
        $decimals = $this->decimalsOptionsDefault['decimals'];
        if (property_exists($this, 'decimalsOptions') && is_array($this->decimalsOptions)) {
            if (array_key_exists('setDecimalsFrom', $this->decimalsOptions)) {
                $decFrom = $this->decimalsOptions['setDecimalsFrom'];
            }
            if (array_key_exists('setDecimalsTo', $this->decimalsOptions)) {
                $decTo = $this->decimalsOptions['setDecimalsTo'];
            }
            if (array_key_exists('setThounsandFrom', $this->decimalsOptions)) {
                $thouFrom = $this->decimalsOptions['setThounsandFrom'];
            }
            if (array_key_exists('setThounsandTo', $this->decimalsOptions)) {
                $thouTo = $this->decimalsOptions['setThounsandTo'];
            }
            if (array_key_exists('decimals', $this->decimalsOptions)) {
                $decimals = $this->decimalsOptions['decimals'];
            }
        }

        $parts = explode($decFrom, $value);
        $temp = str_replace($decFrom, '+++|||', str_replace($thouFrom, '|||+++', $value));
        $temp = str_replace(['|||+++', '+++|||'], ['', '.'], $temp);
        $this->attributes[$key] = number_format((float) $temp, $decimals, $decTo, $thouTo);

        return $this;
    }
}
