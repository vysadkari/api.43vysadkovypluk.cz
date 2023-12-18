<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectionController extends BaseController
{
    private const DATE_FORMAT = 'Y-m-d';

    private const SELECTION_DATES_FILENAME = 'terminy-vr.txt';

    #[Route('/selection', name: 'selection')]
    public function selectionDates(): Response
    {
        $rawDates = $this->loadData(self::SELECTION_DATES_FILENAME, true);

        $filteredDates = [];
        foreach ($rawDates as $date) {
            $date = new \DateTime($date);

            if ($date < new \DateTime()) {
                continue;
            }

            $filteredDates[] = $date;
        }

        usort($filteredDates, function (\DateTime $a, \DateTime $b) {
            return $a <=> $b;
        });

        $dates = [
            "next" => null,
            "following" => [],
        ];

        if (count($filteredDates) > 0) {
            $dates["next"] = $filteredDates[0]->format(self::DATE_FORMAT);
            $dates["following"] = array_map(function ($date) {
                return $date->format(self::DATE_FORMAT);
            }, array_slice($filteredDates, 1));
        }

        return $this->sendJson($dates);
    }
}
