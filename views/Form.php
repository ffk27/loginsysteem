<?php

/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/19/2017
 * Time: 6:06 PM
 */
class Form
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var array
     */
    private $fields;
    /**
     * @var string
     */
    private $submitname;
    /**
     * @var string
     */
    private $controller;

    function __construct($id,$fields,$submitname,$method,$controller)
    {
        $this->id=$id;
        $this->fields=$fields;
        $this->submitname=$submitname;
        $this->method=$method;
        $this->controller=$controller;
    }

    /**
     * @return string
     */
    function html() {
        if (count($this->fields) > 0) {
            require_once '../utils.php';
            $html = $this->js();
            $html .= "\n";
            $html .= '<form id="'.$this->id.'">';
            $html .= "\n<table id=\"form\">\n";
            for ($i=0; $i<count($this->fields); $i++) {
                $text = read_array('text',$this->fields[$i]);
                $name = read_array('name',$this->fields[$i]);
                $type = read_array('type',$this->fields[$i]);
                $value = read_array('value',$this->fields[$i]);
                if (!$type) { $type='text'; }
                $required = read_array('required',$this->fields[$i]);
                $minlength = read_array('minlength',$this->fields[$i]);
                $maxlength = read_array('maxlength',$this->fields[$i]);
                $pattern = read_array('pattern',$this->fields[$i]);
                $onchange = read_array('onchange',$this->fields[$i]);
                $onkeypress = read_array('onkeypress',$this->fields[$i]);

                $html .= '<tr><td>'.$text.':</td>';
                $html .= '<td><input type="'.$type.'" ';
                if ($required) { $html.= 'required '; }
                $html .= 'name="'.$name.'" ';
                if ($minlength) { $html.= 'minlength="'.$minlength.'" '; }
                if ($maxlength) { $html.= 'maxlength="'.$maxlength.'" '; }
                if ($pattern) { $html.= 'pattern="'.$pattern.'" '; }
                if ($onchange) { $html.= 'onchange="'.$onchange.'" '; }
                if ($onkeypress) { $html.= 'onkeypress="'.$onkeypress.'" '; }
                $html .= '/></td></tr>';
                $html .= "\n";
            }
            $html .= "</table>\n";
            $html .= '<div id="errors"></div>';
            $html .= '<input type="submit" value="'.$this->submitname.'"/>';
            $html .= "\n</form>\n";
        }
        return $html;
    }

    function js(){
        $html = <<<EOT
        
        <script>
        $(document).ready(function () {
            var form=$('#{$this->id}');
            form.submit(function (e) {
                e.preventDefault();
                submit();
            });
        });

        function submit() {
            $.ajax({
                url: 'controller.php?c={$this->controller}&a={$this->method}',data: {
EOT;
        for ($i=0; $i<count($this->fields); $i++) {
            $name = read_array('name',$this->fields[$i]);
            $html.=$name.':$(\'[name="'.$name.'"]\').val(),';
        }
        $html = substr($html,0,strlen($html)-1);
        $html.= <<<EOT
                },method: '{$this->method}',
                success: function (json) {
                    console.log(json);
                    if (json.code===1) {
                        setContent('login');
                    }
                    else  {
                        $('#errors').html(json.error);
                    }
                },
                dataType: 'json'
            });
        }
        </script>

EOT;
        return $html;
    }

    /**
     * @param array $data $_GET or G_POST
     * @return bool
     */
    function isValidData($data) {
        require_once '../utils.php';

        foreach ($this->fields as $field) {
            $name = read_array('name',$field);
            $value = read_array($name,$data);
            $required = read_array('required',$field);
            $minlength = read_array('minlength',$field);
            $maxlength = read_array('maxlength',$field);
            $pattern = read_array('pattern',$field);
            if ($value !== null) {
                if ($required && strlen($value)===0) {
                    return false;
                }
                if ($minlength !== null && strlen($value) < $minlength) {
                    return false;
                }
                if ($maxlength !== null && strlen($value) > $maxlength) {
                    return false;
                }
                if ($pattern !==null && !preg_match('/'.$pattern.'/',$value)) {
                    return false;
                }
            }
            else if ($required) {
                return false;
            }
        }
        return true;
    }
}