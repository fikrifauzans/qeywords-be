<?php

namespace App\Handler\Response;

class Response
{

    const PARAMETER_INCLUDE    = 'include';
    const PARAMETER_PAGINATION = 'pagination';
    const PARAMETER_LINKS = 'links';


    private array $meta = [];
    private mixed $data = [];
    private int $status = 200;
    private string $message = 'Success';


    public function __construct(mixed $data = [], int $status = 200, string $message = '', array $meta = [])
    {
        $this->data = $data;
        $this->status = $status;
        $this->meta = $meta;
        $this->message = $message;
    }

    /**
     * Get the value of meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set the value of meta
     *
     * @return  self
     */
    public function setMeta($meta = [])
    {
        $array = [SELF::PARAMETER_INCLUDE => [...$meta]];

        $this->meta = [...$this->meta, ...$array];

        return $this;
    }


    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data = [])
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of data
     */
    public function getPaginationData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setPaginationData($data)
    {
        $this->data = $data->items();

        $pageInfo = [
            'currentPage'    => $data->currentPage(),
            'perPage'        => $data->perPage(),
            'total'          => $data->total(),
            'lastPage'       => $data->lastPage(),
        ];


        $this->meta = [
            Self::PARAMETER_PAGINATION => $pageInfo,
            Self::PARAMETER_LINKS      => $data->links()
        ];

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    function get()
    {
        return [
            'status'    => $this->getStatus(),
            'message'   => $this->getMessage(),
            'data'      => $this->getData(),
            'meta'      => $this->getMeta()
        ];
    }
}
