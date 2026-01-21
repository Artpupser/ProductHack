<?php

namespace ProductHack\core;

enum ErrorType: int
{
	case SERVER = 0;
	case CLIENT = 1;
}

class ErrorStack
{
	private array $errors;
	public function __construct()
	{
		$this->errors[ErrorType::SERVER->value] = [];
		$this->errors[ErrorType::CLIENT->value] = [];
	}

	public function errorsIsEmpty(): bool
	{
		return $this->clientErrorsIsEmpty() && empty($this->errors[ErrorType::SERVER->value]);
	}

	public function clientErrorsIsEmpty(): bool
	{
		return empty($this->errors[ErrorType::CLIENT->value]);
	}

	public function serverErrorsIsEmpty(): bool
	{
		return empty($this->errors[ErrorType::SERVER->value]);
	}

	public function getClientErrors(): array
	{
		return $this->errors[ErrorType::CLIENT->value];
	}

	public function getServerErrors(): array
	{
		return $this->errors[ErrorType::SERVER->value];
	}

	public function pushServerError(int $code, string $message = ""): void
	{
		array_push($this->errors[ErrorType::SERVER->value], ["server_message" => $message, "code" => $code, "message" => self::httpCodeStatusMessage($code)]);
		Application::$app->response->setStatusCode($code);
	}

	public function pushClientError(string $id, string $message)
	{
		array_push($this->errors[ErrorType::CLIENT->value], ["id" => $id, "message" => $message]);
	}

	public static function httpCodeStatusMessage(int $code): string
	{
		$dict = [
			404 => "Not found",
			400 => "Request not valid",
			403 => "Access denied",
		];
		return $dict[$code];
	}
}