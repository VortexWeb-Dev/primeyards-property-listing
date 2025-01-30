<?php

require_once __DIR__ . '/../crest/crest.php';

class SpaController
{
    public $entityTypeId;

    public function __construct($entityTypeId)
    {
        $this->entityTypeId = $entityTypeId;
    }

    public function listItems($filter = [], $select = ['*'], $limit = 50, $page = 1, $order = ['id' => 'desc'])
    {
        $start = ($page - 1) * $limit;

        $result = CRest::call(
            'department.get',
            [
                'entityTypeId' => self::$entityTypeId,
                'filter' => $filter,
                'select' => $select,
                'start' => $start,
                'limit' => $limit,
                'order' => $order
            ]
        );

        $items = $result['result']['items'] ?? [];
        $totalCount = $result['total'] ?? 0;

        return [
            'items' => $items,
            'totalCount' => $totalCount,
            'totalPages' => ceil($totalCount / $limit),
            'currentPage' => $page,
        ];
    }

    public function getItem($id, $select = ['*'])
    {
        $result = CRest::call(
            'crm.item.get',
            [
                'entityTypeId' => self::$entityTypeId,
                'id' => $id,
                'select' => $select
            ]
        );

        return $result['result']['item'] ?? [];
    }

    public function addItem($fields)
    {
        $result = CRest::call(
            'crm.item.add',
            [
                'entityTypeId' => self::$entityTypeId,
                'fields' => $fields
            ]
        );

        return $result['result']['item']['id'] ?? false;
    }

    public function updateItem($id, $fields)
    {
        $result = CRest::call(
            'crm.item.update',
            [
                'entityTypeId' => self::$entityTypeId,
                'id' => $id,
                'fields' => $fields
            ]
        );

        return isset($result['result']['item']['id']);
    }

    public function deleteItem($id)
    {
        $result = CRest::call(
            'crm.item.delete',
            [
                'entityTypeId' => self::$entityTypeId,
                'id' => $id
            ]
        );

        return isset($result['result']);
    }
}
