<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

trait JsonRespond
{
    /**
     * @var int
     */
    protected $httpStatusCode = 200;

    /**
     * @var int
     */
    protected $errorCode;

    /**
     * Получить HTTP статус код ответа.
     *
     * @return int
     */
    public function getHTTPStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Задать HTTP статус код ответа.
     *
     * @param  int  $statusCode
     * @return self
     */
    public function setHTTPStatusCode($statusCode)
    {
        $this->httpStatusCode = $statusCode;

        return $this;
    }

    /**
     * Получить код ошибки.
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Задать код ошибки.
     *
     * @param  int  $errorCode
     * @return self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Отправить данные в виде JSON.
     *
     * @param  array  $data данные для отправки
     * @param  array  $headers  [description]
     * @return JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getHTTPStatusCode(), $headers);
    }

    /**
     * Отправить ошибку не найдено (404)
     * Error Code = 31.
     *
     * @param  string  $message Сообщение об ошибке
     * @return JsonResponse
     */
    public function respondNotFound($message = null)
    {
        return $this->setHTTPStatusCode(404)
            ->setErrorCode(31)
            ->respondWithError($message);
    }

    /**
     * Отправить ошибку валидации
     * Error Code = 32.
     *
     * @param  Validator  $validator Экземпляр валидатора с ошибками
     * @return JsonResponse
     */
    public function respondValidatorFailed(Validator $validator)
    {
        return $this->setHTTPStatusCode(422)
            ->setErrorCode(32)
            ->respond(['error' => [
                'message' => 'Ошибка при валидации данных',
                'errors' => $validator->errors()
            ]]);
    }

    /**
     * Отправить ошибку валидации параметров.
     * Error Code = 33.
     *
     * @param  string  $message Сообщение об ошибке.
     * @return JsonResponse
     */
    public function respondNotTheRightParameters($message = null)
    {
        return $this->setHTTPStatusCode(500)
            ->setErrorCode(33)
            ->respondWithError($message);
    }

    /**
     * Отправить ошибку неправильного запроса (500).
     * Error Code = 40.
     *
     * @param  string  $message Сообщение об ошибке.
     * @return JsonResponse
     */
    public function respondInvalidQuery($message = null)
    {
        return $this->setHTTPStatusCode(500)
            ->setErrorCode(40)
            ->respondWithError($message);
    }

    /**
     * Отправить ошибку когда запрос имеет некорретные параметры.
     * Error Code = 41.
     *
     * @param  string  $message Сообщение об ошибке.
     * @return JsonResponse
     */
    public function respondInvalidParameters($message = null)
    {
        return $this->setHTTPStatusCode(422)
            ->setErrorCode(41)
            ->respondWithError($message);
    }

    /**
     * Отправить ошибку авторизации (401).
     * Error Code = 42.
     *
     * @param  string  $message 
     * @return JsonResponse
     */
    public function respondUnauthorized($message = null)
    {
        return $this->setHTTPStatusCode(401)
            ->setErrorCode(42)
            ->respondWithError($message);
    }

    /**
     * Отправить ошибку с сообщением.
     *
     * @param  string|array  $message Сообщение об ошибке.
     * @return JsonResponse
     */
    public function respondWithError($message = null)
    {
        return $this->respond([
            'error' => [
                // 'status_code' => $this->getHTTPStatusCode(),
                'message' => $message
                /** TODO: добавить получение сообщений из конфига */
                ,
                // 'error_code' => $this->getErrorCode(),
            ],
        ]);
    }

    /**
     * Отправить информацию того, что ресурс был успешно удален. 
     *
     * @param  int  $id Идентификатор удаленного ресурса.
     * @return JsonResponse
     */
    public function respondObjectDeleted($id)
    {
        return $this->respond([
            'deleted' => true,
            'id' => $id,
        ]);
    }
}
