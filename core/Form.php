<?php

class Form{
    public $controller;
    public $errors;
    public function __construct($controller) {
        $this->controller=$controller ;
    }


function input($name,$label,$type="text",$rows=null,$cols=null){

    $error=false;
    //var_dump($this->errors);
    $classError='';
    $disabled= ($name=='id')?'disabled':'';
    if(!isset($this->controller->request->data->$name)){
        $value='';
    }elseif($name!='file'){
        $value=$this->controller->request->data->$name;
    }
    if($type=='hidden'){
        return '<input type="'.$type.'" name="'.$name.'"  value="'.$value.'">';
    }
    $html= '<div class ="form-group ">
            <label for="input'.$name.'">'.$label.'</label>
            ';
    if($type=='text'){
      $html.=  '<input type="'.$type.'" name="'.$name.'" id="input'.$name.'" class="form-control " value="'.$value.'" required '.$disabled.' >';
    }  elseif ($type=='textarea') {
    $attrib='rows ='.$rows.' cols='.$cols;

       $html.=  '<textarea class="wysiwyg" name="'.$name.'" id="input'.$name.'"'.$attrib.'  >'.$value.'</textarea>';
    }elseif ($type=='checkbox') {


        $html.=  '<input type="hidden" name="'.$name.'" value="0"><input type="checkbox"  name="'.$name.'" value="1"'.(empty($value)? '':'checked').'>';
    }elseif ($type=='file') {


        $html.=  '<input type="'.$type.'" name="'.$name.'" id="input'.$name.'" >';
    }elseif ($type=='password') {


        $html.=  '<input type="'.$type.'" name="'.$name.'" id="input'.$name.'" class="form-control col-sm-6" value="'.$value.'" required >';
    }
    elseif ($type=='email') {


        $html.=  '<input type="'.$type.'" name="'.$name.'" class="form-control" id="input'.$name.'"  required  >';
    }
    elseif ($type=='date') {


        $html.=  '<input type="'.$type.'" name="'.$name.'" id="input'.$name.'" class="form-control col-xs-4" value="'.$value.'" required   >';
    }

     $html.='</div>';
     return $html;
}
private function form($type, $name, $label){

        if(!isset($this->controller->request->data->$name)||($name=='password')){
        $value='';
        }else{
            $value=$this->controller->request->data->$name;
        }
        if($type == 'textarea'){
            $input = "<textarea  name=\"$name\" class=\"field-input\" id=\"input$name\" required>$value</textarea>";
        }else{
            $input = "<input type=\"$type\" name=\"$name\" class=\"field-input\" id=\"input$name\" value=\"$value\" required>";
        }
        return "<div class=\"field\">
            <label for=\"input$name\" class=\"field-label\">$label</label>
            $input
        </div>";
}
public function text($name, $label){
        return $this->form('text', $name, $label);
}
public function email($name, $label){
        return $this->form('email', $name, $label);
}
 public function select($name, $label, $options){
        $options_html = "";
        if(!isset($this->controller->request->data->name)){
        $value='';
        }elseif($name!='file'){
            $value=$this->controller->request->data->$name;
        }
        foreach($options as $k => $v){
            $selected = '';
            if($value == $k){
                $selected = ' selected';
            }
            $options_html .= "<option value=\"$k\"$selected>$v</option>";
        }
        return "<div class=\"field\">
            <label for=\"input$name\">$label</label>
            <select name=\"$name\" class=\"controls\" id=\"input$name\">$options_html</select>
        </div>";
}
public function textarea($name, $label){
        return $this->form('textarea', $name, $label);
}
public function password($name, $label){
        return $this->form('password', $name, $label);
}

public function submit($label){
        return '<button type="submit" class="btn btn-primary">' . $label . '</button>';
}

}

