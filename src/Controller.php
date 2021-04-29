<?php

namespace Kolgaev;

class Controller {

    /**
	 * Метод преобразования номера телефона в формат одних чисел или в читаемый формат
	 *
	 * @param string $str Номер телефона в любом формте
	 * @param bool|int $type Вид преобразования номера
	 * - 1 - 79001002030
     * - 2 - +79001002030
	 * - 3 - +7 (900) 100-20-30
	 * - false - 89001002030
	 * 
	 * @return string|bool
	 */
	public static function checkPhone($str, $type = false) {

		$num = preg_replace("/[^0-9]/", '', $str); // Удаление лишних символов из номера
		$strlen = strlen($num); // Длина номера

		// Добавление 7 в начало номера, если его длина меньше 11 цифр
		if ($strlen != 11 AND $strlen < 11)
			$num = "7" . $num;

		// Замена первой 8 на 7
		if ($strlen == 11)
			$num = "7" . substr($num, 1);

		// Проверка длины номера
		if (strlen($num) != 11)
			return false;

		if ($type === 1)
			return $num;

        if ($type === 2)
			return "+" . $num;

		if ($type === 3)
            return "+7 (" . substr($num, 1, 3) . ") " . substr($num, 4, 3) . "-" . substr($num, 7, 2) . "-" . substr($num, 9, 2);

		return "8" . substr($num, 1);

	}

}