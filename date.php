<?php

/**
 * @param DateTime $currentDate Current date
 * @param string|null $time Time when we need to get the next date in format `H:i` - If null, we will skip this check completly
 * @param array $availibleDays Days availible in format `dd-mm-yyyy` - Will overwrite notAvailibleDays but NOT $time
 * @param array $excludingDays Days to exclude - in PHP date `N` format
 * @param array $notAvailibleDays Days not availible - In format `dd-mm-yyyy`
 * @param array $holidays Holidays - In format `dd-mm`
 * @return \DateTime
 */
function findDate(
    \DateTime
    $currentDate,
    $time,
    array $availibleDays,
    array $excludingDays,
    array $notAvailibleDays,
    array $holidays
) {
    while($currentDate) {
        if ($time !== null) {
            $today = new \DateTime();
            if ($currentDate->format('d-m-Y') == $today->format('d-m-Y')) {
                list($hour, $min) = explode(':', $time);
                if ($currentDate->format('H') > $hour) {
                    $currentDate->add(new \DateInterval('P1D'));
                    continue;
                }

                if ($currentDate->format('H') == $hour && $currentDate->format('i') > $min) {
                    $currentDate->add(new \DateInterval('P1D'));
                    continue;
                }
            }
        }

        if (in_array($currentDate->format('d-m-Y'), $availibleDays)) {
            break;
        }

        if (in_array($currentDate->format('N'), $excludingDays)) {
            $currentDate->add(new \DateInterval('P1D'));
            continue;
        }

        if (in_array($currentDate->format('d-m-Y'), $notAvailibleDays)) {
            $currentDate->add(new \DateInterval('P1D'));
            continue;
        }

        if (in_array($currentDate->format('d-m'), $holidays)) {
            $currentDate->add(new \DateInterval('P1D'));
            continue;
        }

        return $currentDate;
    }

    return $currentDate;
}
