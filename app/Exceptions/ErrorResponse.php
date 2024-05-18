<?php

namespace App\Exceptions;

use Exception;

class ErrorResponse extends Exception
{

    private string $errorMessage;
    private int $errorStatus;

    public function __construct(string $errorMessage, int $errorStatus = 500)
    {
        $this->errorMessage = $errorMessage;
        $this->errorStatus = $errorStatus;
    }

    /**
     * Get the value of errorMessage
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set the value of errorMessage
     *
     * @return  self
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get the value of errorStatus
     */
    public function getErrorStatus()
    {
        return $this->errorStatus;
    }

    /**
     * Set the value of errorStatus
     *
     * @return  self
     */
    public function setErrorStatus($errorStatus)
    {
        $this->errorStatus = $errorStatus;

        return $this;
    }

    function getError(): array
    {
        return [
            'status'  => $this->errorStatus,
            'error'   =>  [
                'message' => $this->errorMessage,
                'status' =>  $this->errorStatus

                ]
        ];
    }
}
