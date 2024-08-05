<?php

namespace App\Traits;

trait Parser
{
    protected const DATE_FORMAT = 'd/m/Y H:i:s';


    private function parseUsers($users): array
    {
        $arrayCollection = array();

        foreach($users as $item) {
            $arrayCollection[] = $this->parseUser($item);
        }

        return $arrayCollection;
    }


    private function parseUser($item): array
    {
        
        return array(
            'id' => $item->getId(),
            'nombre' => $item->getNombre(),
            'email' => $item->getEmail(),
            'password' => $item->getPassword(),
            'created_at' => $this->formatDateTime($item->getCreatedAt()),
            'updated_at' => $this->formatDateTime($item->getUpdatedAt()),
            'deleted_at' =>  $this->formatDateTime($item->getDeletedAt())
        );
    }


    private function parseSensors($sensors): array
    {
        $arrayCollection = array();

        foreach($sensors as $item) {
            

            $arrayCollection[] = $this->parseSensor($item);
        }

        return $arrayCollection;
    }


    private function parseSensor($item): array
    {

        return array(
            'id' => $item->getId(),
            'name' => $item->getName()
        );
    }


    private function parseWines($wines): array
    {
        $arrayCollection = array();

        foreach($wines as $item) {

            $arrayCollection[] = $this->parseWine($item);
        }

        return $arrayCollection;
    }


    private function parseWine($item): array
    {

        return array(
            'id' => $item->getId(),
            'name' => $item->getName(),
            'year' => $item->getYear()
        );
    }


    private function parseMeasurings($measurings): array
    {
        $arrayCollection = array();

        foreach($measurings as $item) {

            $arrayCollection[] = $this->parseMeasuring($item);
        }

        return $arrayCollection;
    }


    private function parseMeasuring($item): array
    {

        return array(
            'id' => $item->getId(),
            'year' => $item->getYear(),
            'sensor' => null,
            'wine' => null,
            'color' => $item->getColor(),
            'temperature' => $item->getTemperature() ? number_format($item->getTemperature(),2,',','.') . ' ºC' : null,
            'graduation' => $item->getGraduation(),
            'PH' => $item->getPh()
        );
    }


    public function formatDateTime($datetime): string|null
    {

        return $datetime ? $datetime->format($this::DATE_FORMAT) : null;
    }
}
