<?php

namespace ProductHack\core;

enum ErrorType
{
	case SERVER;
	case CLIENT;
}

class ErrorStack
{
	private array $errors;
	public function __construct()
	{
		$this->errors[ErrorType::SERVER->name] = [];
		$this->errors[ErrorType::CLIENT->name] = [];
	}

	public function errorsIsEmpty(): bool
	{
		return $this->clientErrorsIsEmpty() && empty($this->errors[ErrorType::SERVER->name]);
	}

	public function clientErrorsIsEmpty(): bool
	{
		return empty($this->errors[ErrorType::CLIENT->name]);
	}

	public function serverErrorsIsEmpty(): bool
	{
		return empty($this->errors[ErrorType::SERVER->name]);
	}

	public function getClientErrors(): array
	{
		return $this->errors[ErrorType::CLIENT->name];
	}

	public function getServerErrors(): array
	{
		return $this->errors[ErrorType::SERVER->name];
	}

	public function pushServerError(int $code, string $message = ""): void
	{
		array_push($this->errors[ErrorType::SERVER->name], ["server_message" => $message, "code" => $code, "message" => self::httpCodeStatusMessage($code)]);
	}

	public function pushClientError(string $id, string $message)
	{
		array_push($this->errors[ErrorType::CLIENT->name], ["id" => $id, "message" => $message]);
	}

	public static function httpCodeStatusMessage(int $code): string
	{
		$dict = [
			404 => "Page not found",
			400 => "Request not valid",
			403 => "Access denied",
		];
		return $dict[$code];
	}
}