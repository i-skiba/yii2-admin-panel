### Подключение

backend|frontend/config/main.php
```
'bootstrap' => [
    'audit',
],

'modules' => [
    'audit' => [
        'class' => 'kamaelkz\yii2admin\v1\modules\audit\Module',
        // Перечень моделей для аудита
        'auditModels' => [
            'common\models\Post',
            'concepture\yii2handbook\models\DynamicElements',
        ],
    ],
],
```

AuditAction::actionName(),
AuditRollbackAction::actionName(),

'audit' => AuditAction::class,
'audit-rollback' => AuditRollbackAction::class,

'audit-dynamic-elements' => AuditDynamicElementsAction::class,
'audit-rollback' => AuditRollbackAction::class,
