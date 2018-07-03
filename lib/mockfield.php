<?php
/**
 * Created by PhpStorm.
 * User: mrunkel
 * Date: 6/19/18
 * Time: 3:34 PM
 */

namespace Plusforta;

/**
 * Class mockField
 * @package Plusforta
 */
class MockField extends \Obj
{
    public $key;
    public $value;
    public $page;

    public function __construct(string $key, $value = null)
    {
        $this->key   = $key;
        $this->value = $value;
        $this->page  = page();
    }

    public function structure()
    {
        return $this->toStructure();
    }

    public function toStructure()
    {
        if (!is_array($this->value)) {
            return false;
        }
        $structure = [];
        $fields = [];
        foreach ($this->value as $instance) {
            foreach ($instance as $key => $value) {
                $fields[$key] = $value;
            }
            $structure[] = new mockModule($fields);
            $fields = [];
        }
        return $structure;
    }

    /**
     * Returns the parent page object
     *
     * @return \PageAbstract
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * Makes it possible to convert the
     * object to a string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * Returns the field value
     *
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }

    /**
     * Improved var_dump() output
     *
     * @return array
     */
    public function __debuginfo()
    {
        return [
            'page'  => $this->page(),
            'key'   => $this->key(),
            'value' => $this->value()
        ];
    }

    public function h($keepTags = true)
    {
        return $this->html($keepTags);
    }

    public function html($keepTags = true)
    {
        $this->value = html($this->value, $keepTags);

        return $this;
    }

    public function esc($context = 'html')
    {
        return $this->escape($context);
    }


    public function escape($context = 'html')
    {
        $this->value = esc($this->value, $context);

        return $this;
    }


    public function x()
    {
        return $this->xml();
    }


    public function xml()
    {
        $this->value = xml($this->value);

        return $this;
    }


    public function kt()
    {
        return $this->kirbytext();
    }


    public function kirbytext()
    {
        $this->value = kirbytext($this->value);

        return $this;
    }


    public function kirbytextSans()
    {
        $this->value = kirbytextSans($this->value);

        return $this;
    }


    public function md()
    {
        return $this->markdown();
    }


    public function markdown()
    {
        $this->value = markdown($this->value);

        return $this;
    }


    public function sp()
    {
        return $this->smartypants();
    }


    public function smartypants()
    {
        $this->value = smartypants($this->value);

        return $this;
    }


    public function lower()
    {
        $this->value = \str::lower($this->value);

        return $this;
    }


    public function upper()
    {
        $this->value = \str::upper($this->value);

        return $this;
    }


    public function widont()
    {
        $this->value = widont($this->value);

        return $this;
    }


    public function excerpt($chars = 140, $mode = 'chars')
    {
        return excerpt($this, $chars, $mode);
    }


    public function short($length, $rep = '…')
    {
        return \str::short($this->value, $length, $rep);
    }


    public function length()
    {
        return \str::length($this->value);
    }


    public function words()
    {
        return str_word_count(strip_tags($this->value));
    }

    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    public function isEmpty()
    {
        return empty($this->value);
    }

    public function toPage()
    {
        return page($this->value);
    }

    public function pages($sep = null)
    {
        return $this->toPages($sep);
    }

    public function toPages($sep = null)
    {
        if ($sep !== null) {
            $array = $this->split($sep);
        } else {
            $array = $this->yaml();
        }

        return pages($array);
    }

    public function split($separator = ',')
    {
        return \str::split($this->value, $separator);
    }

    public function yaml()
    {
        return yaml($this->value);
    }

    public function toFile()
    {
        return $this->page()->file($this->value);
    }

    public function or($fallback = null)
    {
        return $this->empty() ? $fallback : $this;
    }

    public function empty()
    {
        return empty($this->value);
    }

    public function bool($default = false)
    {
        return $this->isTrue($default);
    }

    public function isFalse()
    {
        return !$this->isTrue();
    }

    public function isTrue($default = false)
    {
        $val = $this->empty() ? $default : $this->value;

        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    public function int($default = 0)
    {
        $val = $this->empty ? $default : $this->value;

        return intval($val);
    }


    public function float($default = 0.0)
    {
        $val = $this->empty ? $default : $this->value;

        return floatval($val);
    }


    public function link($attr1 = [], $attr2 = [])
    {
        $a = new \Brick('a', $this->value);

        if (is_string($attr1)) {
            $a->attr('href', url($attr1));
            $a->attr($attr2);
        } else {
            $a->attr('href', $this->page()->url());
            $a->attr($attr1);
        }

        return $a;
    }


    public function url()
    {
        return url($this->value);
    }


    public function toUrl()
    {
        return $this->url();
    }


    public function maxWidth()
    {
        return maxWidth($this->value);
    }
}
