<?php

namespace OAuth2\Client\Exception;

class IDPException extends \Exception
{
    protected $result;

    public function __construct($result)
    {
        $this->result = $result;

        $code = isset($result['code']) ? $result['code'] : 0;

        if (isset($result['error'])) {

            // OAuth 2.0 Draft 10 style
            $message = $result['error'];

        } elseif (isset($result['message'])) {

            // cURL style
            $message = $result['message'];

        } else {

            $message = 'Unknown Error.';

        }

        parent::__construct($message['message'], $message['code']);
    }

    public function getType()
    {
        if (isset($this->result['error'])) {

            $message = $this->result['error'];

            if (is_string($message)) {
                // OAuth 2.0 Draft 10 style
                return $message;
            }
        }

        return 'Exception';
    }

    /**
     * To make debugging easier.
     *
     * @returns
     *   The string representation of the error.
     */
    public function __toString()
    {
        $str = $this->getType() . ': ';

        if ($this->code != 0) {
            $str .= $this->code . ': ';
        }

        return $str . $this->message;
    }

}