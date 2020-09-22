### Подключение

backend|frontend/config/main.php
```php
[
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
];
```

### Controller
```php
protected function getAccessRules()
{
    return ArrayHelper::merge(
        parent::getAccessRules(),
        [
            [
                'actions' => [
                    AuditAction::actionName(),
                    // AuditDynamicElementsAction::actionName(),
                    AuditRollbackAction::actionName(),
                ],
                'allow' => true,
                'roles' => [
                    UserRoleEnum::SUPERADMIN
                ],
            ]
        ]
    );
}

public function actions()
{
    $actions = parent::actions();

    return array_merge($actions,[
        AuditAction::actionName() => AuditAction::class,
        // AuditDynamicElementsAction::actionName() => AuditDynamicElementsAction::class,
        AuditRollbackAction::actionName() => AuditRollbackAction::class,
    ]);
}
```

### Views
```php
/** _form.php */
if (isset($originModel) && AuditService::isAuditAllowed(Post::class)) {
    $this->viewHelper()->pushPageHeader(
        [AuditAction::actionName(), 'id' => $originModel->id],
        Yii::t('yii2admin', 'Аудит'),
        'icon-eye'
    );
}

/** только для dynamic-elements: update-multiple.php */
if (AuditService::isAuditAllowed(DynamicElements::class)) {
    $this->viewHelper()->pushPageHeader(
        [AuditDynamicElementsAction::actionName(), 'ids' => Yii::$app->request->get('ids')],
        Yii::t('yii2admin', 'Аудит'),
        'icon-eye'
    );
}
```