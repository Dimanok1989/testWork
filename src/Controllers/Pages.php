<?php

namespace Kolgaev\Controllers;

use Kolgaev\Response;

use Kolgaev\Models\Record;

class Pages {

    /**
     * Вывод главной страницы
     * 
     * @return Response
     */
    public function main() {

        $records = Record::count();

        return Response::view('main', [
            'records' => $records,
        ]);

    }

    /**
     * Вывод страницы с записями
     * 
     * @return Response
     */
    public function records() {

        $records = Record::count();

        return Response::view('records', [
            'records' => $records,
        ]);

    }

}