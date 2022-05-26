<?php

return [
    'form' => [
        'required' => 'Это обязательное поле',
        'status' => [
            'name' => [
                'unique' => 'Статус с таким именем уже существует',
            ]
        ],
        'task' => [
            'name' => [
                'unique' => 'Задача с таким именем уже существует',
            ]
        ]
    ],
    'flash' => [
        'status' => [
            'success' => [
                'create' => 'Статус успешно создан',
                'delete' => 'Статус успешно удалён',
                'update' => 'Статус успешно изменён',
            ],
            'fail' => [
                'delete' => 'Не удалось удалить статус',
            ]
        ],
        'task' => [
            'success' => [
                'create' => 'Задача успешно создана',
                'delete' => 'Задача успешно удалена',
                'update' => 'Задача успешно изменена',
            ],
        ]
    ],
    'ujs' => [
        'sure' => 'Вы уверены?',
    ]
];
