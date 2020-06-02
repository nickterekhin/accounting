<?php

namespace App\Helpers;


class RespondJScript
{
    var $_commands = array();

    function __construct()
    {

    }

    function remove($id)
    {
        $this->_commands[] = "$('".$id."').remove();";
    }

    function script($js)
    {
        $this->_commands[]=$js;
    }

	/**
     * @return string
     */
    function getOutput()
    {
        return implode("\n",$this->_commands);
    }

    function setHeader($header)
    {
        header($header);
    }
}