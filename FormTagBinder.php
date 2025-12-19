<?php

namespace Tanuki\Utils;

class FormTagBinder {
  private $data;

  public function __construct($data=[]){
    $this->data = $data;
  }

  public function has($key){
    return (bool)($this->data[$key] ?? false);
  }

  public function keys(){
    return array_keys($this->data);
  }

  public function input($type, $name, $props=[]){
    $val = $this->data[$name] ?? "";
    $propsString = $this->propsString($props);

    if(!\is_array($val)){
      $val = htmlspecialchars($val);
      return "<input type=\"{$type}\" id=\"input-{$name}\" name=\"{$name}\" value=\"{$val}\"{$propsString}>";

    }else{
      return implode("", array_map(function($val)use($type, $name, $propsString){
        $val = htmlspecialchars($val);
        return "<input type=\"{$type}\" name=\"{$name}[]\" value=\"{$val}\"{$propsString}>";
      }, $val));
    }
  }

  public function text($name, $props=[]){
    return $this->input("text", $name, $props);
  }

  public function email($name, $props=[]){
    return $this->input("email", $name, $props);
  }

  public function tel($name, $props=[]){
    return $this->input("tel", $name, $props);
  }

  public function number($name, $props=[]){
    return $this->input("number", $name, $props);
  }

  public function color($name, $props=[]){
    return $this->input("color", $name, $props);
  }

  public function date($name, $props=[]){
    return $this->input("date", $name, $props);
  }

  public function datetime($name, $props=[]){
    return $this->input("datetime-local", $name, $props);
  }

  public function hidden($name, $props=[]){
    return $this->input("hidden", $name, $props);
  }

  public function month($name, $props=[]){
    return $this->input("month", $name, $props);
  }

  public function password($name, $props=[]){
    return $this->input("password", $name, $props);
  }

  public function range($name, $props=[]){
    return $this->input("range", $name, $props);
  }

  public function search($name, $props=[]){
    return $this->input("search", $name, $props);
  }

  public function time($name, $props=[]){
    return $this->input("time", $name, $props);
  }

  public function url($name, $props=[]){
    return $this->input("url", $name, $props);
  }

  public function week($name, $props=[]){
    return $this->input("week", $name, $props);
  }

  public function textarea($name, $props=[]){
    $val = htmlspecialchars($this->data[$name] ?? "");
    $propsString = $this->propsString($props);

    return "<textarea id=\"input-{$name}\" name=\"{$name}\"{$propsString}>{$val}</textarea>";
  }

  public function checkbox($value, $name, $props=[]) {
    $checked = ($this->data[$name] ?? "") === $value ? " checked" : "";
    return "<input type=\"checkbox\" id=\"input-{$name}\" name=\"{$name}\" value=\"{$value}\"{$checked}>";
  }

  public function select($dataset, $name, $props=[]){
    $val = $this->data[$name] ?? "";
    $propsString = $this->propsString($props);

    $options = implode("", array_map(function($label, $v)use($val){
      if(is_int($label)) $label = $v;
      $selected = $v === $val ? " selected" : "";
      return "<option value=\"{$v}\"{$selected}>{$label}</option>";
    }, array_keys($dataset), array_values($dataset)));

    return "<select id=\"input-{$name}\" name=\"{$name}\"{$propsString}>{$options}</select>";
  }

  public function radios($dataset, $name){
    $firstOptionKey = array_keys($dataset)[0];
    if (is_int($firstOptionKey)) $firstOptionKey = array_values($dataset)[0];
    $val = $this->data[$name] ?? $firstOptionKey;

    $ret = [];

    $i = 1;
    foreach($dataset as $label => $v){
      $v = htmlspecialchars($v);
      if(is_int($label)) $label = $v;
      $checked = $v === $val ? " checked" : "";

      $ret[$label] = "<input type=\"radio\" id=\"input-{$name}-{$i}\" name=\"{$name}\" value=\"{$v}\"{$checked}>";
      $i++;
    }

    return $ret;
  }

  public function checkboxes($dataset, $name){
    $vals = $this->data[$name] ?? [];

    $ret = [];
    $i = 1;
    foreach($dataset as $label => $v){
      $v = htmlspecialchars($v);
      if(is_int($label)) $label = $v;
      $checked = in_array($v, $vals) ? " checked" : "";

      $ret[$label] = "<input type=\"checkbox\" id=\"input-{$name}-{$i}\" name=\"{$name}[]\" value=\"{$v}\"{$checked}>";
      $i++;
    }

    return $ret;
  }

  public function propsString($props){
    return " " . implode(" ", array_map(function($key, $val){
      return is_int($key) ? $val : "{$key}=\"{$val}\"";
    }, array_keys($props), array_values($props)));
  }
}
