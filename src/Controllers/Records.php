<?php

namespace Kolgaev\Controllers;

use Kolgaev\Controller;
use Symfony\Component\HttpFoundation\Request;
use Kolgaev\Response;

use Kolgaev\Models\Record;

class Records extends Controller {

    /**
     * Создание новой записи
     * 
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Kolgaev\Response
     */
    public static function addRecord(Request $request) {

        $errors = [];

        if (!$request->get('name'))
            $errors[] = ['name' => "name", 'message' => "Введите имя клиента"];

        $phone = $request->get('phone');

        if (!$phone)
            $errors[] = ['name' => "phone", 'message' => "Введите номер телефона клиента"];
        elseif (!$phone = parent::checkPhone($phone, false))
            $errors[] = ['name' => "phone", 'message' => "Пожалуйста, укажите правильный номер телефона"];
        
        if (Record::where('phone', $phone)->count())
            $errors[] = ['name' => "phone", 'message' => "Этот номер телефона уже имеется в записях"];
            
        if (!$request->get('email'))
            $errors[] = ['name' => "email", 'message' => "Введите адрес электронной почты клиента"];
        else if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL))
            $errors[] = ['name' => "email", 'message' => "Пожалуйста, укажите правильный email адрес"];
        elseif (Record::where('email', $request->get('email'))->count())
            $errors[] = ['name' => "email", 'message' => "Этот адрес почты уже имеется в записях"];

        if ($errors) {
            return Response::json([
                'message' => "Данные заполнены неверно",
                'errors' => $errors,
            ], 400);
        }

        $record = Record::create([
            'name' => $request->get('name'),
            'phone' => $phone,
            'email' => $request->get('email'),
        ]);

        $record->phone = parent::checkPhone($phone, false);

        return Response::json([
            'message' => "Новая запись сохранена. Клиент {$record->name}, тел. {$record->phone}, email {$record->email}",
            'record' => $record,
            'count' => Record::count(),
        ]);

    }

    /**
     * Удаление записи
     * 
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Kolgaev\Response
     */
    public static function dropRecord(Request $request) {

        if (!$row = Record::find($request->get('id'))) {
            return Response::json([
                'message' => "Запись не найдена, возможно она была удалена",
            ], 400);
        }

        $row->delete();

        return Response::json(['message' => "Запись удалена"]);

    }

    /**
     * Вывод записей
     * 
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Kolgaev\Response
     */
    public static function showRecords(Request $request) {

        $limit = 20;
        $page = $request->get('page') ?? 1;
        $offset = $page > 1 ? (($limit * $page) - $limit) : 0;

        $count = Record::count();
        $last = ceil($count / $limit);
        $next = $page + 1;

        $search = $request->get('search');

        $data = new Record;

        if ($search) {

            $data = $data->where(function($query) use ($search) {
                
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");

                if ($phone = preg_replace('/[^0-9]/i', '', $search))
                    $query->orWhere('phone', 'LIKE', "%{$phone}%");

            });

        }

        $data = $data->orderBy('id', 'DESC')
        ->offset($offset)
        ->limit($limit)
        ->get();

        foreach ($data as $row) {

            $row->date = date("d.m.Y H:i", strtotime($row->created_at));
            $row->phone = parent::checkPhone($row->phone, false);

            $records[] = $row;

        }

        return Response::json([
            'records' => $records ?? [],
            'last' => $last,
            'next' => $next,
        ]);

    }

}