<?php

namespace Rehyved\OpenId\Client;


use Rehyved\Utilities\JsonHelper;
use Rehyved\OpenId\Client\Token\TokenResponseConstants;
use Rehyved\http\HttpStatus;

class Response
{
    protected $raw;
    protected $json;
    protected $exception;
    protected $errorType = ResponseErrorType::NONE;
    protected $httpStatusCode;
    protected $httpErrorReason;

    private function __autoload()
    {
    }

    /**
     * Initializes a the instance of the Response class with a response.
     * @param string $raw
     * @return $this
     */
    public function withResponse(string $raw)
    {
        $this->raw = $raw;
        try {
            $this->json = JsonHelper::tryParse($raw);
        } catch (\Exception $e) {
            $this->errorType = ResponseErrorType::EXCEPTION;
            $this->exception = $e;
            return $this;
        }

        if (empty($this->getError())) {
            $this->httpStatusCode = HttpStatus::OK;
        } else {
            $this->httpStatusCode = HttpStatus::BAD_REQUEST;
            $this->errorType = ResponseErrorType::PROTOCOL;
        }
        return $this;
    }

    /**
     * Initializes a the instance of the Response class with an exception.
     * @param \Exception $exception
     * @return $this
     */
    public function withException(\Exception $exception)
    {
        $this->exception = $exception;
        $this->errorType = ResponseErrorType::EXCEPTION;
        return $this;
    }

    /**
     * Initializes a the instance of the Response class with an HTTP status code.
     * @param int $statusCode
     * @param string $reason
     * @return $this
     */
    public function withHttpStatus(int $statusCode, string $reason)
    {
        $this->httpStatusCode = $statusCode;
        $this->httpErrorReason = $reason;

        if ($statusCode != HttpStatus::OK) {
            $this->errorType = ResponseErrorType::HTTP;
        }
        return $this;
    }

    /**
     * Gets a value indicating whether an error occurred.
     * @return bool
     */
    public function isError(): bool
    {
        return !empty($this->getError());
    }

    /**
     * Gets the error
     * @return string
     */
    public function getError()
    {
        if ($this->errorType === ResponseErrorType::HTTP) {
            return $this->httpErrorReason;
        } else if ($this->errorType == ResponseErrorType::EXCEPTION) {
            return $this->exception->getMessage();
        }

        return $this->json->{TokenResponseConstants::ERROR};
    }

    /**
     * Gets the raw protocol response
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Gets the protocol response as JSON
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Gets the exception
     * @return mixed
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Sets the exception
     * @param mixed $exception
     */
    public function setException($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Gets the type of the error
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->errorType;
    }

    /**
     * Gets the HTTP status code
     * @return mixed
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the HTTP error reason
     * @return mixed
     */
    public function getHttpErrorReason()
    {
        return $this->httpErrorReason;
    }

}