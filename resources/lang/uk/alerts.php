<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Мовні ресурси виведення сповіщень
    |--------------------------------------------------------------------------
    |
    | Наступні мовні ресурси використовуються для виведення
    | повідомлень в різних сценаріях CRUD.
    | Ви можете вільно змінювати ці мовні ресурси відповідно до вимог
    | вашої програми.
    |
    */

    'admin' => [
        'roles' => [
            'created' => 'Роль була успішно створена.',
            'deleted' => 'Роль була успішно вилучена.',
            'updated' => 'Роль була успішно оновлена.',
        ],

        'users' => [
            'cant_resend_confirmation' => 'В даний час програма налаштована на те, щоб вручну затверджувати користувачів.',
            'confirmation_email' => 'Нові параметри для підтвердження відправлені на вашу електронну пошту.',
            'confirmed' => 'Користувач успішно підтверджений.',
            'created' => 'Користувач був успішно створений.',
            'deleted' => 'Користувача успішно вилучено.',
            'deleted_permanently' => 'Користувач був стертий назавжди.',
            'restored' => 'Користувача успішно відновлено.',
            'session_cleared' => 'Сесія користувача була успішно очищена.',
            'social_deleted' => 'Соціальний обліковий запис успішно вилучено',
            'unconfirmed' => 'Користувач змінений на статус не підтверджений',
            'updated' => 'Параметри користувача успішно оновлені.',
            'updated_password' => 'Пароль користувача був успішно оновлений.',
        ],
    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Дякуємо! Ваша інформація прийнята і буде оброблена найближчим часом.',
        ],
    ],
];
