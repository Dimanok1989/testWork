<?php

namespace Kolgaev\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Kolgaev\Models\Record;

class Records {

    /**
     * Создание новой записи
     * 
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function addRecord(Request $request) {

        $errors = [];

        if (!$request->get('name'))
            $errors[] = ['name' => "name", 'message' => "Укажите имя"];

        if (!$request->get('phone'))
            $errors[] = ['name' => "phone", 'message' => "Укажите номер телефона"];
            
        if (!$request->get('email'))
            $errors[] = ['name' => "email", 'message' => "Укажите email"];
        else if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL))
            $errors[] = ['name' => "email", 'message' => "Email указан неверно"];

        if ($errors) {
            return new JsonResponse([
                'message' => "Данные заполнены неверно",
                'errors' => $errors,
            ], 400);
        }

        $record = Record::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
        ]);

        return new JsonResponse($record);

    }

    /**
     * Удаление записи
     * 
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function dropRecord(Request $request) {

        if (!$row = Record::find($request->get('id'))) {
            return new JsonResponse([
                'message' => "Запись не найдена, возможно она была удалена",
            ], 400);
        }

        $row->delete();

        return new JsonResponse(['message' => "Запись удалена"]);

    }

}