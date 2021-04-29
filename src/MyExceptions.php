<?php

namespace Kolgaev;

class MyExceptions extends \Exception {

    /**
     * Сообщение об ошибке
     * 
     * @var string|null
     */
    protected $message;

    /**
     * Путь до файла где произошла ошибка
     * 
     * @var string|null
     */
    protected $file;

    /**
     * Номер строки с ошибкой
     * 
     * @var int|null
     */
    protected $line;

    /**
     * Объявление объекта
     * 
     * @param string|null $message Сообщение об ошибке
     * @param string|null $file Путь до файла с ошибкой
     * @param int|null $line Номер строки с ошибкой
     */
    public function __construct($message = null, $file = null, $line = null, $code = 500) {

        $this->message = $message ?? "Неизвестная ошибка";
        $this->file = $file;
        $this->line = $line;

        if ($code)
            http_response_code($code);

    }

    /**
     * Метод вывода текста ошибки
     * 
     * @return null
     */
    public function getMessageError() {

        echo $this->message;

        echo $this->file ? "<br />В файле {$this->file}" : "";
        echo $this->file && $this->line ? ":" . $this->line : "";

        return null;

    }

}