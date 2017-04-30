<?php

namespace com\rehyved\openid\client;


use com\rehyved\helper\JsonHelper;
use com\rehyved\openid\client\token\TokenResponseConstants;
use http\HttpStatus;

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

    public function withException(\Exception $exception)
    {
        $this->exception = $exception;
        $this->errorType = ResponseErrorType::EXCEPTION;
        return $this;
    }

    public function withErrorStatus(int $statusCode, string $reason)
    {
        $this->httpStatusCode = $statusCode;
        $this->httpErrorReason = $reason;

        if ($statusCode != HttpStatus::OK) {
            $this->errorType = ResponseErrorType::HTTP;
        }
        return $this;
    }

    public function isError(): bool
    {
        return !empty($this->getError());
    }

    public function getError(): string
    {
        if ($this->errorType === ResponseErrorType::HTTP) {
            return $this->httpErrorReason;
        } else if ($this->errorType == ResponseErrorType::EXCEPTION) {
            return $this->exception->getMessage();
        }

        return $this->json->{TokenResponseConstants::ERROR};
    }
}