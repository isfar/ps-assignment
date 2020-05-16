<?php

namespace App\Document\Validator;

use App\Document\Blacklist;
use App\Document\CountryCode;
use App\Document\DocumentType;
use App\Document\Length;
use App\Document\RequestLimit;
use App\Document\ValidityPeriod;
use App\Document\Weekdays;

class ConfigFactory
{
    public static function create(
        array $config
    ) {
        $service = new Config();
        
        if (isset($config['document_types']) && is_array($config['document_types'])) {
            $documentTypes = array_map(function ($type) {
                return new DocumentType(
                    $type['type'],
                    $type['from'] ?? null,
                    $type['till'] ?? null
                );
            }, $config['document_types']);
        }

        $service->setDocumentTypes($documentTypes ?? []);

        $service->setDateFormat($config['date_format']);

        if (isset($config['request_limit']) && is_array($config['request_limit'])) {
            $limit = $config['request_limit'];

            $service->setRequestLimit(new RequestLimit(
                $limit['max_attempts'],
                $limit['max_workdays'],
                $limit['workdays']
            ));
        }

        if (isset($config['validity_periods']) && is_array($config['validity_periods'])) {
            $validityPeriods = array_map(function ($period) {
                return new ValidityPeriod(
                    $period['year'],
                    $period['document_types']  ?? null,
                    $period['from'] ?? null,
                    $period['till'] ?? null
                );
            }, $config['validity_periods']);
        }

        $service->setValidityPeriods($validityPeriods ?? []);

        if (isset($config['workdays']) && is_array($config['workdays'])) {
            $workdays = array_map(function ($weekdays) {
                return new Weekdays(
                    $weekdays['days'],
                    $weekdays['from'] ?? null,
                    $weekdays['till'] ?? null
                );
            }, $config['workdays']);
        }

        $service->setWorkdays($workdays ?? []);

        if (isset($config['lengths']) && is_array($config['lengths'])) {
            $lengths = array_map(function ($length) {
                return new Length(
                    $length['length'] + 0,
                    $length['document_types']  ?? null,
                    $length['from'] ?? null,
                    $length['till'] ?? null
                );
            }, $config['lengths']);
        }

        $service->setIdLengths($lengths ?? []);

        if (isset($config['blacklists']) && is_array($config['blacklists'])) {
            $blacklists = array_map(function ($blacklist) {
                return new Blacklist(
                    $blacklist['document_types'],
                    $blacklist['min'] ?? null,
                    $blacklist['max'] ?? null
                );
            }, $config['blacklists']);
        }

        $service->setBlacklists($blacklists ?? []);
        $service->setCountryCodes(CountryCode::$list);
        
        return $service;
    }
}
