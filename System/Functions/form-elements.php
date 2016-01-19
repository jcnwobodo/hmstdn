<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/29/2015
 * Time:    6:09 PM
 **/

function drop_num($upperpoint, $lowerpoint, $name, $current, $interval=1, $initial_val=NULL, $attr='class="form-control"')
{
    $return_value = '<select name="'.$name.'" id="'.$name.'" '.$attr.'>';
    if(!is_null($initial_val))
    {
        $return_value .= '<option value="NULL">'.$initial_val.'</option>';
    }
    for($yy = $lowerpoint; $yy <= $upperpoint; $yy+=$interval)
    {
        $return_value .= '<option value='.($yy).' '.selected( (int)$current, $yy).'>'.($yy).'</option>';
    }
    $return_value .= '</select>';
    return $return_value;
}

function drop_years($name, $current_val=null, $max=0, $min=0)
{
    $min = ($min == 0 ? date('Y') : $min);
    $max = ( ($max == 0 or $max < $min) ? date('Y') : $max);
    return drop_num($max, $min, $name, is_null($current_val) ? date('Y') : $current_val);
}

function drop_month($name, $current=null, $atr='class="form-control"')
{
    $months = array('January','February','March','April','May','June','July','August','September','October','November','December');
    $current = is_null($current) ? date('n') : $current;
    $return_value = '<select name="'.$name.'" '.$atr.'>';
    $mn = 1;
    foreach($months as $month)
    {
        $return_value .= '<option value="'.$mn.'" '.selected((int)$current, $mn).'>'.$month.'</option>';
        $mn++;
    }
    $return_value .= '</select>';
    return $return_value;
}

function drop_month_days($name, $current_val=null)
{
    return drop_num(31, 1, $name, is_null($current_val) ? date('j') : $current_val);
}

function drop_hours($name, $current_val=null, $mode12=true)
{
    return drop_num($mode12?12:23, $mode12?1:0, $name,  is_null($current_val) ? date('g') : $current_val);
}

function drop_minutes($name, $current_val=null)
{
    return drop_num(59, 0, $name, is_null($current_val) ? date('i') : $current_val);
}

function drop_AmPM($name, $current_val=null)
{
    $rv = "<select name='{$name}' class='form-control'>";
    $rv.= "<option value='AM' ".selected($current_val, 'AM').">AM</option>";
    $rv.= "<option value='PM' ".selected($current_val, 'PM').">PM</option>";
    $rv.= "</select>";

    return $rv;
}

function dropSex($name='sex',$selected='NULL',$width='33',$default_value='--select sex--')
{
    $str = '<select name="'.$name.'" id="'.$name.'" style="width:'.$width.'%; display:inline-block;">';
    $str .= '<option value="NULL">'.$default_value.'</option>';
    $str .= '<option value="FEMALE" '.selected('FEMALE',$selected).'>FEMALE</option>';
    $str .= '<option value="MALE" '.selected('MALE',$selected).'>MALE</option>';
    $str .= '</select>';
    return $str;
}
function selected($val1,$val2)
{
    if($val1 == $val2)
    {
        return 'selected="selected"';
    }
    return "";
}

function selected_multi($value, $name)
{
    if(! is_array($name)){$name = array(); }
    if(in_array($value,$name)) return 'selected="selected"';
}
function checked($value, $options)
{
    if(! is_array($options)){$options[] = $options; }
    if(in_array($value,$options)) return 'checked="checked"';
}
